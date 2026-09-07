# Kumwe Contribution

Neutral contribution owners, explicit surface policies and bounded deterministic data registries. Requires PHP 8.5 with no other runtime dependencies. Namespace: `Kumwe\Contribution`. Apache-2.0.

## Install and use

After the initial release is published and independently verified:

```bash
composer require kumwe/contribution:0.1.0
php vendor/kumwe/contribution/examples/typed-consumer.php vendor/autoload.php
```

The recorded 0.1.0 is a proposed release record, not a publication claim. Exact pins are required before 1.0. The complete runnable example ships in [examples/typed-consumer.php](examples/typed-consumer.php).

```php
use Kumwe\Contribution\ContributionOwner;
use Kumwe\Contribution\SurfaceIdentifierPolicy;
use Kumwe\Contribution\OwnedContributionRegistry;

$owner = ContributionOwner::extension('acme/catalog');
$policy = SurfaceIdentifierPolicy::dotted('catalog');
$owner->assertOwns('acme.catalog.summary', $policy);
$registry = new OwnedContributionRegistry($policy, maximumEntries: 100);
```

Implement ContributionDefinition's identifier()/toArray() for your declaration, then register it. The registry validates ownership and freezes a bounded data snapshot; no implementation object is retained. Exact-owner lookup returns a copy or null; owner removal cannot delete another owner's entries. Identifier order is bytewise deterministic. Nested document order and numeric values are preserved without canonical JSON, hashing or precision conversion.

## Composition and guarantees

Every surface explicitly chooses dotted() or slash() policy. Surface names never activate special rules. Typed dotted markers, core exemptions, slash namespace aliases and index kinds are explicit options. [Integration](docs/integration.md) documents the intentional migration from SDK kind branching.

No provider, factory, container alias or configuration key is exported. Construct immutable values directly. Supply a mutable registry per composition; no concurrent-writer/process guarantee, transactions, I/O or external effects. Host trust, authorization, lifecycle, manifest reconciliation, active runtime generation, executable dispatch, persistence and recovery remain outside this package. Owner identity is never a security credential.

Identifier input is limited to 256 bytes; policy lists/capacity are bounded. Snapshots enforce depth/node/string/byte limits, reject objects/resources/non-finite numbers and detach PHP references. Returned arrays cannot mutate stored state. ContributionRejected extends InvalidArgumentException with a stable readonly reason; diagnostics do not echo submitted payloads.

[Public API](docs/public-api.md) documents every public member, limit and error. See [architecture](docs/architecture.md), [security](docs/security.md), [release protocol](docs/releasing.md) and [handoff](MIGRATION-HANDOFF.md).

## Verify

```bash
composer install
composer check
```

The gate includes Composer validation/security audit, release parser, syntax, member docs, architecture, reflected API manifests, Composer autoload/example, PSR-12, PHPStan max, hostile/behavior tests and built-ZIP installation as a dependency in an isolated no-dev authoritative consumer. `php tests/run.php` runs behavior tests without Composer. `composer manifests:record` regenerates a deliberately changed API manifest.

This is Phase 1. Human merge, automatic release and independent attestation precede a separate SDK successor release, then App adoption. No legacy aliases, remaps or production fallback are supplied.
