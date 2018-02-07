<?php
namespace rutgerkirkels\DomoticzPHP;

use GuzzleHttp\Exception\ClientException;
use rutgerkirkels\DomoticzPHP\Factories\HardwareFactory;
use rutgerkirkels\DomoticzPHP\Factories\Lighting2Factory;
use rutgerkirkels\DomoticzPHP\Factories\TempAndHumidityFactory;
use rutgerkirkels\DomoticzPHP\Factories\ThermostatFactory;
use rutgerkirkels\DomoticzPHP\Factories\UsageFactory;

/**
 * Class Connector
 * @package rutgerkirkels\DomoticzPHP
 *
 * @author Rutger Kirkels <rutger@kirkels.nl>
 */
class Connector
{
    /**
     * @var string
     */
    protected $host;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var \GuzzleHttp\Client
     */
    protected $api;

    /**
     * @var string
     */
    protected $lastError;

    /**
     * @var array
     */
    protected $query;

    private static $instance = null;

    public static function init(string $host = null, string $username = null, string $password = null) {
        if (self::$instance === null) {
            self::$instance = new Connector($host, $username, $password);
        }
        return self::$instance;
    }

    public static function getInstance() {
        return self::$instance;
    }

    /**
     * Connector constructor.
     * @param string $host
     * @param string|null $username
     * @param string|null $password
     */
    public function __construct(string $host, string $username = null, string $password = null)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;

        if (!is_null($this->username) && !is_null($this->password)) {
            $this->api = new \GuzzleHttp\Client([
                'base_uri' => $host . '/',
                'auth' => [$this->username, $this->password]
            ]);
        }
        else {
            $this->api = new \GuzzleHttp\Client([
                'base_uri' => $host . '/'
            ]);
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
                    $devices[] = (new Factories\LightSwitchFactory($receivedDevice))->get();
                    break;

                case 'Lighting 2':
                    $devices[] = (new Lighting2Factory($receivedDevice))->get();
                    break;

                case 'Temp + Humidity':
                    $devices[] = (new TempAndHumidityFactory($receivedDevice))->get();
                    break;

                case 'Thermostat':
                    $devices[] = (new ThermostatFactory($receivedDevice))->get();
                    break;

                case 'Usage':
                    $devices[] = (new UsageFactory($receivedDevice))->get();
                    break;

                default:
                    $devices[] = null;
            }
        }
        return $devices;
    }


    public function executeCommand(array $parameters) {
        try {
            $this->query = [
                'type' => 'command'
            ];
            $response = json_decode((string) $this->api->request('GET', 'json.htm', [
                'query' => array_merge($this->query, $parameters)
            ])->getBody());

            if ($response->status === 'OK') {
                return $response;
            }
            elseif ($response->status === 'ERROR') {
                throw new \Exception('Unable to execute command: ' . $response->message);
                $this->lastError = $response->message;
            }
        }
        catch (ClientException $exception) {
            switch ($exception->getCode()) {

                case 401:
                    return false;
                    break;
            }
        }
        catch (\Exception $exception) {
            trigger_error($exception->getMessage(), E_USER_WARNING);
        }

        return false;
    }


}