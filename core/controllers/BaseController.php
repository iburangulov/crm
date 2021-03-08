<?php

namespace App\controllers;

use App\contracts\ControllerContracts;

abstract class BaseController implements ControllerContracts
{
    /**
     * @var object
     */
    protected static $controller;

    public function init()
    {

    }

    /**
     * @return object
     */
    public static function getController(): object
    {
        if (!self::$controller) self::$controller = new static();
        return self::$controller;
    }
}