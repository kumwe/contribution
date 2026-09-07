<?php

declare(strict_types=1);

namespace Kumwe\Contribution\Tests\Fixture;

use Closure;
use Kumwe\Contribution\ContributionDefinition;

/**
 * Hostile definition exercising nested registry mutations during export.
 *
 * @since 0.1.0
 */
final readonly class ReentrantDefinition implements ContributionDefinition
{
    /**
     * Capture a nested mutation for the regression only.
     *
     * @param string $id Outer contribution identity.
     * @param Closure(): void $mutation Nested registry mutation.
     * @since 0.1.0
     */
    public function __construct(private string $id, private Closure $mutation)
    {
    }

    /**
     * Return the outer identity.
     *
     * @return string Identifier.
     * @since 0.1.0
     */
    public function identifier(): string
    {
        return $this->id;
    }

    /**
     * Mutate during export to prove post-export commit checks are enforced.
     *
     * @return array<string, mixed> Outer declaration data.
     * @since 0.1.0
     */
    public function toArray(): array
    {
        ($this->mutation)();

        return ['identifier' => $this->id];
    }
}
