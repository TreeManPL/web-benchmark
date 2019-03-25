<?php

namespace App\Utils\DataProviders;

/**
 * Interface DataProvidersInterface
 * @package App\Utils\DataProviders
 */
interface DataProvidersInterface {
    /**
     * @return LoadTimeDataProviderInterface
     */
    public function getLoadTimeDataProvider(): LoadTimeDataProviderInterface;
}