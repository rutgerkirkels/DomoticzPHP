<?php
/**
 * Created by PhpStorm.
 * User: rutgerkirkels
 * Date: 04-02-18
 * Time: 17:58
 */

namespace rutgerkirkels\DomoticzPHP\Factories;


use rutgerkirkels\DomoticzPHP\Factories\Thermostat\SetPointFactory;

class ThermostatFactory extends AbstractDeviceFactory
{
    protected $data;

    public function __construct($deviceData)
    {
        switch ($deviceData->SubType) {

            case 'SetPoint':
                $this->data =  (new SetPointFactory($deviceData))->get();
                break;


            default:

        }
    }
}