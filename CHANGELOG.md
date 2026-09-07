# Changelog

## 0.1.0

### Added

- Neutral owner/definition semantics from Extension SDK v0.2.4 and owner-scoped surface contract from App baseline `960ce8ec00cf724a7cae03e5ba09c4852c9ab54e`.
- Explicit bounded per-surface dotted/slash policies, replacing hard-coded kind branching.
- Data-only registry with detached snapshots, deterministic order, exact-owner lookup/removal, collision refusal and typed rejection reasons. Runtime implementation objects and trust authority remain App-owned.
- Public API/capability/service manifests, examples, hostile corpus, architecture/static/security/archive checks and release automation.

### Changed

- ContributionOwner::assertOwns requires an explicit SurfaceIdentifierPolicy; malformed and oversized suffixes formerly accepted by generic prefix checks are refused. Initial-release clean break CB-CONTRIBUTION-001 is documented in docs/integration.md.
- KUMWE-MIG-2026-006 / KUMWE-CS-2026-006; NRM-2026-007; enabling-refactor; Roadmap impact: None. No consumer integration or objective completion is claimed.
