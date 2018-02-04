<?php

namespace rutgerkirkels\DomoticzPHP\Factories;

use rutgerkirkels\DomoticzPHP\Devices\TempAndHumidity\WTGR800;

class TempAndHumidityFactory extends AbstractDeviceFactory
{
    protected $data;

    public function __construct($deviceData)
    {
        switch ($deviceData->SubType) {

            case 'WTGR800':
                $this->data = new WTGR800($deviceData);
                break;


            default:

        }
    }
}