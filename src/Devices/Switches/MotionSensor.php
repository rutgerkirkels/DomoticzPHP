<?php

namespace rutgerkirkels\DomoticzPHP\Devices\Switches;

/**
 * Class MotionSensor
 * @package rutgerkirkels\DomoticzPHP\Devices\Switches
 */
class MotionSensor extends AbstractSwitch
{
    public function getBatteryLevel() {
        return $this->batteryLevel;
    }

}