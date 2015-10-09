<?php
/**
 * Created by PhpStorm.
 * User: etienne
 * Date: 08/10/15
 * Time: 23:06
 */

namespace Enneite\SalesforceRestClient\Client;


use Desarrolla2\Cache\Adapter\AdapterInterface;
use Enneite\SalesforceRestClient\Oauth\AuthenticatorInterface;

abstract class AbstractClient
{
    const ACCESS_TOKEN_CACHE_KEY_NAMESPACE = 'enneite/salesforce-rest-client/';
    const ACCESS_TOKEN_CACHE_KEY = 'access-token';

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
     * @var string
     */
    protected $accessTokenCacheKey;

    /**
     * @param $httpClient
     * @param $session
     * @param $parameters
     */
    public function __construct($httpClient, AdapterInterface $cache, AuthenticatorInterface $authenticator , array $parameters)
    {
        $this->httpClient = $httpClient;
        $this->cache = $cache;
        $this->authenticator = $authenticator;
        $this->requestUriPrefix = $parameters['request_uri_prefix'];
        $this->accessTokenCacheKey = self::ACCESS_TOKEN_CACHE_KEY_NAMESPACE . self::ACCESS_TOKEN_CACHE_KEY;

        $this->initSession();
    }

    protected function initSession()
    {
        if(!$this->cache->has($this->accessTokenCacheKey))
        {
            $this->reinitSession();
        }
        else {
            $this->session = unserialize($this->cache->get($this->accessTokenCacheKey));
        }

        return $this;
    }


    protected function reinitSession()
    {
        $this->session = $this->authenticator->connect();
        $this->cache->set($this->accessTokenCacheKey, serialize($this->session));

        return $this;
    }


}