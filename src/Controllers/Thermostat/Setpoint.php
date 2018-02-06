<?php

namespace rutgerkirkels\DomoticzPHP\Controllers\Thermostat;

use rutgerkirkels\DomoticzPHP\Controllers\AbstractController;

class Setpoint extends AbstractController
{
    /**
     * @var \rutgerkirkels\DomoticzPHP\Devices\Thermostat\SetPoint
     */
    protected $device;

    protected $connector;

    public function __construct(\rutgerkirkels\DomoticzPHP\Devices\Thermostat\SetPoint $device)
    {
        parent::__construct($device);
    }

    public function set(float $data) {
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