<?php
/**
 * Timestamp Helper Class
 */
namespace rutgerkirkels\domoticz_php\Helpers;

class Timestamp
{
    public static function toObject($timestamp) {
        $obj = new \DateTime();
        $obj->setTimestamp(strtotime($timestamp));
        return $obj;
    }
}