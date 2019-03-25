<?php

namespace App\Domain\Report;

/**
 * Class Result
 * @package App\Domain\Report
 */
class Result implements ResultsInterface {

    /**
     * @var array
     */
    private $headers;

    /**
     * @var array|null
     */
    private $results;

    /**
     * Result constructor.
     * @param $headers
     * @param $results
     */
    public function __construct($headers, $results)
    {
        $this->headers = $headers;
        $this->results = $results;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @return array|null
     */
    public function getResults(): ?array
    {
        return $this->results;
    }
}