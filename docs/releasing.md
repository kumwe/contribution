# Release protocol

CHANGELOG's newest second-level semantic-version heading is authoritative; Unreleased is skipped and malformed
headings fail closed. 0.1.1 is the successor record; 0.1.0 remains an unchanged historical publication.

CI and release-on-record both run composer check on PHP 8.5. Publication runs only on main push after the full gate,
serializes without cancellation, and grants write permission only to its release job. Actions use reviewed SHA pins.
The API creates a missing tag at the exact tested main SHA only after a confirmed 404. Existing tags must belong to
main history and match their release record; an unpublished tag must match the exact tested commit. Existing releases
must report immutable published state or verification refuses them. Agents never push tags or merge.

The built ZIP installs as a dependency in a fresh no-dev/no-scripts/no-plugins/classmap-authoritative Composer
project. Its package repository points to that ZIP, never a path checkout. Packagist is disabled for the PHP-only
isolated consumer. Manifested symbols and shipped example run via that consumer's autoloader. Archive verification
enforces the reviewed allowlist and absence of tests/tools/vendor/development state.

After initial Packagist submission, its GitHub integration follows tags without workflow credentials. Independent
verification records tag/source, archive digest, manifests, registry coordinate, license/security evidence and clean
consumer in external RELEASE-ATTESTATION.yaml. Never embed the artifact's final digest or invented release claims in
its own handoff.

Exact pre-1.0 pins are required. Release defects need new versions/advisories, not tag movement. SDK then App adoption
are separate verified-release tasks.

## Maintainer setup before merging the 0.1.1 successor

1. Protect main with an active branch protection rule or ruleset requiring the reviewed pull request and
   package CI. The release job reads GitHub's ref_protected event context and refuses false or missing state
   before any tag or release mutation. This does not configure or alter repository permissions.
2. Enable immutable releases in the repository release settings before merging. GitHub applies that option
   to future releases; it does not retroactively protect 0.1.0. Keep the existing tag and release intact.
3. Review and merge the 0.1.1 changelog record. The existing release lane re-proves every package check,
   verifies tag ancestry and release-record identity, then publishes using its ordinary workflow token.
4. Require the final metadata check to pass: the exact version must be published, stable and immutable.
   The same check runs when an existing release is found. Mutable, draft, missing or contradictory metadata
   fails closed. If immutable releases were not enabled first, a failed post-publication check cannot undo
   publication; leave that version intact and prepare another reviewed successor.
5. Obtain a fresh independent RELEASE-ATTESTATION.yaml for the successor before a dependent package or App
   adopts it. A green package PR or a failed publication workflow is not release verification.

The workflow does not call the administrative immutable-releases settings endpoint or use an admin PAT.
Configuration is a maintainer action; publication verification uses the normal release metadata endpoint.
The development gate uses Bash and jq with isolated response fixtures. These tests exercise refusal logic
without contacting GitHub or claiming that protections are currently configured. Both helper scripts are
under the export-ignored tools directory, so the runtime archive and runtime dependency ceiling are unchanged.

All portable implementation tests remain package-owned. The handoff's exact App integration/security test
retention and later duplicate-test removal instructions are unchanged by this release-only correction.
