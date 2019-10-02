<?php

namespace ApiBase\Factory;

class DoctrineCache
{
    public function __construct()
    {
        $cache    = new \Doctrine\Common\Cache\MemcachedCache();
        $memcache = new \Memcached();
        $memcache->addServer('localhost', 11211);
        $cache->setMemcached($memcache);
        return $memcache;
    }
}
