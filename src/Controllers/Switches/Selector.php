<?php

namespace rutgerkirkels\DomoticzPHP\Controllers\Switches;

use rutgerkirkels\DomoticzPHP\Controllers\AbstractController;

/**
 * Class Dimmer
 * @package rutgerkirkels\DomoticzPHP\Controllers\Switches
 */
class Selector extends AbstractController
{
    /**
     * @var \rutgerkirkels\DomoticzPHP\Devices\Switches\Selector
     */
    protected $device;

    protected $connector;

    public function __construct(\rutgerkirkels\DomoticzPHP\Devices\Switches\Selector $device)
    {
        parent::__construct($device);
    }

    /**
     * @param int $level
     * @return bool
     */
    public function setLevel(int $level) {
        $command = [
            'param' => 'switchlight',
            'idx' => $this->device->getIdx(),
            'switchcmd' => rawurlencode('Set Level'),
            'level' => $level
        ];
        $levelChanged = $this->connector->executeCommand($command);

        if ($levelChanged) {
            return true;
        }

        return false;
    }

}