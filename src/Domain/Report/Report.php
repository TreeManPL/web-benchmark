<?php

namespace App\Domain\Report;

/**
 * Class Report
 * @package App\Domain\Report
 */
class Report implements ResultsInterface {
    /**
     * @var ResultsInterface[]
     */
    private $elements;

    /**
     * Report constructor.
     */
    public function __construct()
    {
        $this->elements = [];
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        $reduce = function ($acc, $elem){
            return array_merge($acc, $elem->getHeaders());
        };
        return array_reduce($this->elements, $reduce, []);
    }

    /**
     * @return array|null
     */
    public function getResults(): ?array
    {
        $reduce = function ($acc, $elem){
            return array_merge_recursive($acc, $elem->getResults());
        };
        return array_reduce($this->elements, $reduce, []);
    }

    /**
     * @param ResultsInterface $benchmarkResult
     * @return Report
     */
    public function addElement(ResultsInterface $benchmarkResult): Report
    {
        $this->elements[] = $benchmarkResult;
        return $this;
    }
}