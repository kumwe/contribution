# Releasing Contribution

Follow the [Package release standard](package-release-standard.md) for the shared
quality gate, changelog parsing, publication and retry behavior. Complete the
[repository release setup](repository-release-setup.md) with an administrator
session before merging a release record:

```bash
bash tools/configure-release-repositories.sh --check kumwe/contribution
bash tools/configure-release-repositories.sh --apply kumwe/contribution
```

The required CI check is **Package gate**. Maintainers rebase reviewed PRs into the
repository's current default branch; the release workflow reruns the same quality
gate on the resulting commit and derives its release identity from that run.
A release intention in CHANGELOG.md is not evidence that publication occurred.
Keep work that is not ready for publication under `## Unreleased`.

Exact pre-1.0 pins are required. Behavior, boundary and language-neutral conformance
proof remains package-owned. SDK adoption and App adoption are separate tasks that
require the independently verified release.

## Artifact and consumer verification

The built ZIP installs as a dependency in a fresh Composer project using no-dev,
no-scripts, no-plugins and classmap-authoritative installation. Its package repository
points to that ZIP, never a path checkout. Packagist is disabled for the PHP-only
isolated consumer. Manifested symbols and the shipped example run through the
consumer's autoloader. Archive verification enforces the reviewed allowlist and
excludes tests, tools, vendor and development state.

The handoff's App integration/security test retention and later duplicate-test
removal instructions remain applicable. Release defects require a reviewed
successor and, where relevant, an advisory.

## Publication evidence and recovery

The maintainer performs the initial Packagist submission. Its GitHub integration
then follows tags without a registry credential in CI. Before dependent publication
or App adoption, a fresh independent verifier must bind the exact published
source/tag, archive digest, manifests, registry coordinate, license/security and
clean-consumer results in an external RELEASE-ATTESTATION.yaml. The artifact and
handoff must not invent their own final commit, checksum or publication evidence.

Use the current release workflow on the default branch to retry after correcting
repository settings. Historical mutable releases remain unchanged: enabling
immutability affects future publications, so a mutable version requires an unused
successor. Never move or delete a published tag or replace a released artifact.
An unpublished tag can be completed only on the exact commit tested by the retry.
A green PR does not replace the default-branch release result or independent
verification. Administrator credentials do not belong in Actions.
