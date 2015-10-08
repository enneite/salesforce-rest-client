<?php
/**
 * Created by PhpStorm.
 * User: etienne
 * Date: 08/10/15
 * Time: 23:06
 */

namespace Enneite\SalesforceRestClient\Client;


use Enneite\SalesforceRestClient\Oauth\AuthenticatorInterface;

abstract class AbstractClient
{
    /**
     * http client (guzzle)
     * @var
     */
    protected $httpClient;


    /**
     * Oauth Api Authentication Session Instance
     * @var
     */
    protected $session;

    /**
     * connector to oauth provider
     *
     * @var AuthenticatorInterface
     */
    protected $authenticator;

    /**
     * @var
     */
    protected $requestUriPrefix;

    /**
     * @param $httpClient
     * @param $session
     * @param $parameters
     */
    public function __construct($httpClient, SessionInterface $session, AuthenticatorInterface $authenticator , array $parameters)
    {
        $this->httpClient = $httpClient;
        $this->session = $session;
        $this->authenticator = $authenticator;
        $this->requestUriPrefix = $parameters['request_uri_prefix'];
    }


}