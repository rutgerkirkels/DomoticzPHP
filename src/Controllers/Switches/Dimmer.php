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
     * @return int Current level in percentages.
     */
    public function getLevel() {
        preg_match_all('/\d./', $this->device->getStatus(), $values, PREG_SET_ORDER, 0);
        return intval($values[0][0]);
    }

}