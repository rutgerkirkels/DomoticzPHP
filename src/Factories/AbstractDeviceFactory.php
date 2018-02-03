<?php
/**
 * Created by PhpStorm.
 * User: rutgerkirkels
 * Date: 01-02-18
 * Time: 22:58
 */

namespace rutgerkirkels\DomoticzPHP\Factories;


abstract class AbstractDeviceFactory
{
    public function get() {
        return $this->data;
    }
}