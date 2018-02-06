<?php

namespace rutgerkirkels\DomoticzPHP\Factories;


use rutgerkirkels\DomoticzPHP\Hardware\General;

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

            default:
                $hardware = new General($this->id, $this->name, $this->type);
                $hardware->setDevices($this->devices);
        }

        return $hardware;
    }


}