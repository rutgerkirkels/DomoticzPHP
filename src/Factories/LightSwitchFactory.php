<?php

namespace rutgerkirkels\DomoticzPHP\Factories;

/**
 * Class LightSwitchFactory
 * @package rutgerkirkels\DomoticzPHP\Factories
 */
class LightSwitchFactory extends AbstractDeviceFactory
{
    protected $data;

    public function __construct($deviceData)
    {
        switch ($deviceData->SubType) {

            case 'Switch':
                $this->data =  (new SwitchFactory($deviceData))->get();
                break;

            case 'Selector Switch':
                $this->data = (new SelectorSwitchFactory($deviceData))->get();
                break;

            default:
                $this->data = $deviceData->SubType;
        }
    }
}