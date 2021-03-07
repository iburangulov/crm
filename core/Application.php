<?php

namespace App;

use App\components\ComponentsManager;
use App\components\DBComponent;
use App\contracts\ApplicationContract;

class Application implements ApplicationContract
{
    public function __construct()
    {
        ini_set('error_reporting', E_ALL);
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
    }

    public function init()
    {
        ComponentsManager::init();
        ComponentsManager::test();
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