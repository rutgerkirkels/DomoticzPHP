<?php
/**
 * Device class
 *
 * @package rutgerkirkels\domoticz_php
 * @author Rutger Kirkels <rutger@kirkels.nl>a
 */
namespace rutgerkirkels\DomoticzPHP\Devices;

use rutgerkirkels\DomoticzPHP\Connector;

abstract class AbstractDevice
{
//    protected $AddjMulti;
//    protected $AddjMulti2;
//    protected $AddjValue;
//    protected $AddjValue2;
//    protected $Barometer;
    protected $batteryLevel;
//    protected $CustomImage;
    protected $data;
    protected $description;
//    protected $DewPoint;
    protected $favorite;
//    protected $Forecast;
//    protected $ForecastStr;
    protected $hardwareId;
    protected $hardwareName;
    protected $hardwareType;
//    protected $HardwareTypeVal;
//    protected $HaveTimeout;
//    protected $Humidity;
//    protected $HumidityStatus;
    protected $id;
    protected $name;
//    protected $Notifications;
//    protected $PlanID;
//    protected $PlanIDs;
    protected $protected;
//    protected $ShowNotifications;
    protected $signalLevel;
//    protected $SubType;
//    protected $Temp;
    protected $timers;
//    protected $Type;
//    protected $TypeImg;
//    protected $Unit;
    protected $used;
//    protected $XOffset;
//    protected $YOffset;
//    protected $forecast_url;
    protected $idx;
    /**
     * @var string
     */
    protected $status;
    protected $lastUpdate;


    public function __construct(object $deviceData) {
        $this->id = $deviceData->ID;
        $this->idx = intval($deviceData->idx);
        $this->name = $deviceData->Name;
        $this->lastUpdate = new \DateTime($deviceData->LastUpdate);
        $this->protected = $deviceData->Protected == 1 ? true : false;
        $this->used = $deviceData->Used == 1 ? true: false;
        $this->description = $deviceData->Description;
        $this->timers = $deviceData->Timers == 'true' ? true : false;
        $this->hardwareName = $deviceData->HardwareName;
        $this->hardwareType = $deviceData->HardwareType;
        $this->hardwareId = $deviceData->HardwareID;
        $this->status = $deviceData->Status;
        $this->favorite = $deviceData->Favorite == 1 ? true : false;
        $this->data = $deviceData->Data;
        $this->signalLevel = $deviceData->SignalLevel;
        $this->batteryLevel = $deviceData->BatteryLevel;
    }

    /**
     * @return \DateTime
     */
    public function getLastUpdate(): \DateTime
    {
        return $this->lastUpdate;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getIdx(): int
    {
        return $this->idx;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getHardwareId()
    {
        return $this->hardwareId;
    }

    /**
     * @return mixed
     */
    public function getHardwareName()
    {
        return $this->hardwareName;
    }

    /**
     * @return mixed
     */
    public function getHardwareType()
    {
        return $this->hardwareType;
    }


}