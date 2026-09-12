---
schema: kumwe-package-release-record/v1
artifact_kind: framework_php
migration_id: KUMWE-MIG-2026-006
change_set: KUMWE-CS-2026-006
source:
  app:
    repository: https://github.com/kumwe/app
    baseline_commit: 960ce8ec00cf724a7cae03e5ba09c4852c9ab54e
    examined_paths:
    - src/Extension/Contribution
    - src
    - tests
    - config
    - bootstrap
    - examples
    - tools
    - docs/architecture
    - composer.json
    - composer.lock
    - AGENTS.md
    old_namespace_roots: []
    capability_index_sha256: 87ded886f35f74878ca9eb8db4c36e23d681c4a49891f76dfc3210f385a7ce39
  semantic_inputs: []
  examined_dependencies:
  - SDK v0.2.4 source d0484b8733eaa57d076f567ffa5e997b9564b5fa is extraction input only.
  - Exact owner/definition/identifier and SpiPortTest source inspected; see docs/integration.md.
  - Conversion v0.1.2 and Producer v0.2.0 have no contribution identity/registry owner.
  - 'No Kumwe runtime dependency: bounded snapshots need no canonical encoding or digest.'
target:
  repository: https://github.com/kumwe/contribution
  artifact_identity: kumwe/contribution
  canonical_namespace_or_abi: Kumwe\Contribution
ownership:
  responsibility: Neutral owners, explicit surface policies and deterministic owner-scoped data registries.
  non_responsibilities:
  - Trust, authorization, lifecycle admission and active runtime generation.
  - Executable implementation storage, dispatch, routing and rendering.
  - Persistence, transactions, canonical JSON and cryptographic digests.
  - SDK or App implementation and container registration.
  allowed_dependency_ceiling: []
  implementation_owner: kumwe/contribution
  next_consumer: kumwe/extension-sdk
  public_manifests:
  - path: resources/public-api/v1.json
    sha256: 85202012eef68919fd3eed8894e5e17d7760dbc2a751d65ae244f3a2abea2cf6
  - path: resources/capabilities/v1.json
    sha256: e50defb725e5f03e74480fe8b6965ff020147be57dedd5915a495f6175c2f785
  - path: resources/service-map/v1.json
    sha256: 12d4602942c1ebd9f01e5046f7c7f3457f673fb1b655c3b4c95399ff085ef742
  intentionally_excluded:
  - App retains executable registry typing/storage/dispatch and trusted active authority.
  - App retains lifecycle/trust/manifest reconciliation, core/delivery registrars and recovery.
  - SDK retains ExtensionIdentifier for manifests; Contribution owns its neutral owner value.
  - Canonical JSON, hashes, native execution, container services and persistence.
framework_php:
  composer_package: kumwe/contribution
  canonical_namespace: Kumwe\Contribution
  public_api_manifest: resources/public-api/v1.json
  capability_manifest: resources/capabilities/v1.json
  service_map: resources/service-map/v1.json
  extracted_symbols:
  - old_fqcn: Kumwe\Extension\Spi\Contribution\ContributionOwner
    new_fqcn: Kumwe\Contribution\ContributionOwner
    source_path: src/Spi/Contribution/ContributionOwner.php
    target_path: src/ContributionOwner.php
    kind: class
    public_methods:
    - assertOwns
    - core
    - equals
    - extension
    - fromString
    - identifier
    - namespace
    public_properties: []
    public_constants:
    - CORE
    exceptions:
    - Kumwe\Contribution\ContributionRejected
    serialization_contract: 'identifier()/fromString(): core or normalized vendor/name.'
    compatibility: 'CB-CONTRIBUTION-001: explicit policy and raw input bound; lexical owner grammar preserved.'
  - old_fqcn: Kumwe\Extension\Spi\Contribution\ContributionDefinition
    new_fqcn: Kumwe\Contribution\ContributionDefinition
    source_path: src/Spi/Contribution/ContributionDefinition.php
    target_path: src/ContributionDefinition.php
    kind: interface
    public_methods:
    - identifier
    - toArray
    public_properties: []
    public_constants: []
    exceptions:
    - Kumwe\Contribution\ContributionRejected
    serialization_contract: null
    compatibility: Contract signatures preserved under canonical namespace.
  - old_fqcn: Kumwe\App\Extension\Contribution\ContributionSurface
    new_fqcn: Kumwe\Contribution\ContributionSurface
    source_path: src/Extension/Contribution/ContributionSurface.php
    target_path: src/ContributionSurface.php
    kind: interface
    public_methods:
    - ownedBy
    - remove
    public_properties: []
    public_constants: []
    exceptions:
    - Kumwe\Contribution\ContributionRejected
    serialization_contract: null
    compatibility: Owner parameter moves to canonical package value.
  consumers:
    app_code:
    - src/Administrator/Automation/ContributedJobFormCompiler.php
    - src/Administrator/Http/Handler/AdministratorDashboardHandler.php
    - src/Administrator/Http/Handler/AdministratorDashboardPreferencesHandler.php
    - src/Administrator/Navigation/AdministratorNavigationRegistry.php
    - src/Administrator/Presentation/AdministratorRenderer.php
    - src/Application/Automation/JobExecutionScope.php
    - src/Application/Presentation/Dashboard/DashboardPreferenceService.php
    - src/Application/Presentation/Preference/PresentationPreferenceManager.php
    - src/Application/Presentation/Preference/PresentationPreferencePolicy.php
    - src/Application/Presentation/Preference/PresentationPreferenceRepository.php
    - src/Application/Presentation/Preference/RegisteredPresentationPreferencePolicy.php
    - src/BusinessIntegration/Application/DurableOutboundAdapterDispatcher.php
    - src/BusinessIntegration/Application/ValidatedContributedJobHandler.php
    - src/BusinessIntegration/Domain/QueueContributionDefinition.php
    - src/BusinessIntegration/Domain/ScheduleContributionDefinition.php
    - src/BusinessIntegration/Infrastructure/ContributedQueueRuntimePolicyCatalog.php
    - src/BusinessIntegration/Infrastructure/ContributedScheduleSynchronizer.php
    - src/BusinessIntegration/Infrastructure/RuntimeIntegrationEventTransport.php
    - src/BusinessRecord/Domain/MoneyRateProviderDefinition.php
    - src/BusinessReporting/Domain/ReportDefinition.php
    - src/Content/Application/ContentService.php
    - src/Extension/Contribution/AdministratorRouteRegistry.php
    - src/Extension/Contribution/AdministratorViewRegistry.php
    - src/Extension/Contribution/AdministratorWorkspaceRegistry.php
    - src/Extension/Contribution/BusinessContributionSurface.php
    - src/Extension/Contribution/CanonicalManifestInterpreter.php
    - src/Extension/Contribution/CapabilityDefinition.php
    - src/Extension/Contribution/CapabilityDefinitionRegistry.php
    - src/Extension/Contribution/ContributionDefinitionChecksum.php
    - src/Extension/Contribution/ContributionSurface.php
    - src/Extension/Contribution/CoreContributionRegistrar.php
    - src/Extension/Contribution/CoreExtensionContributions.php
    - src/Extension/Contribution/ExtensionContributionRegistrySet.php
    - src/Extension/Contribution/ExtensionContributionSummary.php
    - src/Extension/Contribution/OwnedExtensionBindingRegistrar.php
    - src/Extension/Contribution/OwnedRuntimeContributionRegistry.php
    - src/Extension/Contribution/ResourcePolicyDefinition.php
    - src/Extension/Contribution/ResourcePolicyDefinitionRegistry.php
    - src/Extension/Contribution/StudioPreviewRendererContribution.php
    - src/Extension/Contribution/TranslationGroupDeclaration.php
    - src/Extension/Contribution/UnitConversionProviderDefinition.php
    - src/Extension/Infrastructure/DoctrineExtensionManager.php
    - src/Extension/Runtime/ActiveExtensionSet.php
    - src/Extension/Runtime/TrustEnforcingJobHandler.php
    - src/Infrastructure/Persistence/Migration/BusinessSecurityPortalMigration.php
    - src/Infrastructure/Persistence/Migration/InterfaceMessageOverrideMigration.php
    - src/Infrastructure/Persistence/Migration/PeriodPostingLockMigration.php
    - src/Infrastructure/Persistence/Migration/ResourceOwnershipScopeMigration.php
    - src/Infrastructure/Persistence/Migration/StudioHostSessionMigration.php
    - src/Infrastructure/Presentation/Persistence/DoctrinePresentationPreferenceRepository.php
    - src/InterfaceStandard/PresentationPreference.php
    - src/InterfaceStandard/SurfaceDeclaration.php
    - src/InterfaceStandard/SurfaceDefinition.php
    - src/InterfaceStandard/SurfaceId.php
    - src/Kernel/ContainerFactory.php
    - src/Localization/Domain/MessageIdentifier.php
    - src/Portal/Contribution/PortalNavigationRegistry.php
    - src/Portal/Contribution/PortalRouteRegistry.php
    - src/Portal/Contribution/PortalTemplateRegistry.php
    - src/Portal/Contribution/PortalWorkspaceRegistry.php
    - src/Portal/Http/Handler/PortalDashboardPreferencesHandler.php
    - src/Portal/Http/Handler/PortalHomeHandler.php
    - src/Portal/Presentation/PortalRenderer.php
    - src/Presentation/Application/Dashboard/DashboardComposer.php
    - src/Presentation/Application/Preference/PresentationPreferenceResolver.php
    - src/Studio/Application/Composition/StudioCompositionContributionCatalog.php
    - src/Studio/Application/Composition/StudioPublishedCompositionGuard.php
    - src/Studio/Application/Rendering/StudioBlockRendererRuntime.php
    configuration_and_di:
    - src/Kernel/ContainerFactory.php
    reflection_and_string_references:
    - docs/architecture/dependency-baseline.json
    - docs/architecture/governance/core-growth-baseline.json
    - docs/architecture/layers.json
    - docs/architecture/map.md
    - docs/interface-translation.md
    - docs/qualification/gap-matrix.md
    - docs/roadmap/decisions/0012-domain-application-reconciliation.md
    - examples/extensions/asset-inspection/src/Integration/ReviewOverdueInspectionJob.php
    fixtures_and_examples:
    - tests/Architecture/InterfaceStandardBoundaryTest.php
    - tests/Fixtures/Governance/clean/docs/architecture/layers.json
    - tests/Functional/Extension/LiveSurfaceContractParityTest.php
    - tests/Integration/Extension/ContributedContentTranslationIntegrationTest.php
    - tests/Integration/Extension/ExtensionContributionLifecycleIntegrationTest.php
    - tests/Integration/Extension/GeneratedExtensionLifecycleIntegrationTest.php
    - tests/Integration/Extension/ManifestGenerationLifecycleIntegrationTest.php
    - tests/Integration/InterfaceStandard/PresentationPreferencePersistenceIntegrationTest.php
    - tests/Support/AssetInspectionDeploymentAcceptance.php
    - tests/Support/DashboardPreferenceTestRuntime.php
    - tests/Support/InMemoryPresentationPreferenceRepository.php
    - tests/Unit/Administrator/Http/Handler/AdministratorDashboardPreferencesHandlerTest.php
    - tests/Unit/Administrator/Navigation/AdministratorNavigationRegistryTest.php
    - tests/Unit/Administrator/Presentation/AdministratorContributionRendererTest.php
    - tests/Unit/Application/Authorization/ApplicationAuthorizationTest.php
    - tests/Unit/Application/Authorization/BusinessGroupOwnershipTest.php
    - tests/Unit/Application/Presentation/Dashboard/DashboardPreferenceServiceTest.php
    - tests/Unit/BusinessIntegration/Application/BusinessRecordMutationEventPublisherTest.php
    - tests/Unit/BusinessIntegration/Application/DurableOutboundAdapterDeliveryTest.php
    - tests/Unit/BusinessIntegration/Application/ValidatedContributedJobHandlerTest.php
    - tests/Unit/BusinessIntegration/Domain/IntegrationContributionDefinitionTest.php
    - tests/Unit/BusinessIntegration/DurableOutboundAdapterDispatcherTest.php
    - tests/Unit/BusinessIntegration/Infrastructure/RuntimeIntegrationEventTransportTest.php
    - tests/Unit/BusinessIntegration/QueueRuntimePolicyTest.php
    - tests/Unit/BusinessRecord/Application/MoneyRateProviderContributionTest.php
    - tests/Unit/BusinessRecord/Application/UnitConversionProviderContributionTest.php
    - tests/Unit/BusinessSecurity/Application/BusinessSecurityAdministrationServiceTest.php
    - tests/Unit/BusinessSurface/Presentation/FieldPresentationRegistryTest.php
    - tests/Unit/Content/Application/ContributedContentTranslationTest.php
    - tests/Unit/Content/Application/ExtensionContentTranslationTest.php
    - tests/Unit/Extension/Contribution/CanonicalManifestInterpreterDriftTest.php
    - tests/Unit/Extension/Contribution/ContributionDefinitionChecksumTest.php
    - tests/Unit/Extension/Contribution/CoreContributionActivationTest.php
    - tests/Unit/Extension/Contribution/ExtensionBindingSurfaceTest.php
    - tests/Unit/Extension/Contribution/ExtensionContributionRegistrySetTest.php
    - tests/Unit/Extension/Contribution/OwnedBindingCanonicalDriftTest.php
    - tests/Unit/Extension/Contribution/StudioPreviewRendererContributionTest.php
    - tests/Unit/Extension/Development/AssetInspectionExampleTest.php
    - tests/Unit/Extension/Runtime/ActiveExtensionSetTest.php
    - tests/Unit/Extension/Runtime/TrustEnforcingJobHandlerTest.php
    - tests/Unit/Governance/LayerClassifierTest.php
    - tests/Unit/InterfaceStandard/InterfaceStandardSchemaTest.php
    - tests/Unit/InterfaceStandard/PresentationPreferenceManagerTest.php
    - tests/Unit/InterfaceStandard/PresentationPreferenceResolverTest.php
    - tests/Unit/InterfaceStandard/PresentationPreferenceTest.php
    - tests/Unit/InterfaceStandard/SurfaceDefinitionTest.php
    - tests/Unit/InterfaceStandard/SurfaceIdentifierParityTest.php
    - tests/Unit/Portal/Contribution/PortalContributionRegistryTest.php
    - tests/Unit/Portal/Http/PortalDashboardPreferencesHandlerTest.php
    - tests/Unit/Portal/Http/PortalHomeHandlerTest.php
    - tests/Unit/Portal/Presentation/PortalContributionRendererTest.php
    - tests/Unit/Presentation/Application/Dashboard/DashboardComposerTest.php
    - tests/Unit/Presentation/Application/Dashboard/DashboardPreferenceFormPresenterTest.php
    - tests/Unit/Studio/Application/Composition/StudioCompositionContributionCatalogTest.php
    - tests/Unit/Studio/Application/Composition/StudioPublishedContentRendererTest.php
    - tests/Unit/Studio/Application/Projection/StudioContentProjectionServiceTest.php
    - tests/Unit/Studio/Application/Rendering/StudioBlockRendererRuntimeTest.php
    external:
    - SDK v0.2.4 contribution implementations, assertOwns calls, scaffolds and public fixtures.
  dependency_injection:
    mode: direct
    provider: null
    factories: []
    aliases: []
    service_lifetimes:
    - Immutable owner/policy values shareable; mutable registries supplied per composition.
    configuration_keys: []
    provider_absence_reason: Direct construction, as specified by Contribution brief; no host runtime
      service.
native_cpp: null
php_extension: null
tests:
  moved_or_added:
  - tests/Case/ContributionTest.php
  - tests/Fixture/Definition.php
  - tests/Fixture/ReentrantDefinition.php
  - tools/test-release-record.sh
  remain_in_app_or_consumer:
  - App extension lifecycle, trust, manifest-generation, recovery and surface-parity tests.
  - App OwnedRuntimeContributionRegistry executable-object and lifecycle tests.
  - SDK SpiPortTest surface-definition tests and ExtensionManifestTest manifest tests.
  split_tests:
  - SDK SpiPortTest generic owner tests move; surface-specific constructor cases remain.
  - Exact method names and source ownership appear in docs/integration.md.
  - App generic data ordering/owner removal moves; executable registry behavior stays App.
  prohibited_duplicates:
  - Old SDK owner/definition classes after separately verified SDK successor adoption.
  - App ContributionSurface and direct package-unit tests after separate App adoption.
  corpora:
  - 'tests/Case/ContributionTest.php: lexical, policy, isolation, snapshots, hostile bounds and reentrancy.'
documentation:
  charter: CHARTER.md
  readme: README.md
  public_api: docs/public-api.md
  architecture: docs/architecture.md
  integration_or_consumer: docs/integration.md
  examples:
  - examples/typed-consumer.php
  changelog_record: CHANGELOG.md / 0.1.1
release_expectations:
  version_policy: SemVer; exact pre-1.0 pins; verify each selected published artifact.
  expected_artifact_types:
  - Composer package ZIP
  - GitHub source archive
  required_checks:
  - Complete reusable Package gate and release automation regression tests.
  - composer check on PHP 8.5
  - Archive installed as dependency in isolated no-dev authoritative consumer
  - Independent release/source/artifact/manifest/Packagist verification
  required_registry_or_installer: Packagist + Composer
  required_external_attestation: true
governance:
  completion_claim: false
decisions:
- 'CB-CONTRIBUTION-001: explicit policies; bounded generic/slash suffixes; raw owner limit 1024.'
- No Canonical JSON/SDK dependency or provider; direct values and data-only registry.
- Three extracted symbols plus three new neutral primitives; executable registry stays App.
- Recheck duplicates/capacity after export so reentrancy cannot overwrite or overfill.
blockers:
- Consumer qualification requires independent artifact verification.
- Core using the SDK requires a compatible SDK release with canonical owner and definition types.
consumer_contract:
  permitted_only_when:
  - The selected published package and compatible SDK artifacts are independently verified.
  - Current Core consumers and retired type ownership are checked against the recorded source baseline.
  consumer_repository: https://github.com/kumwe/extension-sdk
  dependency_or_native_change: SDK pins Contribution and retires old types; App then pins both verified
    releases.
  namespace_or_api_replacements:
  - SDK ContributionOwner -> Kumwe\Contribution\ContributionOwner
  - SDK ContributionDefinition -> Kumwe\Contribution\ContributionDefinition
  - App ContributionSurface -> Kumwe\Contribution\ContributionSurface
  - assertOwns(identifier, kind) -> explicit SurfaceIdentifierPolicy; CB-CONTRIBUTION-001
  files_to_update:
  - SDK composer.json
  - SDK composer.lock
  - SDK src/Spi/Contribution consumers and assertOwns call sites
  - SDK public API fixtures, scaffold templates and contract tests
  - App files individually listed in docs/consumer-inventory.json after SDK release
  - App src/Kernel/ContainerFactory.php
  - App docs/architecture/capability-index.md
  - App docs/architecture/governance/core-growth-baseline.json
  files_to_remove:
  - SDK src/Spi/Contribution/ContributionOwner.php
  - SDK src/Spi/Contribution/ContributionDefinition.php
  - App src/Extension/Contribution/ContributionSurface.php only during later App adoption
  tests_to_remove:
  - SDK generic owner tests listed in integration notes; retain surface/manifest assertions.
  tests_to_retain_or_add:
  - App extension lifecycle, trust, manifest-generation, recovery and surface-parity tests.
  - App OwnedRuntimeContributionRegistry executable-object and lifecycle tests.
  - SDK SpiPortTest surface-definition tests and ExtensionManifestTest manifest tests.
  di_or_provisioning_changes:
  - No provider or historical alias; host supplies explicit per-surface policy/registry.
  - App keeps executable registry/trusted lifecycle composition.
  capability_index_changes:
  - Regenerate after exact pins; package owns six FQCNs, SDK retires owner/definition FQCNs.
  changelog_and_evidence_changes:
  - KUMWE-MIG-2026-006 and KUMWE-CS-2026-006; NRM-2026-007; enabling-refactor only.
  verification_commands:
  - composer check in package and SDK successor
  - composer qa in App after later adoption
  - composer kumwe:capability-index-check
  - composer kumwe:core-growth-check
  - App extension lifecycle/trust/recovery and route/navigation integration suites
---

# Package contract

This record preserves source provenance, exact manifest identities and consumer qualification requirements.
Migration/change-set IDs are stable evidence references. [Integration](integration.md) defines the current Core
contract independently of any implementation branch or rollout status.

## Public API and responsibility

The package owns six neutral contribution types and three manifested capabilities. Every public member and bound is
documented in [the public API](public-api.md). Core owns trusted activation, executable registries and recovery.

## Dependencies and semantic inputs

The inspected Core and SDK commits identify historical source provenance. PHP is the only runtime dependency.
Canonical JSON is unnecessary for detached data snapshots; nested ordering and numeric values remain unchanged.

## Consumer contract

The source closure in [consumer-inventory.json](consumer-inventory.json) is a compatibility review inventory,
not a blind rename list. Select explicit surface policies and verify SDK/Core dependency identities. Preserve
executable registries, host trust and lifecycle authority.

## Test ownership

Package tests own lexical/policy invariants, bounded snapshots, isolation and reentrancy refusals. SDK retains
surface-specific construction and manifest assertions. Core retains executable registry, lifecycle, trust, recovery
and delivery tests. See [test ownership](test-ownership.md).

## Consumer verification

Follow [releasing](releasing.md) for source/tag, archive, registry, manifest and clean no-dev consumer verification.
Publication and independent verification are distinct evidence states. No current integration status is inferred
from a source baseline or changelog entry.

## Compatibility and drift

Review current consumers against the recorded source commits before replacing types. The explicit-policy contract
and malformed/oversized identifier refusals are documented in [integration](integration.md). Preserve new portable
behavior, regenerate locks through Composer and keep host responsibility tests.

## Validation

Run `composer check` for the complete behavior, boundary, API, architecture, security and clean archive consumer gate.
The package archive includes this record; tests, development tooling and executable host registries stay outside it.
