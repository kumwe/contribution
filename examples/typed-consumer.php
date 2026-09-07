<?php

/**
 * Run the documented standalone declaration example through the consumer's Composer autoloader.
 *
 * @since 0.1.0
 */

declare(strict_types=1);

namespace Kumwe\Contribution\Example;

use Kumwe\Contribution\ContributionDefinition;
use Kumwe\Contribution\ContributionOwner;
use Kumwe\Contribution\OwnedContributionRegistry;
use Kumwe\Contribution\SurfaceIdentifierPolicy;
use RuntimeException;

/** @var list<string> $arguments */
$arguments = $_SERVER['argv'] ?? [];
$autoload = $arguments[1] ?? dirname(__DIR__) . '/vendor/autoload.php';
if (!is_file($autoload)) {
    fwrite(STDERR, "The consumer Composer autoloader is required.\n");
    exit(1);
}
require $autoload;

/**
 * One immutable declaration; consumers implement this interface for their own surface data.
 *
 * @since 0.1.0
 */
final readonly class ExampleDeclaration implements ContributionDefinition
{
    /**
     * Identify the declaration within the expected package namespace.
     *
     * @return string Stable identifier.
     * @since 0.1.0
     */
    public function identifier(): string
    {
        return 'acme.catalog.summary';
    }

    /**
     * Export deterministic metadata without a host dependency.
     *
     * @return array<string, mixed> Data-only declaration.
     * @since 0.1.0
     */
    public function toArray(): array
    {
        return ['identifier' => $this->identifier(), 'label' => 'Summary'];
    }
}

$owner = ContributionOwner::extension('acme/catalog');
$registry = new OwnedContributionRegistry(SurfaceIdentifierPolicy::dotted('catalog'), 100);
$registry->register($owner, new ExampleDeclaration());
$expected = ['identifier' => 'acme.catalog.summary', 'label' => 'Summary'];
if ($registry->definition($owner, 'acme.catalog.summary') !== $expected) {
    throw new RuntimeException('The registered declaration did not round-trip.');
}
$registry->remove($owner);
if ($registry->definitions() !== []) {
    throw new RuntimeException('Owner removal left a declaration behind.');
}
echo "Contribution consumer: registration, exact-owner lookup and removal passed.\n";
