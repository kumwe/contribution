<?php

declare(strict_types=1);

namespace Kumwe\Contribution;

/**
 * Owner-scoped inventory and removal contract; the consumer decides when lifecycle removal is authorized.
 *
 * @since 0.1.0
 */
interface ContributionSurface
{
    /**
     * Export this surface's declarations owned by one exact contributor.
     *
     * @param ContributionOwner $owner Owner whose declarations are requested.
     * @return list<mixed> Surface-specific exports; empty when the owner has no entries.
     * @since 0.1.0
     */
    public function ownedBy(ContributionOwner $owner): array;

    /**
     * Withdraw only this exact owner's entries; absence is a no-op.
     *
     * @param ContributionOwner $owner Owner whose entries are removed.
     * @return void
     * @since 0.1.0
     */
    public function remove(ContributionOwner $owner): void;
}
