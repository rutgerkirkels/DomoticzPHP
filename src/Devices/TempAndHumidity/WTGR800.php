<?php

namespace rutgerkirkels\DomoticzPHP\Devices\TempAndHumidity;

use rutgerkirkels\DomoticzPHP\Devices\AbstractDevice;

/**
 * Class WTGR800
 * @package rutgerkirkels\DomoticzPHP\Devices\TempAndHumidity
 * @author Rutger Kirkels <rutger@kirkels.nl>
 */
class WTGR800 extends AbstractDevice
{
    /**
     * @var array
     */
    protected $temperature;

    /**
     * @var int
     */
    protected $humidity;

    /**
     * WTGR800 constructor.
     * @param object $deviceData
     */
    public function __construct(object $deviceData)
    {
        parent::__construct($deviceData);
        $this->getTemperatureAndHumidity();

    }

    protected function getTemperatureAndHumidity() {
        $parts = explode(',', $this->data);

        $temperatureParts = explode(' ', $parts[0]);

        $this->temperature = [
            'value' => floatval($temperatureParts[0]),
            'unit' => $temperatureParts[1]
        ];

        $humidityParts = explode(' ', trim($parts[1]));

        $this->humidity = intval($humidityParts[0]);
    }

    /**
     * @return array
     */
    public function getTemperature(): array
    {
        return $this->temperature;
    }

    /**
     * @return int
     */
    public function getHumidity(): int
    {
        return $this->humidity;
    }


}