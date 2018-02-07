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
     * @return array
     */
    public function getMethods() {
        $class = new \ReflectionClass(get_class($this));
        $availableMethods = [];
        foreach ($class->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
            if ($method->name !== '__construct') {
                $availableMethods[] = $method->name;
            }
        }
        return $availableMethods;
    }
}