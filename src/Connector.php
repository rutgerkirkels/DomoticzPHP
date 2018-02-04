<?php
namespace rutgerkirkels\DomoticzPHP;

use GuzzleHttp\Exception\ClientException;

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
        }
        catch (ClientException $exception) {
            switch ($exception->getCode()) {

                case 401:
                    return false;
                    break;
            }
        }

        return false;
    }


}