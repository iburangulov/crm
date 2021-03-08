<?php

namespace App;

use App\components\ComponentsManager;
use App\components\DBComponent;
use App\components\LoggerComponent;
use App\components\RouterComponent;
use App\contracts\ApplicationContract;
use App\exceptions\ErrorHandler;
use App\exceptions\ExceptionHandler;
use Dotenv\Dotenv;

class Application implements ApplicationContract
{
    private $env_required = [
        'LANG',
        'LOGGING',
        'DB_DRIVER',
        'DB_HOST',
        'DB_PORT',
        'DB_NAME',
        'DB_USER',
        'DB_PASS'
    ];

    public function __construct()
    {
        ini_set('error_reporting', E_ALL);
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
    }

    public function init()
    {
        $dotenv = Dotenv::createImmutable(ROOT_DIR);
        $dotenv->load();

        array_map(function ($env) use ($dotenv) {
            $dotenv->required($env);
        }, $this->env_required);

        ExceptionHandler::init();
        ErrorHandler::init();

        ComponentsManager::init();
        ComponentsManager::test();

        RouterComponent::getController()->init();

    }

    public function start()
    {
        // TODO: Implement start() method.
    }

    public function finish()
    {
        // TODO: Implement finish() method.
    }
}