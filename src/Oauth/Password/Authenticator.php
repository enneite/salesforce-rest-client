<?php

namespace Enneite\SalesforceRestClient\Oauth\Password;

use Enneite\SalesforceRestClient\Oauth\AuthenticatorInterface;
use Guzzle\Http\Message\Response;
use Guzzle\Http\Client;

/**
 * Outh (type password) authenticator
 *
 * Class Authenticator
 * @package Enneite\SalesforceRestClient\Oauth\Password
 */
class Authenticator implements AuthenticatorInterface
{
    /**
     * guzzle http client
     *
     * @var
     */
    private $httpClient; // guzzle

    /**
     * connecton parameters for oauth type password
     *
     * keys are :
     *  uri:            'https://login.salesforce.com/services/oauth2/token'
     *  client_secret: '123456789101112' // available in salesforce.com admin interface
     *  client_id:     'ABCDEFGHIJKLMNOPabcdefghijklmnop12345' // available in salesforce.com admin interface
     *  username:      'admin@mydomain.com' // your account
     *  password:      'abcd123'            // your password
     *  security_token: 'ABCDEFGHIJKL'  // this security token is send by email (no available in the interface)
     *
     * @var array
     */
    private $parameters; // array

    /**
     * constructor
     *
     * @param $httpClient
     * @param $parameters
     */
    public function __construct($httpClient, $parameters) {
        $this->httpClient = $httpClient;
        $this->parameters = $parameters;
    }

    /**
     * connect to the salesforce api provider
     *
     * @return Session
     */
    public function connect()
    {
        $request = $this->httpClient->post(
            $this->buildUrl(),
            array(
                'Content-type' => 'application/json',
                'Accept' => 'application/json'
            ),
            array()
        );

        $response = $this->httpClient->send($request);
        $json = $response->json();

        return $this->sessionFactory($json);

    }

    /**
     * build the authentication url
     *
     * @return string
     */
    public function buildUrl()
    {
        $parameters = $this->parameters;
        $parameters['password'] .= $parameters['security_token'];
        unset($parameters['security_token']);
        unset($parameters['uri']);

        $query = http_build_query($parameters);

        return $this->parameters['uri'].'?' . $query;
    }

    /**
     * build session object
     *
     * @param $json
     * @return Session
     */
    public function sessionFactory($json) {

        $session = new Session();
        $session->setId($json['id'])
            ->setIssueAt($json['issued_at'])
            ->setSignature($json['signature'])
            ->setTokenType($json['token_type'])
            ->setInstanceUrl($json['instance_url'])
            ->setAccessToken($json['access_token']);

        return $session;
    }


}