<?php

namespace App\Utils\DataProviders;

use App\Domain\Url\Url;

/**
 * Class CurlLoadTimeDataProvider
 * @package App\Utils\DataProviders
 */
class CurlLoadTimeDataProvider implements LoadTimeDataProviderInterface {
    /**
     * @var array|null
     */
    private $options;

    /**
     * @var array|null
     */
    private $results;

    /**
     * CurlLoadTimeDataProvider constructor.
     * @param array|null $options
     */
    public function __construct(?array $options = null)
    {
        $fallBackOptions = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_AUTOREFERER    => true,
            CURLOPT_CONNECTTIMEOUT => 120,
            CURLOPT_TIMEOUT        => 20,
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_SSL_VERIFYPEER => false
        ];

        $this->options = $options ?? $fallBackOptions;
    }

    /**
     * @param Url $url
     * @return float|null
     */
    public function getLoadTime(Url $url): ?float
    {
        return $this->results[$url->get()] ?? $this->benchmark($url);
    }

    /**
     * @param Url $url
     * @return float|null
     */
    private function benchmark(Url $url): ?float
    {
        $this->results[$url->get()] = null;
        $ch = curl_init($url->get());
        curl_setopt_array( $ch, $this->options);
        curl_exec($ch);
        if (!curl_errno($ch) && curl_getinfo($ch, CURLINFO_HTTP_CODE) === 200) {
            $this->results[$url->get()] = (float)curl_getinfo($ch, CURLINFO_TOTAL_TIME);
        }
        curl_close($ch);

        return $this->results[$url->get()];
    }
}