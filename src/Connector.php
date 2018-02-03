<?php
/**
 * Connector Class
 * Provides all connectivity with the Domoticz API
 *
 * @package rutgerkirkels\domoticz_php
 * @author Rutger Kirkels <rutger@kirkels.nl>
 */
namespace rutgerkirkels\DomoticzPHP;


class Connector
{
    protected $host = null;
    protected $username = null;
    protected $password = null;
    protected $api;
    protected $query;

    private static $instance = null;

    public static function init($host = null, $username = null, $password = null) {
        if (self::$instance === null) {
            self::$instance = new Connector($host, $username, $password);
        }
        return self::$instance;
    }

    public static function getInstance() {
        return self::$instance;
    }

    public function __construct(string $host, $username, $password)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;

        $this->api = new \GuzzleHttp\Client([
            'base_uri' => $host . '/'
        ]);
    }

    public function executeCommand(array $parameters) {
        $this->query = [
            'type' => 'command'
        ];
        $response = json_decode((string) $this->api->request('GET', 'json.htm', [
            'query' => array_merge($this->query, $parameters)
        ])->getBody());

        if ($response->status === 'OK') {
            return true;
        }

        return false;
    }


}