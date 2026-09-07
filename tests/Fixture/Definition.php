<?php

declare(strict_types=1);

namespace Kumwe\Contribution\Tests\Fixture;

use Kumwe\Contribution\ContributionDefinition;

/**
 * Deliberately mutable fixture proving registry snapshots detach caller state.
 *
 * @since 0.1.0
 */
final class Definition implements ContributionDefinition
{
    /**
     * Store test-controlled input.
     *
     * @param string $id Identifier under test.
     * @param array<string, mixed> $document Data under test.
     * @since 0.1.0
     */
    public function __construct(public string $id, public array $document = [])
    {
    }

    /**
     * Expose the current fixture identifier.
     *
     * @return string Identifier.
     * @since 0.1.0
     */
    public function identifier(): string
    {
        return $this->id;
    }

    /**
     * Return test-controlled data, including invalid data in rejection cases.
     *
     * @return array<string, mixed> Document.
     * @since 0.1.0
     */
    public function toArray(): array
    {
        return $this->document;
    }
}
