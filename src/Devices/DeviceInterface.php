<?php

namespace rutgerkirkels\DomoticzPHP\Devices;

/**
 * Interface DeviceInterface
 * @package rutgerkirkels\DomoticzPHP\Devices
 */
interface DeviceInterface
{
    public function getLastUpdate(): \DateTime;
    public function getStatus(): string;
    public function getIdx(): int;
}