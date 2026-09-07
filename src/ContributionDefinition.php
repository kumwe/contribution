<?php

declare(strict_types=1);

namespace Kumwe\Contribution;

/**
 * One stable declarative contribution, independent of a host or delivery surface.
 *
 * Implementations supply deterministic, bounded data. Registries snapshot the export and never store
 * the implementation object. Object instances, resources and non-finite values cannot enter that snapshot.
 *
 * @since 0.1.0
 */
interface ContributionDefinition
{
    /**
     * Return the complete identifier to validate under the registry's explicit surface policy.
     *
     * @return string Identifier unique within this surface.
     * @since 0.1.0
     */
    public function identifier(): string;

    /**
     * Export every declared field in deterministic order without performing host work.
     *
     * @return array<string, mixed> A data-only document; nested arrays and scalar/null values only.
     * @since 0.1.0
     */
    public function toArray(): array;
}
