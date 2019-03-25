<?php

namespace App\Utils\DataProviders;

use App\Domain\Report\ResultsInterface;
use App\Domain\Url\Url;
use App\Domain\Url\Urls;

/**
 * Interface DataProviderInterface
 * @package App\Utils\DataProviders
 */
interface DataProviderInterface {
    public function getResults(Url $referenceUrl, Urls $compareToUrls, bool $force): ResultsInterface;
}