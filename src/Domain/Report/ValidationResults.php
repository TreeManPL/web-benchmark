<?php

namespace App\Domain\Report;

/**
 * Class ValidationResults
 * @package App\Domain\Report
 */
class ValidationResults implements ResultsInterface {
    /**
     * @var array
     */
    private $results;

    /**
     * ValidationResults constructor.
     */
    public function __construct()
    {
        $this->results = [];
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return ['URL', 'Message'];
    }

    /**
     * @return array|null
     */
    public function getResults(): ?array
    {
        return $this->results;
    }

    /**
     * @param $url
     * @param string $message
     * @return $this
     */
    public function addResult($url, string $message)
    {
        $this->results[$url] = [$url, $message];

        return $this;
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->results);
    }
}