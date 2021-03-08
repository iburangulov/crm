<?php

namespace App\components;

use App\contracts\ComponentsManagerContract;
use App\exceptions\RaptorException;

final class ComponentsManager implements ComponentsManagerContract
{
    /**
     * @var array
     * Компоненты
     */
    private static $components;

    /**
     * @var array
     * Сообщения об ошибках - перевод
     */
    private static $error_messages = [];
    /**
     * @var array
     * Сообщения об ошибках - оригинал
     */
    private static $default_error_messages = [];

    public static function init()
    {
        if (file_exists($e = ROOT_DIR . 'config/lang/default/errors/errors.php')) self::$default_error_messages = include_once $e;
        if (file_exists($e = ROOT_DIR . 'config/lang/' . $_ENV['LANG'] . '/errors/errors.php')) self::$error_messages = include_once $e;

        self::$components['Debugger'] = new DebuggerComponent();
        self::$components['Logger'] = new LoggerComponent();
        self::$components['Redis'] = new RedisComponent();
        self::$components['DB'] = new DBComponent();
        self::$components['Document'] = new DocumentComponent();
        self::$components['Protector'] = new ProtectorComponent();
        self::$components['User'] = new UserComponent();
        self::$components['WM'] = new WMComponent();
        self::$components['Router'] = new RouterComponent();

        array_map(function ($component) {
            $component->init();
        }, self::$components);
    }

    public static function getComponent(string $component)
    {
        return self::$components[$component] ?? null;
    }

    public static function getErrorMessage(string $error): string
    {
        if (isset(self::$error_messages[$error])) return self::$error_messages[$error];
        elseif (isset(self::$default_error_messages[$error])) return self::$default_error_messages[$error];
        throw new RaptorException('Ошибка не найдена в конфигурации.');
    }

    public static function test()
    {
        array_map(function ($component) {
            $component->test();
        }, self::$components);
    }
}