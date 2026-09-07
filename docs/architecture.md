# Architecture

ContributionDefinition and ContributionSurface are extension points. ContributionOwner and SurfaceIdentifierPolicy are immutable final values. OwnedContributionRegistry is a bounded mutable data collection. ContributionRejected is the typed InvalidArgumentException subtype. All six types have one canonical namespace.

Only PHP is required. No SDK/App, database, framework, rendering, canonical JSON or native dependency. No provider: the Contribution-specific brief specifies direct construction. There is no service locator, global registry or runtime kind dispatch.

Owner equality compares the canonical string: `a.b/c` and `a/b.c` have the same dotted prefix but remain different owners. Duplicate keys always fail; lookup/removal require exact owner matches. The host must authorize the supplied owner.

Registration validates identity/capacity, obtains the data export once, validates bounds, recursively reconstructs arrays to detach PHP references, then stores and sorts using SORT_STRING. No executable implementation is stored. Document field order and numeric values are preserved; this is snapshotting, not canonicalization.

App retains OwnedRuntimeContributionRegistry, executable type checking/dispatch, trusted active registries, lifecycle reconciliation and recovery. SDK must depend inward on a verified Contribution release in a separate task before App adoption. No old FQCN alias or copied fallback is permitted.

CI checks canonical PSR-4 ownership, strict types, the PHP-only dependency ceiling, no external qualified types or runtime alias/fallback selection, and reflection agreement for every public signature/property/constant.
