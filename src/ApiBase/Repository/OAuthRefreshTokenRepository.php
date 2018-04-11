<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2018-03-14 16:24:19
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2018-04-03 13:45:38
 */

namespace ApiBase\Repository;

use ApiBase\Entity\OAuthRefreshToken;
use Doctrine\ORM\EntityRepository;
use OAuth2\Storage\RefreshTokenInterface;

class OAuthRefreshTokenRepository extends EntityRepository implements RefreshTokenInterface
{
    public function getRefreshToken($refreshToken)
    {
        $refreshToken = $this->findOneBy(['refresh_token' => $refreshToken]);
        if ($refreshToken) {
            $refreshToken            = $refreshToken->toArray();
            $refreshToken['expires'] = $refreshToken['expires']->getTimestamp();
        }
        return $refreshToken;
    }

    public function setRefreshToken($refreshToken, $clientIdentifier, $userId, $expires, $scope = null)
    {
        $client = $this->_em->getRepository('ApiBase\Entity\OAuthClient')
                            ->findOneBy(['client_identifier' => $clientIdentifier]);
        $user = $this->_em->getRepository('ApiBase\Entity\OAuthUser')
                            ->findOneBy(['id' => $userId]);
        // print_r($refreshToken);
        // die;
        $refreshToken = OAuthRefreshToken::fromArray([
           'refresh_token' => $refreshToken,
           'client'        => $client,
           'user'          => $user,
           'expires'       => (new \DateTime())->setTimestamp($expires),
           'scope'         => $scope,
        ]);
        $this->_em->persist($refreshToken);
        $this->_em->flush();
    }

    public function unsetRefreshToken($refreshToken)
    {
        $token = $this->findOneBy(['refresh_token' => $refreshToken]);
        if (!$token) {
            return false;
        }
        $this->_em->remove($token);
        $this->_em->flush();
        return true;
    }
}
