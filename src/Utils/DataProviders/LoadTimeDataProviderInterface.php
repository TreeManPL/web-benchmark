<?php
namespace App\Utils\DataProviders;

use App\Domain\Url\Url;

/**
 * Interface LoadTimeDataProviderInterface
 * @package App\Utils\DataProviders
 */
interface LoadTimeDataProviderInterface {
    /**
     * @param Url $url
     * @return float|null
     */
    public function getLoadTime(Url $url): ?float;
}