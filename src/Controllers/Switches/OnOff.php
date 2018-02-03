<?php
/**
 * Created by PhpStorm.
 * User: rutgerkirkels
 * Date: 03-02-18
 * Time: 10:49
 */

namespace rutgerkirkels\DomoticzPHP\Controllers\Switches;


use rutgerkirkels\DomoticzPHP\Client;
use rutgerkirkels\DomoticzPHP\Connector;
use rutgerkirkels\DomoticzPHP\Controllers\AbstractController;

class OnOff extends AbstractController
{
    protected $device;
    protected $connector;

    public function __construct(\rutgerkirkels\DomoticzPHP\Devices\Switches\OnOff $device)
    {
        $this->device = $device;
        $this->connector = Connector::getInstance();
    }

    public function turnOn() {
        $turnedOn = $this->connector->executeCommand([
            'param' => 'switchlight',
            'idx' => $this->device->getIdx(),
            'switchcmd' => 'On'
        ]);
    }

    public function turnOff() {
        $turnedOff = $this->connector->executeCommand([
            'param' => 'switchlight',
            'idx' => $this->device->getIdx(),
            'switchcmd' => 'Off'
        ]);
    }
}