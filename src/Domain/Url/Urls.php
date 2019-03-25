<?php

namespace App\Domain\Url;

/**
 * Class Urls
 * @package App\Domain\Url
 */
class Urls {
    /**
     * @var array
     */
    private $urls;

    /**
     * Urls constructor.
     * @param array|null $urls
     */
    public function __construct(?array $urls = null)
    {
        $this->urls = [];
        $this->addBatch($urls);
    }

    /**
     * @param array|null $urls
     * @return Urls
     */
    public function addBatch(?array $urls): Urls
    {
        if(is_array($urls)) {
            foreach ($urls as $url) {
                if ($url instanceof Url) {
                    $this->add($url);
                }
            }
        }
        return $this;
    }

    /**
     * @param Url $url
     * @return Urls
     */
    public function add(Url $url): Urls
    {
        $this->urls[] = $url;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getUrls(): ?array
    {
        return $this->urls;
    }
}