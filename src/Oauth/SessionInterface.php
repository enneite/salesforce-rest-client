<?php
/**
 * Created by PhpStorm.
 * User: etienne
 * Date: 08/10/15
 * Time: 22:50
 */

namespace Enneite\SalesforceRestClient\Oauth;


interface SessionInterface
{
    public function generatehttpHeaders();

    public function getInstanceUrl();
}