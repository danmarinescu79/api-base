<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2018-04-10 13:46:41
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2018-04-11 13:16:12
 */

namespace ApiBase\Mapper;

use Doctrine\Common\Persistence\ObjectManager;

interface MapperJsonInterface
{
    public function __construct(ObjectManager $objectManager);
    
    public function hydrate(object $data);

    public function extract() : array;
}
