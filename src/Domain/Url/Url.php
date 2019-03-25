<?php

namespace App\Domain\Url;

/**
 * Class Url
 * @package App\Domain\Url
 */
class Url {
    /**
     * @var string
     */
    private $url;

    /**
     * Url constructor.
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function get(): string
    {
        return $this->url;
    }
}