<?php
/**
 * Created by PhpStorm.
 * User: etienne
 * Date: 08/10/15
 * Time: 21:58
 */

namespace Enneite\SalesforceRestClient\Oauth\Password;


class Session
{

    /**
     * session id
     *
     * @var string
     */
    protected $id;

    /**
     * session date issue
     *
     * @var string
     */
    protected $issueAt;

    /**
     * token type (generaly: "Bearer")
     *
     * @var string
     */
    protected $tokenType;

    /**
     * signature
     *
     * @var string
     */
    protected $signature;


    /**
     * url to use for the API request
     * @var
     */
    protected $instanceUrl;

    /**
     * access token needeed in the Authorization htp header
     *
     * @var string
     */
    protected $accessToken;

    /**
     * id getter
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * id setter
     *
     * @param string $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * issuedAt getter
     *
     * @return string
     */
    public function getIssueAt()
    {
        return $this->issueAt;
    }

    /**
     * issuedAt setter
     * @param string $issueAt
     * @return $this
     */
    public function setIssueAt($issueAt)
    {
        $this->issueAt = $issueAt;

        return $this;
    }

    /**
     * token type getter
     *
     * @return string
     */
    public function getTokenType()
    {
        return $this->tokenType;
    }

    /**
     * token type setter
     *
     * @param string $tokenType
     * @return $this
     */
    public function setTokenType($tokenType)
    {
        $this->tokenType = $tokenType;

        return $this;
    }

    /**
     * signature getter
     *
     * @return string
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * signature setter
     *
     * @param string $signature
     * @return $this
     */
    public function setSignature($signature)
    {
        $this->signature = $signature;

        return $this;
    }

    /**
     * instance url getter
     *
     * @return mixed
     */
    public function getInstanceUrl()
    {
        return $this->instanceUrl;
    }

    /**
     * instance url setter
     *
     * @param mixed $instanceUrl
     * @return $this
     */
    public function setInstanceUrl($instanceUrl)
    {
        $this->instanceUrl = $instanceUrl;

        return $this;
    }



    /**
     * access token getter
     *
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * access token setter
     *
     * @param string $accessToken
     * return $this
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * @return array
     */
    public function generatehttpHeaders()
    {
        return array(
            'Content-type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => $this->getTokenType(). ' ' . $this->getAccessToken()
        );
    }




}