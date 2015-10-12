<?php
/**
 * Created by PhpStorm.
 * User: etienne
 * Date: 08/10/15
 * Time: 23:03
 */

namespace Enneite\SalesforceRestClient\Client;

/**
 * Class SobjectClient
 * @package Enneite\SalesforceRestClient\Client
 */
class SobjectClient extends AbstractClient
{

    /**
     * create new object
     *
     * @param $sobjectType
     * @param $id
     * @param $data
     */
    public function create($sobjectType, $id, $data)
    {
        $request =  $this->httpClient->post(
            $this->session->getInstanceUrl()  . '/' . $this->requestUriPrefix . '/sobjects/' . $sobjectType . '/' .$id,
            $this->session->generatehttpHeaders(),
            json_encode($data)
        );

        $response = $this->httpClient->send($request);
        $json = $response->json();

        return $json;
    }

    /**
     * create new object and reconnect if disconnected
     *
     * @param $sobjectType
     * @param $id
     * @param $data
     * @throws ClientErrorResponseException
     * @throws \Exception
     */
    public function createR($sobjectType, $id, $data)
    {
        try {
            return $this->create($sobjectType, $id, $data);
        }
        catch(ClientErrorResponseException $e) {
            if(403 == $e->getResponse()->getStatusCode()) {
                $this->reinitSession();

                return $this->create($sobjectType, $id, $data);
            }
            throw $e;
        }
    }

    /**
     * read Object
     *
     * @param $sobjectType
     * @param $id
     */
    public function read($sobjectType, $id)
    {
        $request =  $this->httpClient->get(
            $this->session->getInstanceUrl() . '/' . $this->requestUriPrefix . '/sobjects/' . $sobjectType . '/' .$id,
            $this->session->generatehttpHeaders()
        );


        $response = $this->httpClient->send($request);
        $json = $response->json();

        return $json;
    }

    /**
     * read object and reconnect if disconnected
     *
     * @param $sobjectType
     * @param $id
     * @throws ClientErrorResponseException
     * @throws \Exception
     */
    public function readR($sobjectType, $id)
    {
        try {
            return $this->read($sobjectType, $id);
        }
        catch(ClientErrorResponseException $e) {
            if(403 == $e->getResponse()->getStatusCode()) {
                $this->reinitSession();

                return $this->read($sobjectType, $id);
            }
            throw $e;
        }
    }

    /**
     * update object
     *
     * @param $sobjectType
     * @param $id
     * @param $data
     */
    public function update($sobjectType, $id, $data)
    {
        $request =  $this->httpClient->patch(
            $this->session->getInstanceUrl()  . '/' . $this->requestUriPrefix . '/sobjects/' . $sobjectType . '/' .$id,
            $this->session->generatehttpHeaders(),
            json_encode($data)
        );

        $response = $this->httpClient->send($request);
        $json = $response->json();

        return $json;
    }

    /**
     * update object and reconnect if disconnected
     *
     * @param $sobjectType
     * @param $id
     * @param $data
     * @throws ClientErrorResponseException
     * @throws \Exception
     */
    public function updateR($sobjectType, $id, $data)
    {
        try {
            return $this->update($sobjectType, $id, $data);
        }
        catch(ClientErrorResponseException $e) {
            if(403 == $e->getResponse()->getStatusCode()) {
                $this->reinitSession();

                return $this->update($sobjectType, $id, $data);
            }
            throw $e;
        }
    }

    /**
     * delete object
     *
     * @param $sobjectType
     * @param $id
     */
    public function delete($sobjectType, $id)
    {
        $request =  $this->httpClient->delete(
            $this->session->getInstanceUrl() . '/' . $this->requestUriPrefix . '/sobjects/' . $sobjectType . '/' .$id,
            $this->session->generatehttpHeaders()
        );

        $response = $this->httpClient->send($request);
        $json = $response->json();

        return $json;
    }

    /**
     * delete object and reconnect if disconnected
     *
     * @param $sobjectType
     * @param $id
     * @throws ClientErrorResponseException
     * @throws \Exception
     */
    public function deleteR($sobjectType, $id)
    {
        try {
            return $this->read($sobjectType, $id);
        }
        catch(ClientErrorResponseException $e) {
            if(403 == $e->getResponse()->getStatusCode()) {
                $this->reinitSession();

                return $this->delete($sobjectType, $id);
            }
            throw $e;
        }
    }

}