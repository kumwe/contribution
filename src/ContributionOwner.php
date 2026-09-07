<?php

declare(strict_types=1);

namespace Kumwe\Contribution;

/**
 * Immutable owner identity; surface-specific identifier rules are supplied explicitly.
 *
 * This value proves spelling and namespace ownership only, never trust or authorization.
 *
 * @since 0.1.0
 */
final readonly class ContributionOwner
{
    /**
     * Reserved identity of the built-in contributor.
     *
     * @since 0.1.0
     */
    public const string CORE = 'core';

    /**
     * Hold a factory-validated canonical identity.
     *
     * @param string $identifier Canonical core or vendor/name identity.
     * @since 0.1.0
     */
    private function __construct(private string $identifier)
    {
    }

    /**
     * Create the built-in contributor identity.
     *
     * @return self Immutable core owner.
     * @since 0.1.0
     */
    public static function core(): self
    {
        return new self(self::CORE);
    }

    /**
     * Normalize a package contributor while preserving the established two-segment grammar.
     *
     * @param string $identifier Trimmed and lowercased; each segment is 1–63 ASCII characters.
     * @return self Immutable package owner.
     * @throws ContributionRejected For an invalid owner spelling or oversized raw input.
     * @since 0.1.0
     */
    public static function extension(string $identifier): self
    {
        if (strlen($identifier) > 1024) {
            throw new ContributionRejected('invalid_owner', 'Owner input exceeds 1024 bytes.');
        }
        $identifier = strtolower(trim($identifier));
        if (preg_match('/^[a-z0-9][a-z0-9._-]{0,62}\/[a-z0-9][a-z0-9._-]{0,62}$/D', $identifier) !== 1) {
            throw new ContributionRejected('invalid_owner', 'Owner must use the vendor/name grammar.');
        }

        return new self($identifier);
    }

    /**
     * Restore the exact stored core identity or normalize a package identity.
     *
     * @param string $identifier Stored identifier; only the exact string core selects core.
     * @return self Validated owner.
     * @throws ContributionRejected For an invalid package identity.
     * @since 0.1.0
     */
    public static function fromString(string $identifier): self
    {
        return $identifier === self::CORE ? self::core() : self::extension($identifier);
    }

    /**
     * Return the stable serialization used to compare and persist owners.
     *
     * @return string Core or canonical vendor/name.
     * @since 0.1.0
     */
    public function identifier(): string
    {
        return $this->identifier;
    }

    /**
     * Produce the exact dotted namespace without repairing historically valid package dots.
     *
     * @return string Core or vendor.name, retaining each package segment's spelling.
     * @since 0.1.0
     */
    public function namespace(): string
    {
        return str_replace('/', '.', $this->identifier);
    }

    /**
     * Compare canonical owner identities, not object identity or dotted prefixes.
     *
     * @param self $other Owner to compare.
     * @return bool Whether both values describe the same contributor.
     * @since 0.1.0
     */
    public function equals(self $other): bool
    {
        return $this->identifier === $other->identifier;
    }

    /**
     * Validate ownership using the surface policy explicitly chosen by the consumer.
     *
     * @param string $identifier Complete contribution identifier.
     * @param SurfaceIdentifierPolicy $policy This surface's bounded identifier policy.
     * @return void
     * @throws ContributionRejected For invalid spelling or a foreign namespace.
     * @since 0.1.0
     */
    public function assertOwns(string $identifier, SurfaceIdentifierPolicy $policy): void
    {
        $policy->assertOwns($this, $identifier);
    }
}
