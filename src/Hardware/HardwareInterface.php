<?php

namespace rutgerkirkels\DomoticzPHP\Hardware;


interface HardwareInterface
{

    public function getId();

    public function setId(int $id);

    public function getName();

    public function setName(string $name);

    public function getType();

    public function setType(string $type);

    public function getDevices();

    public function setDevices(array $devices);
}