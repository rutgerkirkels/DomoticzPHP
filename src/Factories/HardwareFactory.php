<?php

namespace rutgerkirkels\DomoticzPHP\Factories;


use rutgerkirkels\DomoticzPHP\Hardware\General;
use rutgerkirkels\DomoticzPHP\Hardware\Nest;

/**
 * Class HardwareFactory
 * @package rutgerkirkels\DomoticzPHP\Factories
 */
class HardwareFactory
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $type;
    /**
     * @var array
     */
    protected $devices;

    /**
     * HardwareFactory constructor.
     * @param int $id
     * @param string $name
     * @param string|null $type
     */
    public function __construct(int $id, string $name, string $type = null)
    {
        $this->id = $id;
        $this->name =$name;
        $this->type = $type;
    }

    public function addDevice($device) {
        $this->devices[] = $device;
    }

    public function get() {
        switch ($this->type) {

            case 'Nest Thermostat/Protect':
                $hardware = new Nest($this->id, $this->name, $this->devices, $this->type);
                break;

            default:
                $hardware = new General($this->id, $this->name, $this->devices, $this->type);

        }

        return $hardware;
    }


}