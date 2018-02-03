<?php

namespace rutgerkirkels\DomoticzPHP\Devices\Switches;

use rutgerkirkels\DomoticzPHP\Devices\AbstractDevice;

/**
 * Class AbstractSwitch
 * @package rutgerkirkels\DomoticzPHP\Devices\Switches
 */
class AbstractSwitch extends AbstractDevice
{
    protected $AddjMulti;
    protected $AddjMulti2;
    protected $AddjValue;
    protected $AddjValue2;
    protected $Barometer;
    protected $BatteryLevel;
    protected $CustomImage;
    protected $Data;
    protected $Description;
    protected $DewPoint;
    protected $Favorite;
    protected $Forecast;
    protected $ForecastStr;
    protected $HardwareTypeVal;
    protected $HaveTimeout;
    protected $PlanID;
    protected $PlanIDs;
    protected $SignalLevel;
    protected $TypeImg;
    protected $Unit;
    protected $XOffset;
    protected $YOffset;

    public function __construct(object $deviceData)
    {
        parent::__construct($deviceData);
//        var_dump($deviceData);die;
    }

    public function isOn() {
        if ($this->getStatus() !== 'Off') {
            return true;
        }
        return false;
    }
}