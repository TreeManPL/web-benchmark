<?php

namespace App\Utils\Reports;

use App\Domain\Report\ResultsInterface;
use App\Domain\Url\Url;
use App\Domain\Url\Urls;

/**
 * Interface ResultCreatorInterface
 * @package App\Utils\Reports
 */
interface ResultCreatorInterface {
    /**
     * @param Url $reference
     * @param Urls $compare
     * @return ResultsInterface
     */
    public function create(Url $reference, Urls $compare): ResultsInterface;
}