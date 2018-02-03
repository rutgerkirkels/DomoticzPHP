<?php

namespace rutgerkirkels\DomoticzPHP\Devices\Switches;

/**
 * Class Dimmer
 * @package rutgerkirkels\DomoticzPHP\Devices\Switches
 */
class Dimmer extends AbstractSwitch
{
    /**
     * @return int Current level in percentages.
     */
    public function getLevel() {
        if ($this->getStatus() !== 'Off') {
            preg_match_all('/\d./', $this->getStatus(), $values, PREG_SET_ORDER, 0);
            return intval($values[0][0]);
        }
        return 0;
    }
}