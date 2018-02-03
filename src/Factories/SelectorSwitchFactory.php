<?php
/**
 * Created by PhpStorm.
 * User: rutgerkirkels
 * Date: 02-02-18
 * Time: 00:50
 */

namespace rutgerkirkels\DomoticzPHP\Factories;


use rutgerkirkels\DomoticzPHP\Devices\Switches\Selector;

class SelectorSwitchFactory extends AbstractDeviceFactory
{
    public $data;

    public function __construct($deviceData)
    {
        switch ($deviceData->SwitchType) {

            case 'Selector':
                $this->data = new Selector($deviceData);
                break;

        }
    }
}