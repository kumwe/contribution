<?php

declare(strict_types=1);

namespace Kumwe\Contribution;

/**
 * Immutable per-surface policy with bounded dotted or slash identities and explicit core exceptions.
 *
 * Surface names are diagnostic identities only; they never select behavior. No registry, callback,
 * global state or host-specific kind is consulted.
 *
 * @since 0.1.0
 */
final readonly class SurfaceIdentifierPolicy
{
    /**
     * Capture validated policy options, constructed only through the named grammar factories.
     *
     * @param string $surface Bounded diagnostic surface identity.
     * @param string $separator Namespace boundary, dot or slash.
     * @param bool $versioned Allow colon and at-sign markers within a dotted suffix.
     * @param bool $unnamespacedCore Allow valid dotted identifiers without a core prefix for core only.
     * @param list<string> $coreNamespaces Explicit namespaces core may claim under slash grammar.
     * @param list<string> $indexKinds Exact permitted index prefixes; empty means no index prefix.
     * @since 0.1.0
     */
    private function __construct(
        private string $surface,
        private string $separator,
        private bool $versioned,
        private bool $unnamespacedCore,
        private array $coreNamespaces,
        private array $indexKinds,
    ) {
        if (preg_match('/^[a-z][a-z0-9._-]{0,79}$/D', $surface) !== 1) {
            throw new ContributionRejected('invalid_policy', 'Surface identity must be 1–80 bounded ASCII bytes.');
        }
    }

    /**
     * Choose dotted owner.suffix identifiers with optional typed markers and an explicit core exemption.
     *
     * @param string $surface Diagnostic surface identity; lowercase ASCII, 1–80 bytes.
     * @param bool $versioned Permit colon and at-sign markers after a suffix segment's first character.
     * @param bool $unnamespacedCore Permit unprefixed identifiers for core, never for package owners.
     * @return self Immutable dotted policy.
     * @throws ContributionRejected For an invalid surface identity.
     * @since 0.1.0
     */
    public static function dotted(string $surface, bool $versioned = false, bool $unnamespacedCore = false): self
    {
        return new self($surface, '.', $versioned, $unnamespacedCore, [ContributionOwner::CORE], []);
    }

    /**
     * Choose namespace/local-name identifiers, optionally indexed by an explicitly allowed kind and space.
     *
     * @param string $surface Diagnostic surface identity; lowercase ASCII, 1–80 bytes.
     * @param list<string> $coreNamespaces One to 16 explicit dotted namespaces accepted for core.
     * @param list<string> $indexKinds Zero to 32 allowed lowercase index kinds; a nonempty list requires one.
     * @return self Immutable slash policy; package namespaces are always derived from their owner.
     * @throws ContributionRejected For malformed, duplicate or excessive policy options.
     * @since 0.1.0
     */
    public static function slash(
        string $surface,
        array $coreNamespaces = [ContributionOwner::CORE],
        array $indexKinds = [],
    ): self {
        if (
            !array_is_list($coreNamespaces) || $coreNamespaces === [] || count($coreNamespaces) > 16
            || !array_is_list($indexKinds) || count($indexKinds) > 32
        ) {
            throw new ContributionRejected('invalid_policy', 'Policy namespace and kind lists exceed their bounds.');
        }
        $seen = [];
        foreach ($coreNamespaces as $namespace) {
            if (
                !is_string($namespace) || strlen($namespace) > 127
                || preg_match('/^[a-z0-9][a-z0-9_-]*(?:\.[a-z0-9][a-z0-9_-]*)*$/D', $namespace) !== 1
                || isset($seen[$namespace])
            ) {
                throw new ContributionRejected('invalid_policy', 'Core namespace aliases must be unique and bounded.');
            }
            $seen[$namespace] = true;
        }
        $seen = [];
        foreach ($indexKinds as $kind) {
            if (
                !is_string($kind) || preg_match('/^[a-z][a-z0-9_-]{0,63}$/D', $kind) !== 1
                || isset($seen[$kind])
            ) {
                throw new ContributionRejected('invalid_policy', 'Index kinds must be unique bounded identifiers.');
            }
            $seen[$kind] = true;
        }

        return new self($surface, '/', false, false, $coreNamespaces, $indexKinds);
    }

    /**
     * Return the diagnostic identity without inferring behavior from its spelling.
     *
     * @return string Explicit surface identity.
     * @since 0.1.0
     */
    public function surface(): string
    {
        return $this->surface;
    }

    /**
     * Refuse malformed identifiers and identifiers outside the expected owner's exact namespace.
     *
     * @param ContributionOwner $owner Expected contributor; no authorization is implied.
     * @param string $identifier Complete identifier, at most 256 ASCII bytes, never trimmed or normalized.
     * @return void
     * @throws ContributionRejected With invalid_identifier or owner_mismatch; input is never echoed.
     * @since 0.1.0
     */
    public function assertOwns(ContributionOwner $owner, string $identifier): void
    {
        if ($identifier === '' || strlen($identifier) > 256 || preg_match('/[^\x20-\x7E]/', $identifier) === 1) {
            throw new ContributionRejected('invalid_identifier', 'Contribution identifier is empty or out of bounds.');
        }
        $identity = $identifier;
        if ($this->indexKinds !== []) {
            $space = strpos($identifier, ' ');
            if ($space === false || !in_array(substr($identifier, 0, $space), $this->indexKinds, true)) {
                throw new ContributionRejected('invalid_identifier', 'Contribution index kind is not permitted.');
            }
            $identity = substr($identifier, $space + 1);
        }
        $namespaces = $owner->identifier() === ContributionOwner::CORE && $this->separator === '/'
            ? $this->coreNamespaces : [$owner->namespace()];
        $suffix = null;
        foreach ($namespaces as $namespace) {
            $prefix = $namespace . $this->separator;
            if (str_starts_with($identity, $prefix)) {
                $suffix = substr($identity, strlen($prefix));
                break;
            }
        }
        if ($suffix === null && $owner->identifier() === ContributionOwner::CORE && $this->unnamespacedCore) {
            $suffix = $identity;
        }
        if ($suffix === null) {
            throw new ContributionRejected('owner_mismatch', 'Contribution namespace does not belong to its owner.');
        }
        $pattern = $this->versioned
            ? '/^[a-z0-9][a-z0-9_:@-]*(?:\.[a-z0-9][a-z0-9_:@-]*)*$/D'
            : '/^[a-z0-9][a-z0-9_-]*(?:\.[a-z0-9][a-z0-9_-]*)*$/D';
        if (preg_match($pattern, $suffix) !== 1) {
            throw new ContributionRejected('invalid_identifier', 'Contribution suffix does not match its policy.');
        }
    }
}
