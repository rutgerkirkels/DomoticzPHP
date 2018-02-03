<?php

namespace rutgerkirkels\DomoticzPHP\Controllers;

use rutgerkirkels\DomoticzPHP\Connector;
use rutgerkirkels\DomoticzPHP\Devices\AbstractDevice;

/**
 * Class AbstractController
 * @package rutgerkirkels\DomoticzPHP\Controllers
 */
abstract class AbstractController implements ControllerInterface
{
    protected $device;

    public function __construct(AbstractDevice $device)
    {
        $this->device = $device;
        $this->connector = Connector::getInstance();
    }

    /**
     * @return string
     */
    public function getStatus() {
        return $this->device->getStatus();
    }

    /**
     * @return \DateTime
     */
    public function getLastUpdate() {
        return $this->device->getLastUpdate();
    }
}