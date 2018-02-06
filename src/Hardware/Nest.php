<?php

namespace rutgerkirkels\DomoticzPHP\Hardware;

use rutgerkirkels\DomoticzPHP\Devices\Switches\OnOff;
use rutgerkirkels\DomoticzPHP\Factories\ControllerFactory;

/**
 * Nest thermostat class
 * @package rutgerkirkels\DomoticzPHP\Hardware
 * @author Rutger Kirkels <rutger@kirkels.nl>
 */
class Nest extends AbstractHardware implements HardwareInterface
{
    /**
     * @var int
     */
    protected $heatingIdx;

    /**
     * @var int
     */
    protected $awayIdx;

    /**
     * @var int
     */
    protected $ecoIdx;

    /**
     * @var int
     */
    protected $setPointIdx;

    /**
     * @var int
     */
    protected $wtrg800Idx;

    /**
     * @var array
     */
    protected $controllableDevices;

    /**
     * Nest constructor.
     * @param int $id
     * @param string $name
     * @param array $devices
     * @param string|null $type
     */
    public function __construct(int $id, string $name, array $devices, string $type = null)
    {
        parent::__construct($id, $name, $devices, $type);

        // Try to find the IDX's for the diffenent devices in the Nest hardware
        $this->probeDevices();
    }

    /**
     * Tries to find the IDX's for the diffenent devices in the Nest hardware
     */
    protected function probeDevices() {
        foreach ($this->devices as $device) {

            if (preg_match('/heatingon/', strtolower($device->getName()))) {
                $this->heatingIdx = $device->getIdx();
            }

            if (preg_match('/away/', strtolower($device->getName()))) {
                $this->awayIdx = $device->getIdx();
            }

            if (preg_match('/eco/', strtolower($device->getName()))) {
                $this->ecoIdx = $device->getIdx();
            }

            if ($device->getType() == 'Thermostat' && $device->getSubType() == 'SetPoint') {
                $this->setPointIdx = $device->getIdx();
            }

            if ($device->getType() == 'TTemp + Humidity' && $device->getSubType() == 'WTGR800') {
                $this->setPointIdx = $device->getIdx();
            }
        }
    }

    /**
     * @return OnOff
     */
    public function getHeating() {
        if (!is_null($this->getHeatingIdx())) {
            return $this->getDeviceByIdx($this->getHeatingIdx());
        }
    }

    /**
     * @return int
     */
    protected function getHeatingIdx() {
        try {
            if (is_null($this->heatingIdx)) {
                throw new \Exception('Heating IDX for Nest not set.');
            }

            return $this->heatingIdx;
        }
        catch(\Exception $e) {
            trigger_error($e->getMessage(), E_USER_WARNING);
        }
    }


    /**
     * @return OnOff
     */
    public function getAway() {
        if (!is_null($this->getAwayIdx())) {
            return $this->getDeviceByIdx($this->getAwayIdx());
        }

        return false;
    }

    /**
     * @return int
     */
    protected function getAwayIdx() {
        try {
            if (is_null($this->awayIdx)) {
                throw new \Exception('Away IDX for Nest not set.');
            }

            return $this->awayIdx;
        }
        catch(\Exception $e) {
            trigger_error($e->getMessage(), E_USER_WARNING);
        }
    }

    /**
     * @return OnOff
     */
    public function getEco() {
        if (!is_null($this->getEcoIdx())) {
            return $this->getDeviceByIdx($this->getEcoIdx());
        }

        return false;
    }

    /**
     * @return int
     */
    protected function getSetPointIdx() {
        try {
            if (is_null($this->setPointIdx)) {
                throw new \Exception('SetPoint IDX for Nest not set.');
            }

            return $this->setPointIdx;
        }
        catch(\Exception $e) {
            trigger_error($e->getMessage(), E_USER_WARNING);
        }
    }

    /**
     * @return float
     */
    public function getHeatingTemperature() {
        return $this->getDeviceByIdx($this->getSetPointIdx())->getSetPoint();
    }

    /**
     * @param float $temperature
     * @return bool
     */
    public function setHeatingTemperature(float $temperature) {
        $controller = (new ControllerFactory($this->getDeviceByIdx($this->getSetPointIdx())))->get();
        if ($controller->set($temperature)) {
            return true;
        }
        return false;
    }

    /**
     * @return int
     */
    protected function getEcoIdx() {
        try {
            if (is_null($this->ecoIdx)) {
                throw new \Exception('ECO IDX for Nest not set.');
            }

            return $this->ecoIdx;
        }
        catch(\Exception $e) {
            trigger_error($e->getMessage(), E_USER_WARNING);
        }
    }

}