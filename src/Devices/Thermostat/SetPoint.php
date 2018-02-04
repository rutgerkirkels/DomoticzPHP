<?php

namespace rutgerkirkels\DomoticzPHP\Devices\Thermostat;


use rutgerkirkels\DomoticzPHP\Devices\AbstractDevice;

/**
 * Class SetPoint
 * @package rutgerkirkels\DomoticzPHP\Devices\Thermostat
 */
class SetPoint extends AbstractDevice
{
    /**
     * @var float
     */
    protected $setPoint;

    public function __construct(object $deviceData)
    {
        parent::__construct($deviceData);
        $this->setSetPoint(floatval($this->data));
    }

    /**
     * @return float
     */
    public function getSetPoint(): float
    {
        return $this->setPoint;
    }

    /**
     * @param float $setPoint
     */
    protected function setSetPoint(float $setPoint): void
    {
        $this->setPoint = $setPoint;
    }


}