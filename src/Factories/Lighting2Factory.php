<?php

namespace rutgerkirkels\DomoticzPHP\Factories;

/**
 * Class Lighting2Factory
 * @package rutgerkirkels\DomoticzPHP\Factories
 */
class Lighting2Factory extends AbstractDeviceFactory
{
    protected $data;

    public function __construct($deviceData)
    {
        switch ($deviceData->SubType) {

            case 'AC':
                $this->data =  (new SwitchFactory($deviceData))->get();
                break;

                
            default:

        }
    }
}