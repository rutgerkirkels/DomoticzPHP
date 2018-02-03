<?php
/**
 * Created by PhpStorm.
 * User: rutgerkirkels
 * Date: 03-02-18
 * Time: 10:37
 */

namespace rutgerkirkels\DomoticzPHP\Controllers;


use rutgerkirkels\DomoticzPHP\Devices\AbstractDevice;

abstract class AbstractController implements ControllerInterface
{
    protected $device;

    public function __construct(AbstractDevice $device)
    {
        $this->device = $device;
    }

    public function getStatus() {
        return $this->device->getStatus();
    }

    public function getLastUpdate() {
        return $this->device->getLastUpdate();
    }
}