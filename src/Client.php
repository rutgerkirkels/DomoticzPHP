<?php

namespace rutgerkirkels\DomoticzPHP;

use rutgerkirkels\DomoticzPHP\Devices\AbstractDevice;
use rutgerkirkels\DomoticzPHP\Entities\Room;
use rutgerkirkels\DomoticzPHP\Entities\Roomplan;
use rutgerkirkels\DomoticzPHP\Entities\SunRiseSet;
use rutgerkirkels\DomoticzPHP\Factories\HardwareFactory;
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
        return $this->connector->getDevices($filter);
    }

    /**
     * @return array
     */
    public function getHardware() {
        $hardware = [];
        $devices = $this->getDevices();
        foreach ($devices as $id =>  $device) {
            if (!is_null($device) && !key_exists($device->getHardwareId(), $hardware)) {
                $hardwareFactory = new HardwareFactory($device->getHardwareId(), $device->getHardwareName(), $device->getHardwareType());
                $hardware[$device->getHardwareId()] = $hardwareFactory ;
            }
        }

        foreach ($devices as $device) {
            if (!is_null($device)) {
                $hardware[$device->getHardwareId()]->addDevice($device);
            }
        }

        $returnData = [];
        foreach ($hardware as $hardwareDevice) {
            $returnData[] = $hardwareDevice->get();
        }
        return $returnData;
    }

    /**
     * @param int $id
     * @return bool|mixed
     */
    public function getHardwareById(int $id)
    {
        foreach ($this->getHardware() as $hardware) {
            if ($hardware->getId() === $id) {
                return $hardware;
            }
        }
        return false;
    }

    /**
     * @param string $orderBy
     * @param bool $used
     * @return Roomplan
     */
    public function getRoomPlan(string $orderBy = 'Name', bool $used = true)
    {
        $this->query = [
            'type' => 'plans',
            'order' => 'Name',
            'used' => $used
        ];

        $response = (string) $this->api->request('GET', 'json.htm', [
            'query' => $this->query
        ])->getBody();

        $rooms = json_decode($response)->result;

        $roomplan = new Roomplan();
        foreach ($rooms as $room) {
            $roomplan->addRoom(new Room($room->idx, $room->Name));
        }
        return $roomplan;
    }
}