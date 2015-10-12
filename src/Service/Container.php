<?php
namespace Enneite\SalesforceRestClient\Service;

class Container
{

    protected $httpClient;

    protected $authenticator;

    protected $cache;

    protected $soql;

    protected $sobject;

    /**
     * @param $options
     *
     * option is an array like this
     *
     * array(
        "authenticator" => array(
                                    "uri"=>           'https://test.salesforce.com/services/oauth2/token'
                                    "grant_type"=>      'password'
                                    "client_secret"=>  '123456789101112'
                                    "client_id"=>      'AZERTYGHJKLMWXCVBN123456789azertyuiopqsdfghjklmwxcvbn'
                                    "username"=>      'myaccount@mydomain.com'
                                    "password"=>       'pA$sw0rD'
                                    "security_token"=>  'A1Z2E3R4T5'
                                 ),
        "cache" => array(
                          "type" => "apc",
                          "ttl"=> 3600,
                         ),
        "client" => array(     *
                            "request_uri_prefix" => "services/data/v28.0"
                       )
      )
     *
     * @param $options
     * @throws Exception
     */
    public function __construct($options = array())
    {
        if(!empty($options)) {
            $this->init($options);
        }
    }

    /**
     * @return \Guzzle\Http\Client
     */
    public function getHttpClient()
    {
        return $this->httpClient;
    }

    /**
     * @param \Guzzle\Http\Client $httpClient
     */
    public function setHttpClient($httpClient)
    {
        $this->httpClient = $httpClient;
    }



    /**
     * @return mixed
     */
    public function getAuthenticator()
    {
        return $this->authenticator;
    }

    /**
     * @param \Enneite\SalesforceRestClient\Oauth\AuthenticatorInterface $authenticator
     * @return $this
     */
    public function setAuthenticator(\Enneite\SalesforceRestClient\Oauth\AuthenticatorInterface $authenticator)
    {
        $this->authenticator = $authenticator;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCache()
    {
        return $this->cache;
    }

    /**
     * @param \Desarrolla2\Cache\CacheInterface $cache
     * @return $this
     */
    public function setCache(\Desarrolla2\Cache\CacheInterface $cache)
    {
        $this->cache = $cache;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSoql()
    {
        return $this->soql;
    }

    /**
     * @param \Enneite\SalesforceRestClient\Client\SoqlClient $soql
     * @return $this
     */
    public function setSoql(\Enneite\SalesforceRestClient\Client\SoqlClient $soql)
    {
        $this->soql = $soql;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSobject()
    {
        return $this->sobject;
    }

    /**
     * @param \Enneite\SalesforceRestClient\Client\SobjectClient $sobject
     * @return $this
     */
    public function setSobject(\Enneite\SalesforceRestClient\Client\SobjectClient $sobject)
    {
        $this->sobject = $sobject;

        return $this;
    }


    public function init($options)
    {

        $this->initHttpClient()
             ->initCache($options)
             ->initAuthenticator($options)
             ->initSoql($options)
             ->initSobject($options);

        return $this;
    }

    public function initHttpClient()
    {
        if(null == $this->httpClient) {
            $this->httpClient = new \Guzzle\Http\Client();
        }

        return $this;
    }

    public function initCache($options)
    {
        if(null == $this->cache) {
            if(!array_key_exists('cache', $options)) {
                throw new \Exception('cache options are undefined');
            }

            $cacheType = array_key_exists("type", $options["cache"]) ? $options["cache"]["type"]: "apc";

            switch($cacheType) {
                case "apc" :
                    if(!function_exists('apc_fetch')) {
                        throw new \Exception('APC module not installed');
                    }
                    $adapter = new \Desarrolla2\Cache\Adapter\Apc();
                    break;
                case "file" :
                    $adapter = new \Desarrolla2\Cache\Adapter\File();
                    break;
                case "memcache" :
                    $adapter = new \Desarrolla2\Cache\Adapter\Memcache();
                    break;
                case "memcached" :
                    $adapter = new \Desarrolla2\Cache\Adapter\Memcached();
                    break;
                case "memory" :
                    $adapter = new \Desarrolla2\Cache\Adapter\Memory();
                    break;
                case "mongo" :
                    $adapter = new Desarrolla2\Cache\Adapter\Mongo();
                    break;
                case "mysql" :
                    $adapter = new Desarrolla2\Cache\Adapter\MySQL();
                    break;
                case "redis" :
                    $adapter = new \Desarrolla2\Cache\Adapter\Redis();
                    break;
                default:
                    throw new \Exception(sprintf('cachet type %s not supported!', $cacheType));
            }

            $cacheOptions = $options['cache'];
            unset($cacheOptions['type']);
            foreach($cacheOptions as $key => $option) {
                $adapter->setOption($key, $option);
            }

            $this->cache = new \Desarrolla2\Cache\Cache($adapter);
        }

        return $this;
    }

    public function initAuthenticator($options)
    {
        if(null == $this->authenticator) {

            $grantType = array_key_exists("grant_type", $options["authenticator"]) ? $options["authenticator"]["grant_type"] : "password";

            switch ($grantType) {
                case "password" :
                    $this->authenticator = new \Enneite\SalesforceRestClient\Oauth\Password\Authenticator($this->httpClient, $options["authenticator"]);
                    break;
                default:
                    throw new \Exception(sprintf('authenticator grant type %s not supported!', $grantType));

            }
        }

        return $this;
    }

    public function initSoql($options)
    {
        if(null == $this->soql) {
            $this->soql = new \Enneite\SalesforceRestClient\Client\SoqlClient($this->httpClient, $this->cache, $this->authenticator, $options['client']);
        }

        return $this;
    }

    public function initSobject($options)
    {
        if(null == $this->sobject) {
            $this->sobject = new \Enneite\SalesforceRestClient\Client\SobjectClient($this->httpClient, $this->cache, $this->authenticator, $options['client']);
        }

        return $this;
    }

}