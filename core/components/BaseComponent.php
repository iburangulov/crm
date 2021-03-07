<?php

namespace App\components;

use App\contracts\ComponentsContract;

abstract class BaseComponent implements ComponentsContract
{
    public static function getComponent()
    {
        return ComponentsManager::getComponent(static::COMPONENT_NAME) ?? null;
    }
}