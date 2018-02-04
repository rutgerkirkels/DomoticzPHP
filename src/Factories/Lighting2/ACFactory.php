<?php


namespace rutgerkirkels\DomoticzPHP\Factories\Lighting2;


use rutgerkirkels\DomoticzPHP\Devices\Switches\OnOff;
use rutgerkirkels\DomoticzPHP\Factories\AbstractDeviceFactory;

class ACFactory extends AbstractDeviceFactory
{
    public $data;

    public function __construct(object $deviceData)
    {
        switch ($deviceData->SwitchType) {

            case 'On/Off':
                $this->data = new OnOff($deviceData);
                break;

        }
    }
}