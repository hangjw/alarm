<?php

namespace Hangjw\Alarm;

use GuzzleHttp\Client;
use Illuminate\Config\Repository;
use Symfony\Component\HttpFoundation\Request;

class AlarmManager
{

    protected $config;

    protected $request;

    protected $drivers;

    protected $customCreators;

    protected $client;

    protected $initialDrivers = [
        'ding' => 'Ding',
    ];

    public function __construct(Repository $config, Request $request = null, Client $client)
    {
        $this->client = $client;
        $this->config = $config;
        $this->request = $request;
    }


    public function driver($driver)
    {
        if (!isset($this->drivers[$driver])) {
            $this->drivers[$driver] = $this->createDriver($driver);
        }

        if ($this->drivers[$driver]) {
            $this->drivers[$driver]->setTitle($this->config->get('alarm.title'));
        }
        return $this->drivers[$driver];
    }

    protected function createDriver($driver)
    {
        if (isset($this->initialDrivers[$driver])) {
            $provider = $this->initialDrivers[$driver];
            $provider = __NAMESPACE__ . '\\Providers\\' . $provider . 'Provider';
            return $this->buildProvider($provider, $this->config->get('alarm.' . $driver));
        }
        if (isset($this->customCreators[$driver])) {
            return $this->callCustomCreator($driver);
        }

        throw new \InvalidArgumentException("Driver [$driver] not supported.");
    }

    protected function callCustomCreator($driver)
    {
        return $this->customCreators[$driver]($this->config);
    }


    public function getDrivers()
    {
        return $this->drivers;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function buildProvider($provider, $config)
    {
        return new $provider(
            $this->getRequest(),
            $this->getClient(),
            $config
        );
    }

    public function extend($driver, \Closure $callback)
    {
        $this->customCreators[$driver] = $callback;

        return $this;
    }
}
