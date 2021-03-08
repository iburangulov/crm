<?php

namespace App\components;

final class RouterComponent extends BaseComponent
{
    const COMPONENT_NAME = 'Router';

    private $session;

    /**
     * @var object
     * Текущий контроллер
     */
    private static $current_controller;

    public function init(): void
    {
        session_start([
            'cookie_lifetime' => 86400,
        ]);

        parent::init();
        $controller_name = ucfirst(strtolower(trim($_SERVER['REQUEST_URI'], '/')));
        $controller = '\\App\\controllers\\' . $controller_name;
        if (file_exists(ROOT_DIR . 'core/controllers/' . $controller_name . '.php')) {
            self::$current_controller = new $controller();
        } else {
            $controller = '\\App\\controllers\\Home';
            self::$current_controller = new $controller();
        }
    }

    /**
     * @param string $controller
     * @return object
     * Возвращает контроллер
     */
    public static function getController(string $controller = ''): object
    {
        if (!$controller) return self::$current_controller;
        if (file_exists(ROOT_DIR . 'core/controllers/' . $controller . '.php'))
        {
            $controller = '\\App\\controllers\\' . $controller;
            return new $controller();
        }
        $controller = '\\App\\controllers\\Home';
        return new $controller();
    }
}