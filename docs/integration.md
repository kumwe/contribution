# Core contract and integration

Historical source baseline (verify drift against current Core): `960ce8ec00cf724a7cae03e5ba09c4852c9ab54e`.
Examined SDK: v0.2.4 at
`d0484b8733eaa57d076f567ffa5e997b9564b5fa`. Exact released ContributionOwner, ContributionDefinition and
ExtensionIdentifier source was inspected. App capability-index digest:
`87ded886f35f74878ca9eb8db4c36e23d681c4a49891f76dfc3210f385a7ce39`.

## Ownership

- SDK src/Spi/Contribution/ContributionOwner.php: Kumwe\Contribution\ContributionOwner; package-owner grammar
  preserved from ExtensionIdentifier without SDK dependency. Manifest ExtensionIdentifier remains SDK.
- SDK src/Spi/Contribution/ContributionDefinition.php: Kumwe\Contribution\ContributionDefinition;
  identifier()/toArray() contract preserved.
- App src/Extension/Contribution/ContributionSurface.php: Kumwe\Contribution\ContributionSurface, parameter changed to
  canonical owner.
- App OwnedRuntimeContributionRegistry data ordering/inventory/removal: OwnedContributionRegistry neutral data
  snapshots. App retains its executable registry, implementation typing and lookup; this is not a replacement host
  class.
- SDK STUDIO_KINDS/GRAPHICAL_KINDS/capability exception: Explicit SurfaceIdentifierPolicy chosen per consumer; no
  host-specific list in package.
- App ExtensionContributionRegistrySet, CanonicalManifestActivator/Interpreter, OwnedExtensionBindingRegistrar,
  core/delivery registrars: Retained App authority, with canonical imports and explicit policy composition.

## Clean break CB-CONTRIBUTION-001

assertOwns(string, string kind) becomes assertOwns(string, SurfaceIdentifierPolicy). Surface names no longer choose
grammar/exemptions. Graphical dotted rules use dotted(surface); typed integration IDs use versioned:true; core
capability exemption uses unnamespacedCore:true only on that surface. Slash document surfaces configure exact core
namespace aliases and index prefixes explicitly. Separate policies describe indexed/unindexed forms; nonempty kind
lists require a prefix.

Former prefix-only checks admitted unbounded/malformed suffixes. This release deliberately refuses
whitespace/controls, empty/trailing/repeated suffix separators, path traversal, illegal punctuation and excess size.
Raw owner input now has a 1024-byte bound before normalization. Owner normalization/segment grammar and safe namespace
behavior remain. Data registry exports are bounded detached snapshots, not executable objects.

The generic SDK SpiPortTest methods to split are testContributionOwnerBoundsItsNamespace,
testOwnerBoundaryRejectsRepeatedDotsInTheContributionSuffix and testLegacyOwnerDotSpellingsRemainRepresentable.
Keep their concrete surface-constructor assertions in SDK; package tests own the generic owner/policy invariants.

## Consumer verification

Core consumes the canonical types directly or through a compatible Extension SDK release. Exact-pin the verified
package dependencies and regenerate Composer locks and the capability index from the installed graph. SDK owner and
definition types must have one canonical owner; do not add aliases, remaps or copied implementations.

When replacing historical types, review the source inventory and current API/scaffold fixtures, supply explicit
policies at each assertOwns call, and preserve active executable registries and trusted lifecycle composition.
Do not treat the neutral snapshot registry as a replacement for an executable runtime registry.

Core retains lifecycle/admission/trust, active-generation, recovery, route/navigation, persistence and rendering
integration tests. Package tests own lexical/policy, snapshot, isolation and hostile-bound invariants. SDK retains
manifest and concrete surface-constructor tests. Remove implementation-only tests with their retired implementation
after verified replacement; split mixed assertions by responsibility.

The SDK source baseline is provenance, not a runtime dependency. The exact source closure is retained in
[consumer-inventory.json](consumer-inventory.json); compare current consumers before changing their imports.
Follow [releasing](releasing.md) for publication and independent artifact verification requirements. Published package
availability does not establish Core integration completion.
