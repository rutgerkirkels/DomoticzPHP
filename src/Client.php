<?php

namespace rutgerkirkels\DomoticzPHP;

use rutgerkirkels\DomoticzPHP\Devices\AbstractDevice;
use rutgerkirkels\DomoticzPHP\Entities\SunRiseSet;
use rutgerkirkels\DomoticzPHP\Factories\Lighting2Factory;
use rutgerkirkels\DomoticzPHP\Factories\TempAndHumidityFactory;
use rutgerkirkels\DomoticzPHP\Factories\ThermostatFactory;
use rutgerkirkels\DomoticzPHP\Factories\UsageFactory;

/**
 * Class Client
 * @package rutgerkirkels\DomoticzPHP
 * @author Rutger Kirkels <rutger@kirkels.nl>
 */
class Client
{
    /**
     * @var string
     */
    protected $host;

    /**
     * @var string
     */
    private static $username;

    /**
     * @var string
     */
    private static $password;

    private static $version = [
        'major'     => '1',
        'minor'     => '0',
        'revision'  => '0',
        'patch'     => '0',
        'stability' => '',
        'number'    => '',
    ];

    protected $api;
    protected $query;

    public static function singleton() {
        if (null === self::$getSingleton) {
            self::$getSingleton = new self;
        }
    }

    /**
     * Client constructor.
     * @param string|null $host
     * @param string|null $username
     * @param string|null $password
     */
    public function __construct(string $host = null, string $username = null, string $password = null)
    {
        $this->host = $host;

        if (!empty($username)) {
            self::$username = $username;
        }

        if (!empty($password)) {
            self::$password = $password;
        }

        if (!is_null(self::$username) && !is_null(self::$password)) {
            $this->api = new \GuzzleHttp\Client([
                'base_uri' => $host . '/',
                'auth' => [self::$username, self::$password]
            ]);
        }
        else {
            $this->api = new \GuzzleHttp\Client([
                'base_uri' => $host . '/'
            ]);
        }


        $this->connector = Connector::init($this->host, self::$username, self::$password);
//        $connector->setUserAgent('Domoticz PHP v' . self::$version['major'] . '.' . self::$version['minor'] . ' (' . php_uname('s') . '-' . php_uname('r') . '; PHP-' . PHP_VERSION . '; ' . PHP_SAPI . ') ');
    }

    /**
     * @return bool|SunRiseSet Returns SunRiseSet entity or FALSE if unable to get the data from Domoticz.
     */
    public function getSunRiseSet() {
        $retrievedData = $this->connector->executeCommand([
            'param' => 'getSunRiseSet'
        ]);

        if ($retrievedData) {
            return new SunRiseSet($retrievedData);
        }

        return false;
    }

    /**
     * @param int $idx
     * @return AbstractDevice|bool
     */
    public function getDeviceByIdx(int $idx) {
        $this->query = [
            'type' => 'devices',
            'rid' => $idx
        ];
        $response = json_decode((string) $this->api->request('GET', 'json.htm', [
            'query' => $this->query
        ])->getBody());

        if (!property_exists($response, 'result') || count($response->result) !== 1) {
            return false;
        }

        $receivedDevice = $response->result[0];
        switch ($receivedDevice->Type) {

            case 'Light/Switch':
                return $this->getLightSwitch($receivedDevice)->get();
                break;

            case 'Lighting 2':
                return $this->getLighting2($receivedDevice)->get();
                break;

            case 'Temp + Humidity':
                return $this->getTempAndHumidity($receivedDevice)->get();
                break;

            case 'Thermostat':
                return $this->getThermostat($receivedDevice)->get();
                break;

            default:

        }
    }

    /**
     * @param string|null $filter
     * @return array
     */
    public function getDevices(string $filter = null) {
        $this->query = [
            'type' => 'devices',
            'order' => 'Name'
        ];

        if (!is_null($filter)) {
            $this->query['filter'] = $filter;
        }

        $response = (string) $this->api->request('GET', 'json.htm', [
            'query' => $this->query
        ])->getBody();

        $receivedDevices = json_decode($response)->result;

        $devices = [];
        foreach ($receivedDevices as $receivedDevice) {
//var_dump($receivedDevice);
            switch ($receivedDevice->Type) {

                case 'Light/Switch':
                    $devices[] = $this->getLightSwitch($receivedDevice)->get();
                    break;

                case 'Lighting 2':
                    $devices[] = $this->getLighting2($receivedDevice)->get();
                    break;

                case 'Temp + Humidity':
                    $devices[] = $this->getTempAndHumidity($receivedDevice)->get();
                    break;

                case 'Thermostat':
                    $devices[] = $this->getThermostat($receivedDevice)->get();
                    break;

                case 'Usage':
                    $devices[] = $this->getUsage($receivedDevice)->get();
                    break;

                default:
                    $devices[] = $receivedDevice;
            }
        }
        return $devices;
    }

    public function getHardware() {
        $hardware = [];
        $devices = $this->getDevices();
        foreach ($devices as $id =>  $device) {
            var_dump($id, $device->getName(), $device->getHardwareId());
//            $hardware[$device->getHardwareId()] = 'test';
        }
        var_dump($hardware);

    }

    protected function getLightSwitch(object $deviceData) {
        return new Factories\LightSwitchFactory($deviceData);
    }

    protected function getLighting2(object $deviceData) {
        return new Lighting2Factory($deviceData);
    }

    protected function getTempAndHumidity(object $deviceData) {
        return new TempAndHumidityFactory($deviceData);
    }

    protected function getThermostat(object $deviceData) {
        return new ThermostatFactory($deviceData);
    }

    protected function getUsage(object $deviceData) {
        return new UsageFactory($deviceData);
    }
}