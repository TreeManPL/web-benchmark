<?php

namespace App\Utils\Reports;

use App\Domain\Report\Result;
use App\Domain\Report\ResultsInterface;
use App\Domain\Url\Url;
use App\Domain\Url\Urls;
use App\Utils\DataProviders\LoadTimeDataProviderInterface;

/**
 * Class LoadTimeResultsCreator
 * @package App\Utils\Reports
 */
class LoadTimeResultsCreator implements ResultCreatorInterface {

    /**
     * @var array
     */
    private static $headers = ['Load time'];

    /**
     * @var LoadTimeDataProviderInterface
     */
    private $loadTimeDataProvider;

    /**
     * LoadTimeResultsCreator constructor.
     * @param LoadTimeDataProviderInterface $loadTimeDataProvider
     */
    public function __construct(LoadTimeDataProviderInterface $loadTimeDataProvider)
    {
        $this->loadTimeDataProvider = $loadTimeDataProvider;
    }

    /**
     * @param Url $reference
     * @param Urls $compare
     * @return ResultsInterface
     */
    public function create(Url $reference, Urls $compare): ResultsInterface
    {
        return new Result(self::$headers, $this->getResults($reference, $compare));
    }

    /**
     * @param Url $reference
     * @param Urls $compare
     * @return array|null
     */
    private function getResults(Url $reference, Urls $compare): ?array
    {
        $results = [];
        $results[$reference->get()] = [$this->loadTimeDataProvider->getLoadTime($reference)] ?? ['DNF'];
        foreach ($compare->getUrls() as $url) {
            $urlLoadTime = $this->loadTimeDataProvider->getLoadTime($url);
            $results[$url->get()] = $urlLoadTime === null ? ['DNF'] : [$urlLoadTime];
        }
        return $results;
    }
}