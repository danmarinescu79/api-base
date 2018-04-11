<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2018-03-14 16:14:29
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2018-04-03 13:45:45
 */

namespace ApiBase\Repository;

use ApiBase\Entity\OAuthAccessToken;
use Doctrine\ORM\EntityRepository;
use OAuth2\Storage\AccessTokenInterface;

class OAuthAccessTokenRepository extends EntityRepository implements AccessTokenInterface
{
    public function getAccessToken($oauthToken)
    {
        $token = $this->findOneBy(['token' => $oauthToken]);
        if ($token) {
            $token            = $token->toArray();
            $token['expires'] = $token['expires']->getTimestamp();
        }
        return $token;
    }

    public function setAccessToken($oauthToken, $clientIdentifier, $userId, $expires, $scope = null)
    {
        $client = $this->_em->getRepository('ApiBase\Entity\OAuthClient')->findOneBy(['client_identifier' => $clientIdentifier]);
        $user   = $this->_em->getRepository('ApiBase\Entity\OAuthUser')->findOneBy(['id' => $userId]);
        $token  = OAuthAccessToken::fromArray([
            'token'   => $oauthToken,
            'client'  => $client,
            'user'    => $user,
            'expires' => (new \DateTime())->setTimestamp($expires),
            'scope'   => $scope,
        ]);
        $this->_em->persist($token);
        $this->_em->flush();
    }

    public function unsetAccessToken($accessToken)
    {
        $token = $this->findOneBy(['token' => $accessToken]);
        if (!$token) {
            return false;
        }
        $this->_em->remove($token);
        $this->_em->flush();
        return true;
    }
}
