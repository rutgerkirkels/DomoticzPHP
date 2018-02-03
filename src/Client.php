<?php

namespace rutgerkirkels\DomoticzPHP;

class Client
{
    private $hostname = null;
    private static $username = null;
    private static $password = null;
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

    public function __construct($hostname = null, $username = null, $password = null)
    {
        $this->hostname = $hostname;

        if (!empty($username)) {
            self::$username = $username;
        }

        if (!empty($password)) {
            self::$password = $password;
        }

        $this->api = new \GuzzleHttp\Client([
            'base_uri' => $hostname . '/'
        ]);

        $connector = Connector::init($this->hostname, self::$username, self::$password);
//        $connector->setUserAgent('Domoticz PHP v' . self::$version['major'] . '.' . self::$version['minor'] . ' (' . php_uname('s') . '-' . php_uname('r') . '; PHP-' . PHP_VERSION . '; ' . PHP_SAPI . ') ');
    }

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

            default:

        }
    }

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


            switch ($receivedDevice->Type) {

                case 'Light/Switch':
                    $devices[] = $this->getLightSwitch($receivedDevice)->get();
                    break;

                default:

            }
        }
        return $devices;
    }

    public function executeCommand(array $parameters) {
        $this->query = [
            'type' => 'command'
        ];
        array_merge($this->query, $parameters);

    }

    protected function getLightSwitch($deviceData) {
        return new Factories\LightSwitchFactory($deviceData);
    }
}