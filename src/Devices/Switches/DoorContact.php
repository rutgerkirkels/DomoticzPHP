<?php

namespace rutgerkirkels\DomoticzPHP\Devices\Switches;

/**
 * Class DoorContact
 * @package rutgerkirkels\DomoticzPHP\Devices\Switches
 */
class DoorContact extends AbstractSwitch
{
    public function getBatteryLevel() {
        return $this->batteryLevel;
    }

    /**
     * @return bool Returns TRUE if the contact is closed.
     */
    public function isClosed() {
        if ($this->getStatus() === 'Closed') {
            return true;
        }
        return false;
    }

    /**
     * @return bool Returns TRUE if the contact is open.
     */
    public function isOpen() {
        if ($this->getStatus() == 'Open') {
            return true;
        }
        return false;
    }
}