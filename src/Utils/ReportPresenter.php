<?php

namespace App\Utils;

use App\Domain\Report\Report;
use Monolog\Logger;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;

/**
 * Class ReportPresenter
 * @package App\Utils
 */
class ReportPresenter{

    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @var Logger
     */
    private $fileLogger;

    /**
     * ReportPresenter constructor.
     * @param OutputInterface $output
     * @param Logger $fileLogger
     */
    public function __construct(OutputInterface $output, Logger $fileLogger)
    {
        $this->output = $output;
        $this->fileLogger = $fileLogger;
    }

    /**
     * @param Report $report
     */
    public function present(Report $report): void
    {
        $this->render($report);
        $this->writeToFile($report);
    }

    /**
     * @param Report $report
     */
    private function writeToFile(Report $report): void
    {
        $this->fileLogger->info('Report generate at ' . date('Y-m-d H:i:s') . $this->reportToString($report));
    }

    /**
     * @param Report $report
     * @return string
     */
    private function reportToString(Report $report): string
    {
        $headers = $report->getHeaders();
        return json_encode(array_map(function ($row) use ($headers){return array_combine($headers, $row);}, $report->getResults()));
    }

    /**
     * @param Report $report
     */
    private function render(Report $report): void
    {
        $this->output->writeln('Report generate at ' . date("Y-m-d H:i:s"));
        $result = new Table($this->output);
        $result->setHeaders($report->getHeaders());
        $result->addRows($report->getResults());
        $result->render();
    }
}