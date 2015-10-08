<?php

namespace Enneite\SalesforceRestClient\Client;


use Enneite\SalesforceRestClient\Model\Collection;
use Enneite\SalesforceRestClient\Oauth\SessionInterface;
use Guzzle\Http\Client;
use \Guzzle\Http\Exception\ClientErrorResponseException;


class SoqlClient extends AbstractClient
{

    /**
     * send soql query to salesforce rest api
     *
     * @param $soql
     *
     * @return Collection
     */
    public function query($soql)
    {
        $request =  $this->httpClient->get(
            $this->session->getInstanceUrl() . '/' . $this->requestUriPrefix . '/query' .urlencode($soql),
            $this->session->generatehttpHeaders()
        );


        $response = $this->httpClient->send($request);
        $json = $response->json();

        return $this->collectionFactory($json);
    }

    /**
     * send soql query to salesforce rest api with reconnection if the session has expired
     *
     * @param $soql
     * @return Collection
     * @throws ClientErrorResponseException
     * @throws \Exception
     */
    public function queryR($soql)
    {
        try {
            return $this->query($soql);
        }
        catch(ClientErrorResponseException $e) {
            if(403 == $e->getResponse()->getStatusCode()) {
                $this->session = $this->authenticator->connect();
                return $this->query($soql);
            }
            throw $e;
        }
    }


    /**
     *build collection with json object
     *
     * @param $json
     * @return Collection
     */
    public function collectionFactory($json) {
        $collection = new Collection();
        $collection->setRecords($json['records'])
            ->setDone($json['done'])
            ->setTotalSize($jon['totalSize']);

        return $collection;
    }


}