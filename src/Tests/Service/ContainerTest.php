<?php
namespace Enneite\SalesforceRestClient\Tests\Service;


use Enneite\SalesforceRestClient\Oauth\Password\Session;
use Enneite\SalesforceRestClient\Service\Container;
use Guzzle\Http\Message\Response;

class ContainerTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $options = array(
            "authenticator" => array(
                "uri"=> 'https://test.salesforce.com/services/oauth2/token',
                "grant_type"=>      'password',
                "client_secret"=>  '123456789101112',
                "client_id"=>      'AZERTYGHJKLMWXCVBN123456789azertyuiopqsdfghjklmwxcvbn',
                "username"=>      'myaccount@mydomain.com',
                "password"=>       'pA$sw0rD',
                "security_token"=>  'A1Z2E3R4T5',
            ),
            "cache" => array(
                "type" => "apc",
                "ttl"=> 3600,
            ),
            "client" => array(
                "request_uri_prefix" => "services/data/v28.0"
            )
        );
        $httpClient = $this->getMockBuilder('Guzzle\Http\Client')->disableOriginalConstructor()->getMock();

        $json = '{
            "id": "https://test.salesforce.com/id/00Dm00000000xKLEAY/005m0000000FxNEAA0",
            "issued_at": "1409901401745",
            "token_type": "Bearer",
            "instance_url": "https://cs20.salesforce.com",
            "signature": "nPSDSk15ENoysTjMt7wykdKdtepY45kBplv6qIk81po=",
            "access_token": "00Dm00000000xKL!AQ4AQF2Ug5aZNsZSoa1R_W74spuJ2aHmTBuakn5SxJYF1.zwC68cLPg718jyjWOuJ0eC4yTYP9PEYyDIGVEpXZJhYhaHA_5b"
        }';


        $responseHeaders = array(
            'Content-Type' => 'application/json;charset=UTF-8',
            'Date'         =>  'Tue, 03 Jun 2014 13:46:30 GMT',
            'Server'       =>  'Apache-Coyote/1.1',
            'Transfer-Encoding' => 'chunked',
        );


        $response = new Response(200, $responseHeaders, $json);
        $httpClient->expects($this->any())
            ->method('send')
            ->will($this->returnValue($response));

        $cache = $this->getMockBuilder('Desarrolla2\Cache\Cache')->disableOriginalConstructor()->getMock();
        $cache->expects($this->any())
            ->method('set')
            ->will($this->returnValue(true));
        $cache->expects($this->any())
            ->method('has')
            ->will($this->returnValue(true));

        $session = new Session();
        $session->setId("https://test.salesforce.com/id/00Dm00000000xKLEAY/005m0000000FxNEAA0")
            ->setIssueAt("1409901401745")
            ->setTokenType("Bearer")
            ->setInstanceUrl("https://cs20.salesforce.com")
            ->setSignature("nPSDSk15ENoysTjMt7wykdKdtepY45kBplv6qIk81po=")
            ->setAccessToken("00Dm00000000xKL!AQ4AQF2Ug5aZNsZSoa1R_W74spuJ2aHmTBuakn5SxJYF1.zwC68cLPg718jyjWOuJ0eC4yTYP9PEYyDIGVEpXZJhYhaHA_5b");

        $cache->expects($this->any())
            ->method('get')
            ->will($this->returnValue(serialize($session)));

        $this->httpClient = $httpClient;
        $this->cache = $cache;
        $this->options = $options;

    }

    public function testConstructorPasswordApc()
    {
        $container = new Container();
        $container->setHttpClient($this->httpClient);
        $container->setCache($this->cache);

        $container->init($this->options);

        $this->assertInstanceOf('Enneite\SalesforceRestClient\Oauth\Password\Authenticator', $container->getAuthenticator());
        $this->assertInstanceOf('Desarrolla2\Cache\Cache', $container->getCache());
        $this->assertInstanceOf('Enneite\SalesforceRestClient\Client\SoqlClient', $container->getSoql());
        $this->assertInstanceOf('Enneite\SalesforceRestClient\Client\SobjectClient', $container->getSobject());
    }


}