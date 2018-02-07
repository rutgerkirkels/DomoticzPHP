<?php

namespace rutgerkirkels\DomoticzPHP\Factories\Lighting2;

use rutgerkirkels\DomoticzPHP\Devices\Switches\OnOff;
use rutgerkirkels\DomoticzPHP\Factories\AbstractDeviceFactory;

/**
 * Class ACFactory
 * @package rutgerkirkels\DomoticzPHP\Factories\Lighting2
 */
class ACFactory extends AbstractDeviceFactory
{
    /**
     * @var OnOff
     */
    public $data;

    /**
     * ACFactory constructor.
     * @param object $deviceData
     */
    public function __construct(object $deviceData)
    {
        switch ($deviceData->SwitchType) {

            case 'On/Off':
                $this->data = new OnOff($deviceData);
                break;

        }
    }
}