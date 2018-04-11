<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2018-04-03 14:01:17
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2018-04-11 13:25:03
 */

namespace ApiBase\Mapper;

use Doctrine\Common\Persistence\ObjectManager;
use Zend\Hydrator\ClassMethods;
use Zend\Paginator\Paginator;

class ToJson
{
    private $result;
    private $pagination;
    private $objectManager;
    private $mapperClass;
    private $hydrator;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
        $this->hydrator      = new ClassMethods(true);
    }

    public function map($data, $mapperClass)
    {
        $this->mapperClass = $mapperClass;
        
        if ($data instanceof Paginator) {
            $this->pagination($data);
        } else {
            $this->mapData($data);
        }

        $jsonData = [
            'result' => $this->result
        ];

        if (!empty($this->pagination)) {
            $jsonData['pagination'] = $this->pagination;
        }

        return $jsonData;
    }

    private function pagination($paginator)
    {
        $data             = $this->hydrator->hydrate((array) $paginator->getPages(), new Pagination);
        $this->pagination = $this->hydrator->extract($data);
        $this->mapData($paginator->getCurrentItems());
    }

    private function mapData($data)
    {
        $mapper = new $this->mapperClass($this->objectManager);
        if ($data instanceof \ArrayIterator) {
            foreach ($data as $result) {
                $this->result[] = $mapper->hydrate($result)->extract();
            }
        } else {
            $this->result = $mapper->hydrate($data)->extract();
        }
    }
}
