<?php

namespace Holger;

use SoapClient;

class TR064Connection
{

    /**
     * @var string Host address of the router
     */
    protected $host;

    /**
     * @var int port number of the router
     */
    protected $port = 49000;

    /**
     * @var string protocol prefix
     */
    protected $protocol = 'http://';

    /**
     * @var null|string username for connection
     */
    protected $username;

    /**
     * @var string password for connection
     */
    protected $password;

    /**
     * FritzBox constructor.
     * TODO: Handle no username configuration.
     *
     * @param string      $host
     * @param string      $password
     * @param string|null $username
     */
    public function __construct($host, $password, $username = null)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @param object $params
     * @param bool   $noroot
     *
     * @return SoapClient
     */
    public function makeRequest($params = null, $noroot = true)
    {
        return new SoapClient(
            null,
            [
                'location' => $this->makeUri($params['controlUri']),
                'uri' => $params['uri'],
                'noroot' => $noroot,
                'login' => $this->username,
                'password' => $this->password,
            ]
        );
    }

    /**
     * @param string      $uri
     * @param string|null $protocol
     * @param string|null $host
     * @param string|null $port
     *
     * @return string
     */
    public function makeUri($uri, $protocol = null, $host = null, $port = null)
    {
        $protocol = $protocol ?? $this->protocol;
        $host = $host ?? $this->host;
        $port = $port ?? $this->port;

        return $protocol . $host . ':' . $port . $uri;
    }
}
