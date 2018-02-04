<?php

namespace rutgerkirkels\DomoticzPHP\Entities;

/**
 * Class SunRiseSet
 * @package rutgerkirkels\DomoticzPHP\Entities
 * @author Rutger Kirkels <rutger@kirkels.nl>
 */
class SunRiseSet
{
    /**
     * @var \DateTime
     */
    protected $serverTime;

    /**
     * @var \DateTime
     */
    protected $sunRise;

    /**
     * @var \DateTime
     */
    protected $sunSet;

    protected $dayLength;

    /**
     * SunRiseSet constructor.
     * @param object $data
     */
    public function __construct(object $data)
    {
        $this->serverTime = new \DateTime($data->ServerTime);
        $this->sunRise = new \DateTime($data->Sunrise);
        $this->sunSet = new \DateTime($data->Sunset);
    }

    /**
     * @return \DateTime
     */
    public function getServerTime(): \DateTime
    {
        return $this->serverTime;
    }

    /**
     * @return \DateTime
     */
    public function getSunRise(): \DateTime
    {
        return $this->sunRise;
    }

    /**
     * @return \DateTime
     */
    public function getSunSet(): \DateTime
    {
        return $this->sunSet;
    }


}