<?php

namespace rutgerkirkels\DomoticzPHP\Controllers\Thermostat;

use rutgerkirkels\DomoticzPHP\Connector;
use rutgerkirkels\DomoticzPHP\Controllers\AbstractController;

/**
 * Class Setpoint
 * @package rutgerkirkels\DomoticzPHP\Controllers\Thermostat
 */
class Setpoint extends AbstractController
{
    /**
     * @var \rutgerkirkels\DomoticzPHP\Devices\Thermostat\SetPoint
     */
    protected $device;

    /**
     * @var Connector
     */
    protected $connector;

    /**
     * Setpoint constructor.
     * @param \rutgerkirkels\DomoticzPHP\Devices\Thermostat\SetPoint $device
     */
    public function __construct(\rutgerkirkels\DomoticzPHP\Devices\Thermostat\SetPoint $device)
    {
        parent::__construct($device);
    }

    /**
     * @param float $data
     * @return bool
     */
    public function set(float $data)
    {
        $set = $this->connector->executeCommand([
            'param' => 'udevice',
            'idx' => $this->device->getIdx(),
            'nvalue' => 0,
            'svalue' => $data
        ]);

        if ($set) {
            return true;
        }

        return false;
    }
}