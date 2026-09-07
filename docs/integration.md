# Extraction and adoption

App baseline: `960ce8ec00cf724a7cae03e5ba09c4852c9ab54e`. Locked SDK: v0.2.4 at `d0484b8733eaa57d076f567ffa5e997b9564b5fa`. Exact released ContributionOwner, ContributionDefinition and ExtensionIdentifier source was inspected. App capability-index digest: `87ded886f35f74878ca9eb8db4c36e23d681c4a49891f76dfc3210f385a7ce39`.

## Ownership

| Source | Target or retained owner |
|---|---|
| SDK src/Spi/Contribution/ContributionOwner.php | Kumwe\Contribution\ContributionOwner; package-owner grammar preserved from ExtensionIdentifier without SDK dependency. Manifest ExtensionIdentifier remains SDK. |
| SDK src/Spi/Contribution/ContributionDefinition.php | Kumwe\Contribution\ContributionDefinition; identifier()/toArray() contract preserved. |
| App src/Extension/Contribution/ContributionSurface.php | Kumwe\Contribution\ContributionSurface, parameter changed to canonical owner. |
| App OwnedRuntimeContributionRegistry data ordering/inventory/removal | OwnedContributionRegistry neutral data snapshots. App retains its executable registry, implementation typing and lookup; this is not a replacement host class. |
| SDK STUDIO_KINDS/GRAPHICAL_KINDS/capability exception | Explicit SurfaceIdentifierPolicy chosen per consumer; no host-specific list in package. |
| App ExtensionContributionRegistrySet, CanonicalManifestActivator/Interpreter, OwnedExtensionBindingRegistrar, core/delivery registrars | Retained App authority, with canonical imports and explicit policy composition only in later adoption. |

## Clean break CB-CONTRIBUTION-001

assertOwns(string, string kind) becomes assertOwns(string, SurfaceIdentifierPolicy). Surface names no longer choose grammar/exemptions. Graphical dotted rules use dotted(surface); typed integration IDs use versioned:true; core capability exemption uses unnamespacedCore:true only on that surface. Slash document surfaces configure exact core namespace aliases and index prefixes explicitly. Separate policies describe indexed/unindexed forms; nonempty kind lists require a prefix.

Former prefix-only checks admitted unbounded/malformed suffixes. This release deliberately refuses whitespace/controls, empty/trailing/repeated suffix separators, path traversal, illegal punctuation and excess size. Owner normalization/segment grammar and safe namespace behavior remain. Data registry exports are bounded detached snapshots, not executable objects.

## Sequenced follow-up

1. Human merge, automated release, then external verification of archive/Packagist/manifests/clean consumer. This Phase 1 does not claim publication.
2. Separate SDK task: exact-pin verified Contribution; replace all owner/definition imports/signatures; remove old SDK source classes and implementation tests; supply explicit policies at every assertOwns call; rebuild public API fixtures/scaffold templates/schema checks. Release and independently verify the SDK successor. No aliases.
3. Separate App task: exact-pin both verified releases, update Composer via supported tooling, replace canonical imports, migrate ContributionSurface, compose explicit policies and retain host active/executable registries. No retired SDK FQCN may remain installed. Update capability index, migration/governance records and changelog/evidence atomically.
4. Retain App lifecycle/admission/trust, active-generation, recovery, route/navigation, persistence and rendering integration tests. Split only generic owner/data assertions upstream; executable-registry tests stay with App.

SDK source is an extraction input, not a runtime dependency. No downstream consumer may treat this package PR as completed SDK/App migration. Exact consumer inventory is shipped in docs/consumer-inventory.json; refresh it and compare source baselines before adoption.
