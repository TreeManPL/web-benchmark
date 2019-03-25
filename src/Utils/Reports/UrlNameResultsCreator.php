<?php

namespace App\Utils\Reports;

use App\Domain\Report\Result;
use App\Domain\Report\ResultsInterface;
use App\Domain\Url\Url;
use App\Domain\Url\Urls;

/**
 * Class UrlNameResultsCreator
 * @package App\Utils\Reports
 */
class UrlNameResultsCreator implements ResultCreatorInterface {
    /**
     * @var array
     */
    private static $headers = ['URL'];

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
        $results[$reference->get()] = [$reference->get()];
        foreach ($compare->getUrls() as $url) {
            $name = $url->get();
            $results[$name] = [$name];
        }
        return $results;
    }
}