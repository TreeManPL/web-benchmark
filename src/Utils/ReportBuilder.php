<?php

namespace App\Utils;

use App\Domain\Report\Report;
use App\Domain\Url\Url;
use App\Domain\Url\Urls;
use App\Utils\DataProviders\DataProvidersInterface;
use App\Utils\Reports\DiffLoadTimeResultCreator;
use App\Utils\Reports\LoadTimeResultsCreator;
use App\Utils\Reports\ResultCreatorInterface;
use App\Utils\Reports\UrlNameResultsCreator;

class ReportBuilder {
    /**
     * @var
     */
    private $creators;

    public function __construct(DataProvidersInterface $dataProviders)
    {
        $this
            ->addCreator('name', new UrlNameResultsCreator())
            ->addCreator('loadtime', new LoadTimeResultsCreator($dataProviders->getLoadTimeDataProvider()))
            ->addCreator('loadtimediff', new DiffLoadTimeResultCreator($dataProviders->getLoadTimeDataProvider()))
        ;
    }

    /**
     * @param string $name
     * @param ResultCreatorInterface $creator
     * @return ReportBuilder
     */
    private function addCreator(string $name, ResultCreatorInterface $creator): ReportBuilder
    {
        $this->creators[$name] = $creator;
        return $this;
    }

    /**
     * @param string $name
     * @return ResultCreatorInterface|null
     */
    private function get(string $name): ?ResultCreatorInterface
    {

        return $this->creators[$name] ?? null;
    }

    /**
     * @param array $plan
     * @param Url $referenceUrl
     * @param Urls $compareToUrls
     * @return Report
     */
    public function run(array $plan, Url $referenceUrl, Urls $compareToUrls): Report
    {
        $report = new Report();
        foreach ($plan as $step) {
            $creator = $this->get($step);
            if ($creator !== null) {
                $result = $creator->create($referenceUrl, $compareToUrls);
                $report->addElement($result);
            }
        }

        return $report;
    }
}