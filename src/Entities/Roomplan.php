<?php

namespace rutgerkirkels\DomoticzPHP\Entities;


class Roomplan
{
    /**
     * @var array
     */
    protected $rooms;

    public function addRoom(Room $room)
    {
        $this->rooms[] = $room;
    }

    public function getRoom(string $name) {
        foreach($this->rooms as $room) {
            if ($room->getName() === $name) {
                return $room;
            }
        }

        return false;
    }
}