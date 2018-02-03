<?php

namespace rutgerkirkels\DomoticzPHP\Factories;

use rutgerkirkels\DomoticzPHP\Devices\Switches\Dimmer;
use rutgerkirkels\DomoticzPHP\Devices\Switches\OnOff;

/**
 * Class SwitchFactory
 * @package rutgerkirkels\DomoticzPHP\Factories
 */
class SwitchFactory extends AbstractDeviceFactory
{
    public $data;

    public function __construct(object $deviceData)
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