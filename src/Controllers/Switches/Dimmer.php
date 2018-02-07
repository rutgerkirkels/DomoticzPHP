<?php

namespace rutgerkirkels\DomoticzPHP\Controllers\Switches;

use rutgerkirkels\DomoticzPHP\Controllers\AbstractController;

/**
 * Class Dimmer
 * @package rutgerkirkels\DomoticzPHP\Controllers\Switches
 */
class Dimmer extends AbstractController
{
    /**
     * @var \rutgerkirkels\DomoticzPHP\Devices\Switches\Dimmer
     */
    protected $device;

    protected $connector;

    public function __construct(\rutgerkirkels\DomoticzPHP\Devices\Switches\Dimmer $device)
    {
        parent::__construct($device);
    }

    /**
     * @return bool
     */
    public function switchOn()
    {
        try{
            $turnedOn = $this->connector->executeCommand([
                'param' => 'switchlight',
                'idx' => $this->device->getIdx(),
                'switchcmd' => 'On'
            ]);

            if ($turnedOn) {
                return true;
            }
        } catch (\Exception $exception)
        {
            //TODO log error
        }

        return false;
    }

    /**
     * @return bool
     */
    public function switchOff()
    {
        $turnedOff = $this->connector->executeCommand([
            'param' => 'switchlight',
            'idx' => $this->device->getIdx(),
            'switchcmd' => 'Off'
        ]);

        if ($turnedOff) {
            return true;
        }
        return false;
    }

    /**
     * @param int $level
     * @return bool
     */
    public function setLevel(int $level) {
        $levelSet = $this->connector->executeCommand([
            'param' => 'switchlight',
            'idx' => $this->device->getIdx(),
            'switchcmd' => 'Set Level',
            'level' => $level
        ]);

        if ($levelSet) {
            return true;
        }
        return false;
    }
}