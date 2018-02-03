<?php

namespace rutgerkirkels\DomoticzPHP\Factories;

/**
 * Class AbstractDeviceFactory
 * @package rutgerkirkels\DomoticzPHP\Factories
 */
abstract class AbstractDeviceFactory
{
    public function get() {
        return $this->data;
    }
}