<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2018-04-03 13:39:52
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2018-05-23 12:22:58
 */

namespace ApiBase;

use Zend\EventManager\EventInterface as MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $event)
    {
        $application           = $event->getApplication();
        $container             = $application->getServiceManager();
        $doctrineEntityManager = $container->get('doctrine.entitymanager.orm_default');
        $doctrineEventManager  = $doctrineEntityManager->getEventManager();
        $doctrineEventManager->addEventListener(
            [
                \Doctrine\ORM\Events::prePersist,
                \Doctrine\ORM\Events::preUpdate,
            ],
            new \ApiBase\Listener\ActionListener($doctrineEntityManager, $container)
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }
}
