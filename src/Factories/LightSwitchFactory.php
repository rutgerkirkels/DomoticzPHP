<?php
/**
 * Created by PhpStorm.
 * User: rutgerkirkels
 * Date: 01-02-18
 * Time: 22:43
 */

namespace rutgerkirkels\DomoticzPHP\Factories;


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