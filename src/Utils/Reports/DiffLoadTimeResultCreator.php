<?php

namespace App\Utils\Reports;

use App\Domain\Report\Result;
use App\Domain\Report\ResultsInterface;
use App\Domain\Url\Url;
use App\Domain\Url\Urls;
use App\Utils\DataProviders\LoadTimeDataProviderInterface;

/**
 * Class DiffLoadTimeResultCreator
 * @package App\Utils\Reports
 */
class DiffLoadTimeResultCreator implements ResultCreatorInterface {

    /**
     * @var array
     */
    private static $headers = ['Diff'];

    /**
     * @var LoadTimeDataProviderInterface
     */
    private $loadTimeDataProvider;

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
        $refLoadTime =  $this->loadTimeDataProvider->getLoadTime($reference);
        $results[$reference->get()] = [0];

        foreach ($compare->getUrls() as $url) {
            if ($refLoadTime === null) {
                $results[$url->get()] = ['No ref. data'];
            } else {
                $urlLoadTime = $this->loadTimeDataProvider->getLoadTime($url);
                $results[$url->get()] = $urlLoadTime === null ? ['No data'] : [$urlLoadTime - $refLoadTime];
            }

        }
        return $results;
    }
}