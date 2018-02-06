<?php

namespace rutgerkirkels\DomoticzPHP\Factories;


use rutgerkirkels\DomoticzPHP\Devices\Usage\Electric;

class UsageFactory extends AbstractDeviceFactory
{
    protected $data;

    public function __construct($deviceData)
    {
        switch ($deviceData->SubType) {

            case 'Electric':
                $this->data = new Electric($deviceData);
                break;


            default:

        }
    }
}