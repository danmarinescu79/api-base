<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2018-04-03 13:39:52
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2018-04-03 13:40:52
 */

namespace ApiBase;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }
}
