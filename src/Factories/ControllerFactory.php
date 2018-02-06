<?php

namespace rutgerkirkels\DomoticzPHP\Factories;

use rutgerkirkels\DomoticzPHP\Controllers\Switches\OnOff;
use rutgerkirkels\DomoticzPHP\Controllers\Switches\Selector;
use rutgerkirkels\DomoticzPHP\Devices\AbstractDevice;
use rutgerkirkels\DomoticzPHP\Devices\Switches\AbstractSwitch;
use rutgerkirkels\DomoticzPHP\Controllers\Switches\Dimmer;
use rutgerkirkels\DomoticzPHP\Controllers\Thermostat\SetPoint;

/**
 * Class ControllerFactory
 * @package rutgerkirkels\DomoticzPHP\Factories
 */
class ControllerFactory
{
    /**
     * @var AbstractSwitch
     */
    protected $device;

    public function __construct(AbstractDevice $device)
    {
        $this->device = $device;
    }

    public function get() {
        $class = get_class($this->device);

        switch ($class) {

            case 'rutgerkirkels\\DomoticzPHP\\Devices\\Switches\\OnOff':
                return new OnOff($this->device);
                break;

            case 'rutgerkirkels\\DomoticzPHP\\Devices\\Switches\\Dimmer':
                return new Dimmer($this->device);
                break;

            case 'rutgerkirkels\\DomoticzPHP\\Devices\\Switches\\Selector':
                return new Selector($this->device);
                break;

            case 'rutgerkirkels\\DomoticzPHP\\Devices\\Thermostat\\SetPoint':
                return new SetPoint($this->device);
                break;   
        }
    }
}