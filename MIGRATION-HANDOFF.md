---
schema: "kumwe-migration-handoff/v2"
artifact_kind: "framework_php"
migration_id: "KUMWE-MIG-2026-006"
change_set: "KUMWE-CS-2026-006"
state: "draft_pr_open"
source:
  app:
    repository: "https://github.com/kumwe/app"
    baseline_commit: "960ce8ec00cf724a7cae03e5ba09c4852c9ab54e"
    examined_paths:
      - "src/Extension/Contribution"
      - "src"
      - "tests"
      - "config"
      - "bootstrap"
      - "examples"
      - "tools"
      - "docs/architecture"
      - "composer.json"
      - "composer.lock"
      - "AGENTS.md"
    old_namespace_roots: []
    capability_index_sha256: "87ded886f35f74878ca9eb8db4c36e23d681c4a49891f76dfc3210f385a7ce39"
  semantic_inputs: []
  examined_dependencies:
    - "SDK v0.2.4 at d0484b8733eaa57d076f567ffa5e997b9564b5fa: exact ContributionOwner, ContributionDefinition, ExtensionIdentifier and SpiPortTest source inspected as extraction inputs; not a runtime dependency."
    - "App locks conversion v0.1.2 and producer v0.2.0: no contribution identity/registry owner."
    - "No Kumwe runtime dependency selected; Canonical JSON not needed for bounded snapshots without encoding/digest semantics."
  active_related_pull_requests:
    - "https://github.com/kumwe/transaction/pull/2"
    - "https://github.com/kumwe/sequence/pull/2"
target:
  repository: "https://github.com/kumwe/contribution"
  artifact_identity: "kumwe/contribution"
  canonical_namespace_or_abi: "Kumwe\\Contribution"
  branch: "agent/extract-contribution-primitives-v2"
  pull_request: "https://github.com/kumwe/contribution/pull/1"
ownership:
  responsibility: "Neutral contribution identity, explicit surface policy and deterministic owner-scoped data registries."
  non_responsibilities:
    - "Trust, authorization, lifecycle admission and active runtime generation."
    - "Executable implementation storage, dispatch, routing and rendering."
    - "Persistence, transactions, canonical JSON and cryptographic digests."
    - "SDK or App implementation and container registration."
  allowed_dependency_ceiling: []
  implementation_owner: "kumwe/contribution"
  next_consumer: "kumwe/extension-sdk"
  public_manifests:
    - path: "resources/public-api/v1.json"
      sha256: "799d99af60e98f8e109a3ed9a3b47eb5f2f9b0e7d88688bd9b71246ed78b116f"
    - path: "resources/capabilities/v1.json"
      sha256: "edc65093c3205678ed6a2c08e14db4c2e077df728e0d55c0800676538d842996"
    - path: "resources/service-map/v1.json"
      sha256: "ee59a37a0fc1a5ba43dab2e7f0ae5faf041fdd748b9df89d7e9dd6c6d12c31fd"
  intentionally_excluded:
    - "App OwnedRuntimeContributionRegistry executable object typing/storage/dispatch and trusted active registry authority."
    - "App ExtensionContributionRegistrySet, lifecycle/trust/manifest reconciliation, core/delivery registrars and recovery."
    - "SDK ExtensionIdentifier retains manifest identity; this package owns the contribution-owner value with its frozen lexical grammar."
    - "Generic canonical JSON, hashes, native execution, container services and persistence."
framework_php:
  composer_package: "kumwe/contribution"
  canonical_namespace: "Kumwe\\Contribution"
  public_api_manifest: "resources/public-api/v1.json"
  capability_manifest: "resources/capabilities/v1.json"
  service_map: "resources/service-map/v1.json"
  extracted_symbols:
    - old_fqcn: "Kumwe\\Extension\\Spi\\Contribution\\ContributionOwner"
      new_fqcn: "Kumwe\\Contribution\\ContributionOwner"
      source_path: "src/Spi/Contribution/ContributionOwner.php"
      target_path: "src/ContributionOwner.php"
      kind: "class"
      public_methods:
        - "assertOwns"
        - "core"
        - "equals"
        - "extension"
        - "fromString"
        - "identifier"
        - "namespace"
      public_properties: []
      public_constants:
        - "CORE"
      exceptions:
        - "Kumwe\\Contribution\\ContributionRejected"
      serialization_contract: "identifier()/fromString(): core or normalized vendor/name."
      compatibility: "CB-CONTRIBUTION-001: assertOwns takes explicit policy; owner grammar preserved, raw input bounded."
    - old_fqcn: "Kumwe\\Extension\\Spi\\Contribution\\ContributionDefinition"
      new_fqcn: "Kumwe\\Contribution\\ContributionDefinition"
      source_path: "src/Spi/Contribution/ContributionDefinition.php"
      target_path: "src/ContributionDefinition.php"
      kind: "interface"
      public_methods:
        - "identifier"
        - "toArray"
      public_properties: []
      public_constants: []
      exceptions:
        - "Kumwe\\Contribution\\ContributionRejected"
      serialization_contract: null
      compatibility: "Contract signatures preserved under canonical namespace."
    - old_fqcn: "Kumwe\\App\\Extension\\Contribution\\ContributionSurface"
      new_fqcn: "Kumwe\\Contribution\\ContributionSurface"
      source_path: "src/Extension/Contribution/ContributionSurface.php"
      target_path: "src/ContributionSurface.php"
      kind: "interface"
      public_methods:
        - "ownedBy"
        - "remove"
      public_properties: []
      public_constants: []
      exceptions:
        - "Kumwe\\Contribution\\ContributionRejected"
      serialization_contract: null
      compatibility: "Owner parameter moves to canonical package value."
  consumers:
    app_code:
      - "src/Administrator/Automation/ContributedJobFormCompiler.php"
      - "src/Administrator/Http/Handler/AdministratorDashboardHandler.php"
      - "src/Administrator/Http/Handler/AdministratorDashboardPreferencesHandler.php"
      - "src/Administrator/Navigation/AdministratorNavigationRegistry.php"
      - "src/Administrator/Presentation/AdministratorRenderer.php"
      - "src/Application/Automation/JobExecutionScope.php"
      - "src/Application/Presentation/Dashboard/DashboardPreferenceService.php"
      - "src/Application/Presentation/Preference/PresentationPreferenceManager.php"
      - "src/Application/Presentation/Preference/PresentationPreferencePolicy.php"
      - "src/Application/Presentation/Preference/PresentationPreferenceRepository.php"
      - "src/Application/Presentation/Preference/RegisteredPresentationPreferencePolicy.php"
      - "src/BusinessIntegration/Application/DurableOutboundAdapterDispatcher.php"
      - "src/BusinessIntegration/Application/ValidatedContributedJobHandler.php"
      - "src/BusinessIntegration/Domain/QueueContributionDefinition.php"
      - "src/BusinessIntegration/Domain/ScheduleContributionDefinition.php"
      - "src/BusinessIntegration/Infrastructure/ContributedQueueRuntimePolicyCatalog.php"
      - "src/BusinessIntegration/Infrastructure/ContributedScheduleSynchronizer.php"
      - "src/BusinessIntegration/Infrastructure/RuntimeIntegrationEventTransport.php"
      - "src/BusinessRecord/Domain/MoneyRateProviderDefinition.php"
      - "src/BusinessReporting/Domain/ReportDefinition.php"
      - "src/Content/Application/ContentService.php"
      - "src/Extension/Contribution/AdministratorRouteRegistry.php"
      - "src/Extension/Contribution/AdministratorViewRegistry.php"
      - "src/Extension/Contribution/AdministratorWorkspaceRegistry.php"
      - "src/Extension/Contribution/BusinessContributionSurface.php"
      - "src/Extension/Contribution/CanonicalManifestInterpreter.php"
      - "src/Extension/Contribution/CapabilityDefinition.php"
      - "src/Extension/Contribution/CapabilityDefinitionRegistry.php"
      - "src/Extension/Contribution/ContributionDefinitionChecksum.php"
      - "src/Extension/Contribution/ContributionSurface.php"
      - "src/Extension/Contribution/CoreContributionRegistrar.php"
      - "src/Extension/Contribution/CoreExtensionContributions.php"
      - "src/Extension/Contribution/ExtensionContributionRegistrySet.php"
      - "src/Extension/Contribution/ExtensionContributionSummary.php"
      - "src/Extension/Contribution/OwnedExtensionBindingRegistrar.php"
      - "src/Extension/Contribution/OwnedRuntimeContributionRegistry.php"
      - "src/Extension/Contribution/ResourcePolicyDefinition.php"
      - "src/Extension/Contribution/ResourcePolicyDefinitionRegistry.php"
      - "src/Extension/Contribution/StudioPreviewRendererContribution.php"
      - "src/Extension/Contribution/TranslationGroupDeclaration.php"
      - "src/Extension/Contribution/UnitConversionProviderDefinition.php"
      - "src/Extension/Infrastructure/DoctrineExtensionManager.php"
      - "src/Extension/Runtime/ActiveExtensionSet.php"
      - "src/Extension/Runtime/TrustEnforcingJobHandler.php"
      - "src/Infrastructure/Persistence/Migration/BusinessSecurityPortalMigration.php"
      - "src/Infrastructure/Persistence/Migration/InterfaceMessageOverrideMigration.php"
      - "src/Infrastructure/Persistence/Migration/PeriodPostingLockMigration.php"
      - "src/Infrastructure/Persistence/Migration/ResourceOwnershipScopeMigration.php"
      - "src/Infrastructure/Persistence/Migration/StudioHostSessionMigration.php"
      - "src/Infrastructure/Presentation/Persistence/DoctrinePresentationPreferenceRepository.php"
      - "src/InterfaceStandard/PresentationPreference.php"
      - "src/InterfaceStandard/SurfaceDeclaration.php"
      - "src/InterfaceStandard/SurfaceDefinition.php"
      - "src/InterfaceStandard/SurfaceId.php"
      - "src/Kernel/ContainerFactory.php"
      - "src/Localization/Domain/MessageIdentifier.php"
      - "src/Portal/Contribution/PortalNavigationRegistry.php"
      - "src/Portal/Contribution/PortalRouteRegistry.php"
      - "src/Portal/Contribution/PortalTemplateRegistry.php"
      - "src/Portal/Contribution/PortalWorkspaceRegistry.php"
      - "src/Portal/Http/Handler/PortalDashboardPreferencesHandler.php"
      - "src/Portal/Http/Handler/PortalHomeHandler.php"
      - "src/Portal/Presentation/PortalRenderer.php"
      - "src/Presentation/Application/Dashboard/DashboardComposer.php"
      - "src/Presentation/Application/Preference/PresentationPreferenceResolver.php"
      - "src/Studio/Application/Composition/StudioCompositionContributionCatalog.php"
      - "src/Studio/Application/Composition/StudioPublishedCompositionGuard.php"
      - "src/Studio/Application/Rendering/StudioBlockRendererRuntime.php"
    configuration_and_di:
      - "src/Kernel/ContainerFactory.php"
    reflection_and_string_references:
      - "docs/architecture/dependency-baseline.json"
      - "docs/architecture/governance/core-growth-baseline.json"
      - "docs/architecture/layers.json"
      - "docs/architecture/map.md"
      - "docs/interface-translation.md"
      - "docs/qualification/gap-matrix.md"
      - "docs/roadmap/decisions/0012-domain-application-reconciliation.md"
      - "examples/extensions/asset-inspection/src/Integration/ReviewOverdueInspectionJob.php"
    fixtures_and_examples:
      - "tests/Architecture/InterfaceStandardBoundaryTest.php"
      - "tests/Fixtures/Governance/clean/docs/architecture/layers.json"
      - "tests/Functional/Extension/LiveSurfaceContractParityTest.php"
      - "tests/Integration/Extension/ContributedContentTranslationIntegrationTest.php"
      - "tests/Integration/Extension/ExtensionContributionLifecycleIntegrationTest.php"
      - "tests/Integration/Extension/GeneratedExtensionLifecycleIntegrationTest.php"
      - "tests/Integration/Extension/ManifestGenerationLifecycleIntegrationTest.php"
      - "tests/Integration/InterfaceStandard/PresentationPreferencePersistenceIntegrationTest.php"
      - "tests/Support/AssetInspectionDeploymentAcceptance.php"
      - "tests/Support/DashboardPreferenceTestRuntime.php"
      - "tests/Support/InMemoryPresentationPreferenceRepository.php"
      - "tests/Unit/Administrator/Http/Handler/AdministratorDashboardPreferencesHandlerTest.php"
      - "tests/Unit/Administrator/Navigation/AdministratorNavigationRegistryTest.php"
      - "tests/Unit/Administrator/Presentation/AdministratorContributionRendererTest.php"
      - "tests/Unit/Application/Authorization/ApplicationAuthorizationTest.php"
      - "tests/Unit/Application/Authorization/BusinessGroupOwnershipTest.php"
      - "tests/Unit/Application/Presentation/Dashboard/DashboardPreferenceServiceTest.php"
      - "tests/Unit/BusinessIntegration/Application/BusinessRecordMutationEventPublisherTest.php"
      - "tests/Unit/BusinessIntegration/Application/DurableOutboundAdapterDeliveryTest.php"
      - "tests/Unit/BusinessIntegration/Application/ValidatedContributedJobHandlerTest.php"
      - "tests/Unit/BusinessIntegration/Domain/IntegrationContributionDefinitionTest.php"
      - "tests/Unit/BusinessIntegration/DurableOutboundAdapterDispatcherTest.php"
      - "tests/Unit/BusinessIntegration/Infrastructure/RuntimeIntegrationEventTransportTest.php"
      - "tests/Unit/BusinessIntegration/QueueRuntimePolicyTest.php"
      - "tests/Unit/BusinessRecord/Application/MoneyRateProviderContributionTest.php"
      - "tests/Unit/BusinessRecord/Application/UnitConversionProviderContributionTest.php"
      - "tests/Unit/BusinessSecurity/Application/BusinessSecurityAdministrationServiceTest.php"
      - "tests/Unit/BusinessSurface/Presentation/FieldPresentationRegistryTest.php"
      - "tests/Unit/Content/Application/ContributedContentTranslationTest.php"
      - "tests/Unit/Content/Application/ExtensionContentTranslationTest.php"
      - "tests/Unit/Extension/Contribution/CanonicalManifestInterpreterDriftTest.php"
      - "tests/Unit/Extension/Contribution/ContributionDefinitionChecksumTest.php"
      - "tests/Unit/Extension/Contribution/CoreContributionActivationTest.php"
      - "tests/Unit/Extension/Contribution/ExtensionBindingSurfaceTest.php"
      - "tests/Unit/Extension/Contribution/ExtensionContributionRegistrySetTest.php"
      - "tests/Unit/Extension/Contribution/OwnedBindingCanonicalDriftTest.php"
      - "tests/Unit/Extension/Contribution/StudioPreviewRendererContributionTest.php"
      - "tests/Unit/Extension/Development/AssetInspectionExampleTest.php"
      - "tests/Unit/Extension/Runtime/ActiveExtensionSetTest.php"
      - "tests/Unit/Extension/Runtime/TrustEnforcingJobHandlerTest.php"
      - "tests/Unit/Governance/LayerClassifierTest.php"
      - "tests/Unit/InterfaceStandard/InterfaceStandardSchemaTest.php"
      - "tests/Unit/InterfaceStandard/PresentationPreferenceManagerTest.php"
      - "tests/Unit/InterfaceStandard/PresentationPreferenceResolverTest.php"
      - "tests/Unit/InterfaceStandard/PresentationPreferenceTest.php"
      - "tests/Unit/InterfaceStandard/SurfaceDefinitionTest.php"
      - "tests/Unit/InterfaceStandard/SurfaceIdentifierParityTest.php"
      - "tests/Unit/Portal/Contribution/PortalContributionRegistryTest.php"
      - "tests/Unit/Portal/Http/PortalDashboardPreferencesHandlerTest.php"
      - "tests/Unit/Portal/Http/PortalHomeHandlerTest.php"
      - "tests/Unit/Portal/Presentation/PortalContributionRendererTest.php"
      - "tests/Unit/Presentation/Application/Dashboard/DashboardComposerTest.php"
      - "tests/Unit/Presentation/Application/Dashboard/DashboardPreferenceFormPresenterTest.php"
      - "tests/Unit/Studio/Application/Composition/StudioCompositionContributionCatalogTest.php"
      - "tests/Unit/Studio/Application/Composition/StudioPublishedContentRendererTest.php"
      - "tests/Unit/Studio/Application/Projection/StudioContentProjectionServiceTest.php"
      - "tests/Unit/Studio/Application/Rendering/StudioBlockRendererRuntimeTest.php"
    external:
      - "kumwe/extension-sdk v0.2.4: contribution implementations, assertOwns call sites, scaffold templates and public API fixtures."
  dependency_injection:
    mode: "direct"
    provider: null
    factories: []
    aliases: []
    service_lifetimes:
      - "Immutable owner/policy values are shareable; mutable registry instances are explicit per-composition state."
    configuration_keys: []
    provider_absence_reason: "Contribution-specific brief chooses direct construction; no injected host runtime service is exported."
native_cpp: null
php_extension: null
tests:
  moved_or_added:
    - "tests/Case/ContributionTest.php"
    - "tests/Fixture/Definition.php"
    - "tests/Fixture/ReentrantDefinition.php"
    - "tools/test-release-record.sh"
  remain_in_app_or_consumer:
    - "App tests/Integration/Extension/ExtensionContributionLifecycleIntegrationTest.php"
    - "App tests/Integration/Extension/ManifestGenerationLifecycleIntegrationTest.php"
    - "App tests/Functional/Extension/LiveSurfaceContractParityTest.php"
    - "App OwnedRuntimeContributionRegistry executable-object and lifecycle tests"
    - "SDK tests/Case/SpiPortTest.php surface-specific definition tests and ExtensionManifestTest.php manifest tests"
  split_tests:
    - "SDK SpiPortTest::testContributionOwnerBoundsItsNamespace, testOwnerBoundaryRejectsRepeatedDotsInTheContributionSuffix, testLegacyOwnerDotSpellingsRemainRepresentable: generic owner/policy cases move here; surface-specific constructor tests stay SDK."
    - "App generic data-only registry ordering/owner removal assertions move; executable registry tests remain App because that host type remains."
  prohibited_duplicates:
    - "Old SDK ContributionOwner/ContributionDefinition classes after the separately verified SDK successor adoption."
    - "App ContributionSurface class declaration and direct unit tests of canonical package internals after App adoption."
  corpora:
    - "tests/Case/ContributionTest.php: owner lexical baseline, explicit dotted/slash policy, collision isolation, snapshot/refusal/reentrancy and resource bounds."
documentation:
  charter: "CHARTER.md"
  readme: "README.md"
  public_api: "docs/public-api.md"
  architecture: "docs/architecture.md"
  integration_or_consumer: "docs/integration.md"
  examples:
    - "examples/typed-consumer.php"
  changelog_record: "CHANGELOG.md / 0.1.0 (proposed release record)"
release_expectations:
  version_policy: "SemVer; changelog release record; exact immutable pins before 1.0; no predicted tag or artifact result."
  expected_artifact_types:
    - "Composer package ZIP"
    - "GitHub source archive"
  required_checks:
    - "composer check on PHP 8.5"
    - "Archive installed as dependency in isolated no-dev authoritative consumer"
    - "Independent release/source/artifact/manifest/Packagist verification"
  required_registry_or_installer: "Packagist + Composer"
  required_external_attestation: true
next_task:
  phase_name: "Independent Contribution release verification, then separate Extension SDK adoption and successor release, then separate App adoption"
  permitted_only_when:
    - "A human merged this package PR and automation published an immutable release."
    - "An independent external RELEASE-ATTESTATION.yaml verifies that exact artifact and complete handoff."
    - "Before App changes, the separate SDK successor PR is human-merged and its release independently verified."
  consumer_repository: "https://github.com/kumwe/extension-sdk"
  dependency_or_native_change: "Exact-pin verified kumwe/contribution; retire old SDK owner/definition FQCNs and publish a separately verified SDK successor before App exact-pins both releases."
  namespace_or_api_replacements:
    - "Kumwe\\Extension\\Spi\\Contribution\\ContributionOwner -> Kumwe\\Contribution\\ContributionOwner"
    - "Kumwe\\Extension\\Spi\\Contribution\\ContributionDefinition -> Kumwe\\Contribution\\ContributionDefinition"
    - "Kumwe\\App\\Extension\\Contribution\\ContributionSurface -> Kumwe\\Contribution\\ContributionSurface"
    - "assertOwns(identifier, kind) -> assertOwns(identifier, explicit SurfaceIdentifierPolicy); CB-CONTRIBUTION-001"
  files_to_update:
    - "SDK composer.json"
    - "SDK composer.lock"
    - "SDK src/Spi/Contribution consumers and assertOwns call sites"
    - "SDK public API fixtures, scaffold templates and contract tests"
    - "App files individually listed in docs/consumer-inventory.json after SDK release"
    - "App src/Kernel/ContainerFactory.php"
    - "App docs/architecture/capability-index.md"
    - "App docs/architecture/governance/core-growth-baseline.json"
  files_to_remove:
    - "SDK src/Spi/Contribution/ContributionOwner.php"
    - "SDK src/Spi/Contribution/ContributionDefinition.php"
    - "App src/Extension/Contribution/ContributionSurface.php only during later App adoption"
  tests_to_remove:
    - "Only generic owner/policy unit cases explicitly split from SDK SpiPortTest; preserve SDK surface constructor/manifest assertions."
  tests_to_retain_or_add:
    - "App tests/Integration/Extension/ExtensionContributionLifecycleIntegrationTest.php"
    - "App tests/Integration/Extension/ManifestGenerationLifecycleIntegrationTest.php"
    - "App tests/Functional/Extension/LiveSurfaceContractParityTest.php"
    - "App OwnedRuntimeContributionRegistry executable-object and lifecycle tests"
    - "SDK tests/Case/SpiPortTest.php surface-specific definition tests and ExtensionManifestTest.php manifest tests"
  di_or_provisioning_changes:
    - "No package ConfigProvider or historical alias; host explicitly supplies per-surface policy and registry instances."
    - "Retain App executable registry/trusted lifecycle composition."
  capability_index_changes:
    - "Regenerate after both exact dependency pins; package owns six FQCNs, SDK retires former owner/definition FQCNs."
  changelog_and_evidence_changes:
    - "KUMWE-MIG-2026-006 and KUMWE-CS-2026-006; NRM-2026-007; enabling-refactor only."
  verification_commands:
    - "composer check in package and SDK successor"
    - "composer qa in App after later adoption"
    - "composer kumwe:capability-index-check"
    - "composer kumwe:core-growth-check"
    - "App extension lifecycle/trust/recovery and route/navigation integration suites"
concurrency:
  likely_conflict_files:
    - "SDK composer.json"
    - "SDK composer.lock"
    - "SDK contribution consumers and API fixtures"
    - "App composer.json"
    - "App composer.lock"
    - "App src/Kernel/ContainerFactory.php"
    - "App docs/architecture/capability-index.md"
  related_migrations:
    - "KUMWE-MIG-2026-001"
    - "KUMWE-MIG-2026-002"
    - "KUMWE-MIG-2026-003"
    - "KUMWE-MIG-2026-004"
    - "KUMWE-MIG-2026-005"
  ownership_conflicts:
    - "SDK currently owns old owner/definition classes; its separate successor migration is a mandatory predecessor of App adoption."
  integration_train: null
  resolution_rule: "semantic-preservation"
governance:
  roadmap_source_sha256: "a202155ef1a65f5ab293d4f8397ebf4ac430db7f1e877c776bbe7851e6fe18d8"
  roadmap_refs: []
  non_roadmap_refs:
    - "NRM-2026-007"
  completion_claim: false
decisions:
  - "CB-CONTRIBUTION-001: explicit policy replaces kind-string branching; generic/slash suffix validation tightens malformed-input behavior and raw owner input is capped at 1024 bytes."
  - "No Canonical JSON/SDK dependency and no provider; dependency-free direct values and local data-only registry."
  - "Three extracted symbols and three newly factored neutral primitives are fully manifested; executable registry remains App."
  - "Registration rechecks duplicate/capacity after consumer export so reentrancy cannot overwrite another owner or exceed capacity."
blockers:
  - "Publication/independent attestation are future gates, not claimed complete."
  - "SDK successor removal of its old owner/definition classes and verified release are required before App adoption."
---

# Contribution migration handoff

## Migration/implementation summary

Six canonical neutral types factor SDK owner/definition and App surface/data registry behavior. Executable registry, admission, trust, lifecycle and recovery stay App. No SDK/App production file is changed by this Phase 1. See docs/integration.md for the exact ownership and CB-CONTRIBUTION-001 clean break.

## Public API and responsibility

Every public member is documented in docs/public-api.md and reflected into resources/public-api/v1.json. Three capabilities and the explicit no-provider decision are separately manifested. No extra runtime dependency or global service exists.

## Capability reuse/semantic input review

App's exact lock and capability index identify SDK v0.2.4 as the present owner. Exact released owner/definition/identifier and SpiPortTest source were inspected. Generic owner grammar is preserved; host-specific branches become explicit policies. Canonical JSON is unnecessary because no encoding/digest is implemented. Source input is provenance, not a runtime SDK dependency.

## Consumer inventory

The source closure includes 68 App production files, 57 test references and 8 other references, fully listed in docs/consumer-inventory.json and the front matter. These are semantic review candidates, never a blind rename list. SDK source/scaffold/public contract consumers must migrate first. No broad App Extension\Contribution namespace is retired because most classes there remain host-owned.

## Test ownership

Package tests own lexical/policy invariants, deterministic snapshots, hostile bounds, exact-owner isolation and reentrancy refusals. App retains executable registry, manifest/lifecycle/trust/recovery and delivery tests. SDK keeps manifest and concrete surface-definition assertions while moving only generic owner cases. Tests/fixtures never ship in the consumer archive.

## Next-task execution notes

Verify this exact immutable release externally. Then a separate SDK PR exact-pins it, removes old owner/definition FQCNs, composes every per-surface policy, regenerates API fixtures/scaffolds and produces a verified successor release. Only then may a separate App task pin both releases, apply the consumer inventory, remove App ContributionSurface, retain executable registries, and regenerate governance/capability evidence. Never add aliases or adopt mutable branches.

## Drift check

Compare current App with baseline 960ce8ec00cf724a7cae03e5ba09c4852c9ab54e and SDK with d0484b8733eaa57d076f567ffa5e997b9564b5fa; rerun the inventory search and compare all portable behavior/signatures. New portable behavior requires a separate upstream release before consumer adoption. Preserve all concurrent dependencies and regeneration changes; never hand-edit lockfiles or resolve whole files with ours/theirs.

## Validation recipe and observed local results

PHP 8.5.10: behavior/hostile tests, member documentation, architecture, manifest reflection and PHPStan max passed while authoring. Run composer check for the complete final package/security/archive consumer gate. The draft PR records observed final CI results; final tested commit and archive digests belong in external evidence, not this embedded handoff. No release or App integration is claimed.
