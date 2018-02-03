<?php
/**
 * Created by PhpStorm.
 * User: rutgerkirkels
 * Date: 01-02-18
 * Time: 22:50
 */

namespace rutgerkirkels\DomoticzPHP\Factories;


use rutgerkirkels\DomoticzPHP\Devices\Switches\Dimmer;
use rutgerkirkels\DomoticzPHP\Devices\Switches\OnOff;

class SwitchFactory extends AbstractDeviceFactory
{
    public $data;

    public function __construct($deviceData)
    {
        switch ($deviceData->SwitchType) {

            case 'On/Off':
                $this->data = new OnOff($deviceData);
                break;

            case 'Dimmer':
                $this->data = new Dimmer($deviceData);
                break;

        }
    }

}