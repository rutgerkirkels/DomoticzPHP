<?php
/**
 * Created by PhpStorm.
 * User: rutgerkirkels
 * Date: 03-02-18
 * Time: 10:40
 */

namespace rutgerkirkels\DomoticzPHP\Factories;



use rutgerkirkels\DomoticzPHP\Controllers\Switches\OnOff;
use rutgerkirkels\DomoticzPHP\Devices\Switches\AbstractSwitch;

class ControllerFactory
{
    protected $device;
    public function __construct(AbstractSwitch $device)
    {
        $this->device = $device;
    }

    public function get() {
        $class = get_class($this->device);

        switch ($class) {

            case 'rutgerkirkels\\DomoticzPHP\\Devices\\Switches\\OnOff':
                return new OnOff($this->device);
                break;

            case 'rutgerkirkels\DomoticzPHP\Devices\Switches\Dimmer':


        }
    }
}