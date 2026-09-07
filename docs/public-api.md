# Public API

Version 0.1.0, PHP 8.5. Limits count bytes. These APIs perform no I/O, authorization or transactions. Immutable
owner/policy values can be shared; registries are local mutable collections without concurrent-writer/process
guarantees. No owner is a trust credential. Package diagnostics omit submitted identifiers and payloads.

## `Kumwe\Contribution\ContributionOwner`

Final readonly value, private constructor. `CORE` is `core`.

- `core(): self`: Construct the immutable built-in contributor without side effects.
- `extension(string $identifier): self`: Refuse raw input above 1024 bytes, trim/lowercase, require two
  slash-separated segments each matching `[a-z0-9][a-z0-9._-]{0,62}`. Throws ContributionRejected reason
  invalid_owner. Repeated/trailing package dots accepted by the source grammar remain valid.
- `fromString(string $identifier): self`: Exact core restores core; all other inputs follow extension(). Core and
  whitespace-padded core remain invalid.
- `identifier(): string`: Stable stored form: core or normalized vendor/name.
- `namespace(): string`: Replace slash with dot, preserving other spelling; not a unique owner identity by itself.
- `equals(self $other): bool`: Compare canonical owner identifiers, without mutation.
- `assertOwns(string $identifier, SurfaceIdentifierPolicy $policy): void`: Delegate to explicit policy;
  invalid_identifier/owner_mismatch propagate. No kind-string inference.

Round-trip with fromString(identifier()). Native PHP object serialization is not a cross-version contract.

## `Kumwe\Contribution\ContributionDefinition`

Interface. `identifier(): string` returns a stable complete contribution ID. `toArray(): array` returns `array<string,
mixed>` with every declared field in deterministic order. Implementers must perform bounded, side-effect-free work:
validating the returned export cannot sandbox arbitrary implementation code.

Snapshots accept nested arrays, strings, integers, finite floats, booleans and null. Objects, resources, non-finite
floats, non-string top-level keys and exceeded bounds fail. The registry invokes each method once on successful
registration; implementation-thrown exceptions propagate before state changes. No original object or reference is
retained.

## `Kumwe\Contribution\ContributionSurface`

Interface. `ownedBy(ContributionOwner $owner): array` returns `list<mixed>` in its surface's documented export shape,
empty when absent. `remove(ContributionOwner $owner): void` removes exact owner matches only; absence is a no-op. Host
code authorizes the owner and lifecycle timing. The package registry refines exports to declaration document
snapshots.

## `Kumwe\Contribution\SurfaceIdentifierPolicy`

Final readonly value, private constructor. No provider/global registry or spelling-triggered behavior.

- `dotted(string $surface, bool $versioned = false, bool $unnamespacedCore = false): self`: Surface matches
  `[a-z][a-z0-9._-]{0,79}`. Exact owner namespace plus dot precedes a suffix of nonempty dot-separated
  `[a-z0-9][a-z0-9_-]*` segments. versioned additionally permits colon and at-sign after each segment's initial
  character. unnamespacedCore permits valid unprefixed IDs only for core. Invalid surface throws invalid_policy.
- `slash(string $surface, array $coreNamespaces = [ContributionOwner::CORE], array $indexKinds = []): self`: Same
  surface grammar. Core aliases are a unique list of 1–16 dotted safe namespaces, each ≤127 bytes. Package
  namespace always derives from its owner. Kinds are a unique list of 0–32 `[a-z][a-z0-9_-]{0,63}` strings; empty
  means unprefixed namespace/local, nonempty requires one allowed kind plus one space. Local suffix follows strict
  dotted segment grammar. Malformed/duplicate/excessive options throw invalid_policy.
- `surface(): string`: Return explicit diagnostic identity without side effects.
- `assertOwns(ContributionOwner $owner, string $identifier): void`: Require 1–256 printable ASCII bytes, never trim
  or normalize. Validate optional index prefix, exact namespace boundary and suffix. Throws invalid_identifier or
  owner_mismatch; does not authorize.

Example: slash('documents', ['core', 'design.core'], ['block']) accepts `block design.core/hero` for core. Unrelated
policies do not inherit this alias or kind. Public factory array parameters are lists of strings and invalid runtime
element types are rejected.

## `Kumwe\Contribution\OwnedContributionRegistry`

Final mutable registry implementing ContributionSurface. No executable implementation, callbacks, persistence, locks,
transactions or dispatch are retained.

- `__construct(SurfaceIdentifierPolicy $policy, int $maximumEntries = 1000)`: Create empty registry with explicit
  immutable policy. Capacity 1–10000 or invalid_policy.
- `register(ContributionOwner $owner, ContributionDefinition $definition): void`: Validate ID, refuse duplicates,
  check capacity, read document once, validate/detach data, publish, sort. Limits: depth ≤32 with root zero,
  ≤10000 visited nodes including root/scalars, each string ≤65536 bytes, combined string/key bytes ≤1048576. No
  numeric coercion/canonicalization. Throws duplicate_identifier, limit_exceeded, invalid_definition or policy
  refusal; implementation exceptions propagate. Every refusal is atomic.
- `definition(ContributionOwner $owner, string $identifier): ?array`: Exact-owner lookup returns array<string,mixed>
  copy or null for absent/foreign entry. Frozen ID is unaffected by later changes to original object.
- `definitions(): array`: list<array<string,mixed>> snapshots in bytewise identifier order; nested document order
  preserved.
- `entries(): array`: list<array{owner:ContributionOwner,definition:array<string,mixed>}> in the same order. Recorded
  owner is distinct from payload owner-shaped fields.
- `ownedBy(ContributionOwner $owner): array`: Exact owner's snapshots in stable order, empty when absent.
- `remove(ContributionOwner $owner): void`: Remove exact matches only; missing owner no-op, remaining order preserved,
  capacity reusable.

Core exceptions and dotted owner collisions cannot overwrite keys: duplicates always fail, including same-owner
registration. Commit conditions are rechecked after a consumer's toArray() call: a reentrant registration cannot
overwrite an inner entry or exceed capacity. A rejected outer registration performs no own mutation; independent side
effects caused by consumer code are not rolled back. Data copies recursively detach references; returned arrays cannot
mutate stored state. Owner strings do not authenticate callers.

## `Kumwe\Contribution\ContributionRejected`

Final InvalidArgumentException subtype. `__construct(string $reason, string $message)` records immutable public
`$reason` and diagnostic message without retaining submitted data. Package-emitted reasons: invalid_owner,
invalid_policy, invalid_identifier, owner_mismatch, duplicate_identifier, limit_exceeded, invalid_definition. Standard
inherited exception inspection retains PHP behavior; consumers inspect `$reason` instead of parsing messages.
