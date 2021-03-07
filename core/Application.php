<?php

namespace App;

use App\components\Bus;
use App\contracts\ApplicationContract;

class Application implements ApplicationContract
{
    /**
     * @var array
     * Компоненты приложения
     */
    private $components;

    public function init()
    {
        $this->components['Bus'] = new Bus();
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