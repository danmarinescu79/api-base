<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2018-03-14 16:14:03
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2018-04-11 13:30:04
 */

namespace ApiBase\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use OAuth2\Storage\UserCredentialsInterface;
use Zend\Mvc\Controller\Plugin\Params;
use Zend\Paginator\Paginator;

class OAuthUserRepository extends EntityRepository implements UserCredentialsInterface
{
    public function getPaginated(Params $params)
    {
        $page         = $params->fromQuery('page', 1);
        $perPage      = $params->fromQuery('perPage', 20);
        $queryBuilder = $this->createQueryBuilder('user');
        $paginator    = new Paginator(new DoctrinePaginator(new ORMPaginator($queryBuilder->getQuery())));
        
        return $paginator->setCurrentPageNumber($page)->setItemCountPerPage($perPage);
    }

    public function checkUserCredentials($email, $password)
    {
        $user = $this->findOneBy(['email' => $email]);
        if ($user) {
            return $user->verifyPassword($password);
        }
        return false;
    }

    /**
     * @return
     * ARRAY the associated "user_id" and optional "scope" values
     * This function MUST return FALSE if the requested user does not exist or is
     * invalid. "scope" is a space-separated list of restricted scopes.
     * @code
     * return array(
     *     "user_id"  => USER_ID,    // REQUIRED user_id to be stored with the authorization code or access token
     *     "scope"    => SCOPE       // OPTIONAL space-separated list of restricted scopes
     * );
     * @endcode
     */
    public function getUserDetails($email)
    {
        $user = $this->findOneBy(['email' => $email]);
        if ($user) {
            $user = $user->toArray();
        }
        return $user;
    }
}
