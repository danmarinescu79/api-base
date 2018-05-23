<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2018-05-23 12:03:57
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2018-05-23 13:19:16
 */

namespace ApiBase\Listener;

use ApiBase\Entity\OAuthAccessToken;
use ApiBase\Entity\OAuthRefreshToken;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\ServiceManager\ServiceManager;

class ActionListener
{
    private $objectManager;
    private $container;
    private $server;
    private $hydrator;
    private $sm;

    public function __construct(ObjectManager $objectManager, ServiceManager $container)
    {
        $this->objectManager = $objectManager;
        $this->hydrator      = new DoctrineObject($objectManager);
        $this->container     = $container;
        
        $this->server = $container->get(\Oauth2Server::class);
    }

    public function prePersist($eventArgs)
    {
        $entity = $eventArgs->getEntity();

        if ($entity instanceof OAuthAccessToken || $entity instanceof OAuthRefreshToken) {
            return;
        }

        $oauth = $this->server->getAccessTokenData(\OAuth2\Request::createFromGlobals());

        if (!empty($oauth) && isset($oauth['user_id']) && method_exists($entity, 'setCreatedBy')) {
            $this->hydrator->hydrate(['createdBy' => $oauth['user_id']], $entity);
        }
    }

    public function preUpdate($eventArgs)
    {
        $entity = $eventArgs->getEntity();

        if ($entity instanceof OAuthAccessToken || $entity instanceof OAuthRefreshToken) {
            return;
        }

        $oauth = $this->server->getAccessTokenData(\OAuth2\Request::createFromGlobals());

        if ($oauth && isset($oauth['user_id']) && method_exists($entity, 'setUpdatedBy')) {
            $this->hydrator->hydrate(['updatedBy' => $oauth['user_id']], $entity);
        }
    }
}
