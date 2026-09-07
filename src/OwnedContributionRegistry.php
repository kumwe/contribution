<?php

declare(strict_types=1);

namespace Kumwe\Contribution;

/**
 * Bounded, data-only inventory for one explicit surface, ordered bytewise by complete identifier.
 *
 * Registration snapshots exports and retains no implementation objects. This local mutable collection
 * has no persistence, locking, trust or lifecycle authority; use a separate instance per composition.
 *
 * @since 0.1.0
 */
final class OwnedContributionRegistry implements ContributionSurface
{
    /**
     * Data-only entries keyed by the identifier frozen during registration.
     *
     * @var array<string, array{owner: ContributionOwner, definition: array<string, mixed>}>
     * @since 0.1.0
     */
    private array $entries = [];

    /**
     * Create an empty bounded inventory with no implicitly selected surface rules.
     *
     * @param SurfaceIdentifierPolicy $policy The exact policy for this independent surface.
     * @param int $maximumEntries Capacity, 1–10000 entries, checked before any mutation.
     * @throws ContributionRejected For an invalid capacity.
     * @since 0.1.0
     */
    public function __construct(
        private readonly SurfaceIdentifierPolicy $policy,
        private readonly int $maximumEntries = 1000,
    ) {
        if ($maximumEntries < 1 || $maximumEntries > 10000) {
            throw new ContributionRejected('invalid_policy', 'Registry capacity must be between 1 and 10000.');
        }
    }

    /**
     * Snapshot a valid definition atomically; duplicates never replace any existing owner's entry.
     *
     * @param ContributionOwner $owner Contributor claiming the identifier.
     * @param ContributionDefinition $definition Deterministic data-only declaration to snapshot once.
     * @return void
     * @throws ContributionRejected For foreign/invalid IDs, duplicates, invalid documents or exhausted bounds.
     * @since 0.1.0
     */
    public function register(ContributionOwner $owner, ContributionDefinition $definition): void
    {
        $identifier = $definition->identifier();
        $this->policy->assertOwns($owner, $identifier);
        if (isset($this->entries[$identifier])) {
            throw new ContributionRejected('duplicate_identifier', 'Contribution identifier is already registered.');
        }
        if (count($this->entries) >= $this->maximumEntries) {
            throw new ContributionRejected('limit_exceeded', 'Contribution registry capacity is exhausted.');
        }
        $document = $definition->toArray();
        foreach (array_keys($document) as $key) {
            if (!is_string($key)) {
                throw new ContributionRejected('invalid_definition', 'Definition requires string field names.');
            }
        }
        $nodes = 0;
        $bytes = 0;
        /** @var array<string, mixed> $snapshot */
        $snapshot = self::snapshotValue($document, 0, $nodes, $bytes);
        // The consumer's toArray() may re-enter this registry. Recheck the commit conditions after
        // the last consumer call, so a nested registration cannot be overwritten or exceed capacity.
        if (isset($this->entries[$identifier])) {
            throw new ContributionRejected('duplicate_identifier', 'Contribution identifier is already registered.');
        }
        if (count($this->entries) >= $this->maximumEntries) {
            throw new ContributionRejected('limit_exceeded', 'Contribution registry capacity is exhausted.');
        }
        $this->entries[$identifier] = ['owner' => $owner, 'definition' => $snapshot];
        ksort($this->entries, SORT_STRING);
    }

    /**
     * Look up a snapshot using the exact owner, hiding missing and foreign entries identically.
     *
     * @param ContributionOwner $owner Expected owner, compared by canonical identifier.
     * @param string $identifier Complete registered identifier.
     * @return array<string, mixed>|null Data copy, or null when absent or foreign.
     * @since 0.1.0
     */
    public function definition(ContributionOwner $owner, string $identifier): ?array
    {
        $entry = $this->entries[$identifier] ?? null;

        return $entry !== null && $entry['owner']->equals($owner) ? $entry['definition'] : null;
    }

    /**
     * Export all snapshots in stable identifier order.
     *
     * @return list<array<string, mixed>> Registered data copies; nested document order is preserved.
     * @since 0.1.0
     */
    public function definitions(): array
    {
        return array_values(array_map(static fn (array $entry): array => $entry['definition'], $this->entries));
    }

    /**
     * Export snapshots with the exact registered owner; payload owner-shaped fields have no authority.
     *
     * @return list<array{owner: ContributionOwner, definition: array<string, mixed>}> Identifier-ordered data copies.
     * @since 0.1.0
     */
    public function entries(): array
    {
        return array_values($this->entries);
    }

    /**
     * Export only one contributor's snapshots in stable identifier order.
     *
     * @param ContributionOwner $owner Contributor whose entries are requested.
     * @return list<array<string, mixed>> Data copies; empty when the contributor has no entries.
     * @since 0.1.0
     */
    public function ownedBy(ContributionOwner $owner): array
    {
        $result = [];
        foreach ($this->entries as $entry) {
            if ($entry['owner']->equals($owner)) {
                $result[] = $entry['definition'];
            }
        }

        return $result;
    }

    /**
     * Remove only exact owner matches; missing owners are harmless and remaining order is unchanged.
     *
     * @param ContributionOwner $owner Contributor whose entries are removed.
     * @return void
     * @since 0.1.0
     */
    public function remove(ContributionOwner $owner): void
    {
        foreach ($this->entries as $identifier => $entry) {
            if ($entry['owner']->equals($owner)) {
                unset($this->entries[$identifier]);
            }
        }
    }

    /**
     * Enforce bounded data-only exports without introducing canonicalization or hash semantics.
     *
     * @param mixed $value Current document node.
     * @param int $depth Current array nesting, root zero.
     * @param int $nodes Visited node counter, updated before traversal.
     * @param int $bytes Cumulative string and key bytes, updated before traversal.
     * @return mixed Validated value reconstructed without PHP references.
     * @throws ContributionRejected For executable values, non-finite numbers or exceeded resource bounds.
     * @since 0.1.0
     */
    private static function snapshotValue(mixed $value, int $depth, int &$nodes, int &$bytes): mixed
    {
        $nodes++;
        if ($depth > 32 || $nodes > 10000 || $bytes > 1048576) {
            throw new ContributionRejected('limit_exceeded', 'Definition document exceeds its traversal bounds.');
        }
        if (is_array($value)) {
            $copy = [];
            foreach ($value as $key => $child) {
                $bytes += is_string($key) ? strlen($key) : 0;
                $copy[$key] = self::snapshotValue($child, $depth + 1, $nodes, $bytes);
            }

            return $copy;
        } elseif (is_string($value)) {
            $length = strlen($value);
            $bytes += $length;
            if ($length > 65536 || $bytes > 1048576) {
                throw new ContributionRejected('limit_exceeded', 'Definition strings exceed their byte bounds.');
            }
        } elseif (is_float($value)) {
            if (!is_finite($value)) {
                throw new ContributionRejected('invalid_definition', 'Definition numbers must be finite.');
            }
        } elseif ($value !== null && !is_bool($value) && !is_int($value)) {
            throw new ContributionRejected('invalid_definition', 'Definition exports must contain only data.');
        }

        return $value;
    }
}
