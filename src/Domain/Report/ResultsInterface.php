<?php

namespace App\Domain\Report;

/**
 * Interface ResultsInterface
 * @package App\Domain\Report
 */
interface ResultsInterface {
    /**
     * @return array
     */
    public function getHeaders(): array;

    /**
     * @return array|null
     */
    public function getResults(): ?array;
}