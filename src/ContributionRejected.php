<?php

declare(strict_types=1);

namespace Kumwe\Contribution;

use InvalidArgumentException;

/**
 * Stable, typed refusal of contribution input; no registry state changes when this is thrown.
 *
 * @since 0.1.0
 */
final class ContributionRejected extends InvalidArgumentException
{
    /**
     * Record a stable reason and a diagnostic without retaining the rejected payload.
     *
     * @param string $reason Machine-readable reason described in the public API.
     * @param string $message Safe diagnostic supplied by the rejecting operation.
     * @since 0.1.0
     */
    public function __construct(public readonly string $reason, string $message)
    {
        parent::__construct($message);
    }
}
