<?php

declare(strict_types=1);

namespace Kumwe\Contribution\Tests\Case;

use Kumwe\Contribution\ContributionOwner;
use Kumwe\Contribution\ContributionRejected;
use Kumwe\Contribution\OwnedContributionRegistry;
use Kumwe\Contribution\SurfaceIdentifierPolicy;
use Kumwe\Contribution\Tests\Fixture\Definition;
use Kumwe\Contribution\Tests\Fixture\ReentrantDefinition;
use Kumwe\Contribution\Tests\TestCase;

/**
 * Freeze owner grammar and prove explicit policy, isolation, bounds and detached registry data.
 *
 * @since 0.1.0
 */
final class ContributionTest extends TestCase
{
    /**
     * Preserve normalization, segment limits, punctuation and exact core restoration.
     *
     * @return void
     * @since 0.1.0
     */
    public function testOwnerCorpus(): void
    {
        foreach (['ACME/Blog' => 'acme/blog', ' a..b/c. ' => 'a..b/c.', 'x_y/z-2' => 'x_y/z-2'] as $raw => $value) {
            $owner = ContributionOwner::extension($raw);
            $this->assertSame($value, $owner->identifier(), 'Owner normalization changed.');
            $this->assertTrue($owner->equals(ContributionOwner::fromString($value)), 'Stored owner must round-trip.');
            $this->assertSame(str_replace('/', '.', $value), $owner->namespace(), 'Namespace must preserve spelling.');
        }
        $this->assertTrue(ContributionOwner::core()->equals(ContributionOwner::fromString('core')), 'Core round-trip.');
        $this->assertFalse(ContributionOwner::core()->equals(ContributionOwner::extension('a/b')), 'Distinct owners.');
        $maximum = str_repeat('a', 63) . '/' . str_repeat('b', 63);
        $this->assertSame($maximum, ContributionOwner::extension($maximum)->identifier(), 'Maximum accepted.');
        foreach (['', 'Core', ' core ', 'a', '/a', 'a/', 'a/b/c', '-a/b', "a/b\nc", 'é/b',
            str_repeat('a', 64) . '/b', str_repeat(' ', 1025)] as $invalid) {
            $this->assertThrows(
                static fn () => ContributionOwner::fromString($invalid),
                ContributionRejected::class,
                'Invalid owner must fail.',
            );
        }
    }

    /**
     * A surface's name never chooses an exemption; policy does so explicitly and locally.
     *
     * @return void
     * @since 0.1.0
     */
    public function testDottedPolicyIsolation(): void
    {
        $owner = ContributionOwner::extension('acme/blog');
        $strict = SurfaceIdentifierPolicy::dotted('capability');
        $typed = SurfaceIdentifierPolicy::dotted('typed', true);
        $corePolicy = SurfaceIdentifierPolicy::dotted('permissions', false, true);
        $owner->assertOwns('acme.blog.item', $strict);
        $owner->assertOwns('acme.blog.event:created@1', $typed);
        ContributionOwner::core()->assertOwns('content.read', $corePolicy);
        ContributionOwner::extension('a./b.')->assertOwns('a..b..item', $strict);
        $this->assertSame('capability', $strict->surface(), 'Explicit diagnostic surface identity.');
        foreach (['acme.blog.', 'acme.blog..x', 'acme.blog.x.', 'acme.blog.x@1', 'acme.blog.x/y',
            'acme.blog. x', 'acme.blog.x y', "acme.blog.x\n", 'other.blog.x', 'acme.blog-extra.x',
            str_repeat('x', 257), '', 'acme.blog.é'] as $invalid) {
            $this->assertThrows(
                static fn () => $owner->assertOwns($invalid, $strict),
                ContributionRejected::class,
                'Malformed or foreign identifier must fail.',
            );
        }
        $this->assertThrows(
            static fn () => ContributionOwner::core()->assertOwns('content.read', $strict),
            ContributionRejected::class,
            'Surface name cannot silently select core exemption.',
        );
        $this->assertThrows(
            static fn () => $owner->assertOwns('content.read', $corePolicy),
            ContributionRejected::class,
            'Core exemption cannot broaden a package owner.',
        );
        $maximum = 'acme.blog.' . str_repeat('a', 246);
        $owner->assertOwns($maximum, $strict);
        $this->assertSame(256, strlen($maximum), 'Exact identifier upper bound accepted.');
    }

    /**
     * Slash aliases and indexed document kinds are explicit lists, isolated to one surface.
     *
     * @return void
     * @since 0.1.0
     */
    public function testSlashPolicyAndConfigurationBounds(): void
    {
        $policy = SurfaceIdentifierPolicy::slash('documents', ['core', 'design.core'], ['block', 'pattern']);
        ContributionOwner::core()->assertOwns('block design.core/hero', $policy);
        ContributionOwner::extension('acme/blog')->assertOwns('pattern acme.blog/card', $policy);
        foreach (['block other/hero', 'unknown core/hero', 'core/hero', 'block core/', 'block core/../hero',
            'block core/hero/extra', 'block  core/hero'] as $invalid) {
            $this->assertThrows(
                static fn () => ContributionOwner::core()->assertOwns($invalid, $policy),
                ContributionRejected::class,
                'Invalid slash/index input fails.',
            );
        }
        ContributionOwner::core()->assertOwns('core/hero', SurfaceIdentifierPolicy::slash('plain'));
        foreach (['', 'Space name', 'x' . str_repeat('y', 80), "bad\n"] as $surface) {
            $this->assertThrows(
                static fn () => SurfaceIdentifierPolicy::dotted($surface),
                ContributionRejected::class,
                'Invalid surface fails at construction.',
            );
        }
        foreach ([[], ['core', 'core'], ['../core'], array_fill(0, 17, 'core')] as $namespaces) {
            $this->assertThrows(
                static fn () => SurfaceIdentifierPolicy::slash('test', $namespaces),
                ContributionRejected::class,
                'Invalid aliases fail.',
            );
        }
        foreach ([['block', 'block'], ['bad kind'], array_fill(0, 33, 'block')] as $kinds) {
            $this->assertThrows(
                static fn () => SurfaceIdentifierPolicy::slash('test', ['core'], $kinds),
                ContributionRejected::class,
                'Invalid index kinds fail.',
            );
        }
    }

    /**
     * Dotted namespace collisions cannot overwrite, inspect or remove another exact owner.
     *
     * @return void
     * @since 0.1.0
     */
    public function testRegistryOwnershipOrderingAndCapacity(): void
    {
        $policy = SurfaceIdentifierPolicy::dotted('records');
        $registry = new OwnedContributionRegistry($policy, 3);
        $owner = ContributionOwner::extension('a.b/c');
        $collision = ContributionOwner::extension('a/b.c');
        $core = ContributionOwner::core();
        $registry->register($core, new Definition('core.z', ['id' => 'core.z']));
        $registry->register($owner, new Definition('a.b.c.a', ['id' => 'a.b.c.a']));
        $registry->register($owner, new Definition('a.b.c.z', ['id' => 'a.b.c.z']));
        $this->assertSame(
            [['id' => 'a.b.c.a'], ['id' => 'a.b.c.z'], ['id' => 'core.z']],
            $registry->definitions(),
            'Bytewise identifier ordering must not depend on registration order.',
        );
        $this->assertSame($owner, $registry->entries()[0]['owner'], 'Owner recorded outside payload.');
        $this->assertSame(null, $registry->definition($collision, 'a.b.c.a'), 'Dotted collision cannot read.');
        $this->assertSame(null, $registry->definition($owner, 'missing'), 'Absent lookup indistinguishable.');
        $this->assertThrows(
            static fn () => $registry->register($collision, new Definition('a.b.c.a')),
            ContributionRejected::class,
            'Dotted collision cannot replace.',
        );
        $this->assertThrows(
            static fn () => $registry->register($owner, new Definition('a.b.c.b')),
            ContributionRejected::class,
            'Capacity is enforced without mutation.',
        );
        $registry->remove($collision);
        $this->assertSame(2, count($registry->ownedBy($owner)), 'Foreign removal cannot delete entries.');
        $registry->remove($owner);
        $registry->remove($owner);
        $this->assertSame([['id' => 'core.z']], $registry->definitions(), 'Only the exact owner is removed.');
        $this->assertSame([], $registry->ownedBy($owner), 'Missing owner exports an empty list.');
        foreach ([0, 10001] as $capacity) {
            $this->assertThrows(
                static fn () => new OwnedContributionRegistry($policy, $capacity),
                ContributionRejected::class,
                'Invalid capacity fails.',
            );
        }
    }

    /**
     * A definition object, exported PHP reference or returned array cannot mutate registered state.
     *
     * @return void
     * @since 0.1.0
     */
    public function testSnapshotsDetachReferencesAndImplementations(): void
    {
        $owner = ContributionOwner::core();
        $registry = new OwnedContributionRegistry(SurfaceIdentifierPolicy::dotted('snapshots'));
        $shared = ['value' => 'original'];
        $definition = new Definition('core.item', ['nested' => &$shared]);
        $registry->register($owner, $definition);
        $definition->id = 'core.changed';
        $shared['value'] = 'changed';
        $definition->document = [];
        $copy = $registry->definition($owner, 'core.item');
        $this->assertSame(['nested' => ['value' => 'original']], $copy, 'Registered data must be detached.');
        $copy['nested'] = [];
        $this->assertSame(
            ['nested' => ['value' => 'original']],
            $registry->definition($owner, 'core.item'),
            'Returned copies must not mutate the registry.',
        );
    }

    /**
     * Reentrant definition exports cannot overwrite a foreign entry or exceed capacity.
     *
     * @return void
     * @since 0.1.0
     */
    public function testReentrantRegistrationRechecksCommitConditions(): void
    {
        $policy = SurfaceIdentifierPolicy::dotted('reentrant');
        $first = ContributionOwner::extension('a.b/c');
        $second = ContributionOwner::extension('a/b.c');
        $registry = new OwnedContributionRegistry($policy);
        $nested = new ReentrantDefinition('a.b.c.item', static function () use ($registry, $second): void {
            $registry->register($second, new Definition('a.b.c.item', ['nested' => true]));
        });
        $error = $this->assertThrows(
            static fn () => $registry->register($first, $nested),
            ContributionRejected::class,
            'Reentrant collision refuses outer registration.',
        );
        $this->assertTrue($error instanceof ContributionRejected, 'Typed refusal.');
        $this->assertSame(null, $registry->definition($first, 'a.b.c.item'), 'Outer owner cannot claim nested entry.');
        $this->assertSame(['nested' => true], $registry->definition($second, 'a.b.c.item'), 'Nested owner preserved.');

        $bounded = new OwnedContributionRegistry($policy, 1);
        $nested = new ReentrantDefinition('a.b.c.outer', static function () use ($bounded, $first): void {
            $bounded->register($first, new Definition('a.b.c.inner', ['nested' => true]));
        });
        $this->assertThrows(
            static fn () => $bounded->register($first, $nested),
            ContributionRejected::class,
            'Reentrant registration cannot bypass capacity.',
        );
        $this->assertSame([['nested' => true]], $bounded->definitions(), 'Only nested entry occupies capacity.');
    }

    /**
     * Reject executable and non-finite values, recursion and resource exhaustion atomically.
     *
     * @return void
     * @since 0.1.0
     */
    public function testHostileDefinitionDocuments(): void
    {
        $owner = ContributionOwner::core();
        $registry = new OwnedContributionRegistry(SurfaceIdentifierPolicy::dotted('bounded'));
        $recursive = [];
        $recursive['self'] = &$recursive;
        $large = array_fill(0, 18, str_repeat('a', 65536));
        foreach ([new \stdClass(), static fn () => null, INF, NAN, $recursive, str_repeat('a', 65537),
            $large, array_fill(0, 10001, null)] as $invalid) {
            $this->assertThrows(
                static fn () => $registry->register($owner, new Definition('core.bad', ['value' => $invalid])),
                ContributionRejected::class,
                'Unsafe document fails before registration.',
            );
            $this->assertSame([], $registry->definitions(), 'Refusal must be atomic.');
        }
        $data = ['null' => null, 'bool' => true, 'int' => PHP_INT_MAX, 'float' => 1.25,
            'unicode' => 'Kumwe — together', 'list' => [1, 'x'], 'empty' => []];
        $registry->register($owner, new Definition('core.safe', $data));
        $this->assertSame($data, $registry->definition($owner, 'core.safe'), 'Valid data and order preserved.');
    }
}
