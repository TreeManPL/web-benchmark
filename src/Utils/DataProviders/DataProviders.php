<?php

namespace App\Utils\DataProviders;

/**
 * Class DataProviders
 * @package App\Utils\DataProviders
 */
class DataProviders implements DataProvidersInterface {
    /**
     * @var LoadTimeDataProviderInterface
     */
    private $loadTimeDataProvider;

    /**
     * DataProviders constructor.
     */
    public function __construct()
    {
        $this->loadTimeDataProvider = new CurlLoadTimeDataProvider();
    }

    /**
     * @return LoadTimeDataProviderInterface
     */
    public function getLoadTimeDataProvider(): LoadTimeDataProviderInterface
    {
        return $this->loadTimeDataProvider;
    }
}