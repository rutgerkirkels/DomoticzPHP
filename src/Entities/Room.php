<?php

namespace rutgerkirkels\DomoticzPHP\Entities;


use rutgerkirkels\DomoticzPHP\Connector;

class Room
{
    /**
     * @var int
     */
    protected $idx;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $devices;

    /**
     * Room constructor.
     * @param int $idx
     * @param string $name
     */
    public function __construct(int $idx, string $name = '')
    {
        $this->idx = $idx;
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getIdx(): int
    {
        return $this->idx;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getDevices(): array
    {
        if (is_null($this->devices)) {
            $connector = Connector::getInstance();
            $devices = $connector->getDevices();
            $roomDevices = $connector->executeCommand([
                'param' => 'getplandevices',
                'idx' => $this->getIdx()
            ]);

            foreach ($roomDevices->result as $roomDevice) {
                foreach ($devices as $device) {
                    if (!is_null($device)) {
                        if ($device->getIdx() === intval($roomDevice->devidx)) {
                            $this->devices[$roomDevice->idx] = $device;
                        }
                    }

                }

            }
        }

        return $this->devices;
    }


}