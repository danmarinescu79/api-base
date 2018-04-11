<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2018-03-14 16:13:37
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2018-04-03 13:45:43
 */

namespace ApiBase\Repository;

use Doctrine\ORM\EntityRepository;
use OAuth2\Storage\ClientCredentialsInterface;

class OAuthClientRepository extends EntityRepository implements ClientCredentialsInterface
{
    public function getClientDetails($clientIdentifier)
    {
        $client = $this->findOneBy(['client_identifier' => $clientIdentifier]);
        
        if ($client) {
            $client = $client->toArray();
        }
        return $client;
    }

    public function checkClientCredentials($clientIdentifier, $clientSecret = null)
    {
        $client = $this->findOneBy(['client_identifier' => $clientIdentifier]);
        
        if ($client) {
            return $client->verifyClientSecret($clientSecret);
        }
        return false;
    }

    public function checkRestrictedGrantType($clientId, $grantType)
    {
        // we do not support different grant types per client in this example
        return true;
    }

    public function isPublicClient($clientId)
    {
        return false;
    }

    public function getClientScope($clientId)
    {
        return null;
    }
}
