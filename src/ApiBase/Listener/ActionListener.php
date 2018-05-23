<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2018-05-23 12:03:57
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2018-05-23 12:21:52
 */

namespace ApiBase\Listener;

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

        $oauth = $this->server->getAccessTokenData(\OAuth2\Request::createFromGlobals());

        if (isset($oauth['user_id']) && method_exists($entity, 'setCreatedBy')) {
            $this->hydrator->hydrate(['createdBy' => $oauth['user_id']], $entity);
        }
    }

    public function preUpdate($eventArgs)
    {
        $entity = $eventArgs->getEntity();

        $oauth = $this->server->getAccessTokenData(\OAuth2\Request::createFromGlobals());

        if (isset($oauth['user_id']) && method_exists($entity, 'setUpdatedBy')) {
            $this->hydrator->hydrate(['updatedBy' => $oauth['user_id']], $entity);
        }
    }
}
