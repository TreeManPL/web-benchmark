<?php
namespace App\Tests\Domain\Result;

use App\Domain\Report\Report;
use App\Domain\Report\Result;
use PHPUnit\Framework\TestCase;

class ReportTest extends TestCase
{
    public function testMergeResult()
    {
        $report = new Report();

        $speedResult = [
            'http://www.google.com'=> ['http://www.google.com', 0.432],
            'http://www.facebook.com'  => ['http://www.facebook.com', 0.123]
        ];

        $dotResult = ['http://www.google.com' => ['***'], 'http://www.facebook.com' => ['*']];


        $firstResult = new Result(['Name','Spead'], $speedResult);
        $secondResult = new Result(['Dots'], $dotResult);

        $report->addElement($firstResult);
        $report->addElement($secondResult);

        $oracle = [
            'http://www.google.com'
                => ['http://www.google.com', 0.432, '***'],
            'http://www.facebook.com'
                => ['http://www.facebook.com', 0.123, '*']
        ];

        $this->assertEquals($oracle, $report->getResults());
    }

    public function testSingleTableResult()
    {
        $report = new Report();

        $dotResult = ['http://www.google.com' => ['***'], 'http://www.facebook.com' => ['*']];
        $result = new Result(['Dots'], $dotResult);

        $report->addElement($result);

        $oracle = [
            'http://www.google.com'
            => ['***'],
            'http://www.facebook.com'
            => ['*']
        ];

        $this->assertEquals($oracle, $report->getResults());

    }
}

