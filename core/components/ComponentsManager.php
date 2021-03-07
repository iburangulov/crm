<?php

namespace App\components;

use App\contracts\ComponentsManagerContract;

final class ComponentsManager implements ComponentsManagerContract
{
    /**
     * @var array
     * Компоненты
     */
    private static $components;

    public static function init()
    {
        self::$components['Debugger'] = new DebuggerComponent();
        self::$components['Logger'] = new LoggerComponent();
        self::$components['Redis'] = new RedisComponent();
        self::$components['DB'] = new DBComponent();
        self::$components['Document'] = new DocumentComponent();
        self::$components['Protector'] = new ProtectorComponent();
        self::$components['User'] = new UserComponent();
        self::$components['WM'] = new WMComponent();

        array_map(function ($component) {
            $component->init();
        }, self::$components);
    }

    public static function getComponent(string $component)
    {
        return self::$components[$component] ?? null;
    }

    public static function test()
    {
        array_map(function ($component) {
            $component->test();
        }, self::$components);
    }
}