<?php

namespace rutgerkirkels\DomoticzPHP\Factories\Thermostat;


use rutgerkirkels\DomoticzPHP\Factories\AbstractDeviceFactory;

class SetPointFactory extends AbstractDeviceFactory
{
    public $data;

    public function __construct(object $deviceData)
    {
        switch ($deviceData->SubType) {

            case 'SetPoint':
                $this->data = new \rutgerkirkels\DomoticzPHP\Devices\Thermostat\SetPoint($deviceData);
                break;

        }
    }
}