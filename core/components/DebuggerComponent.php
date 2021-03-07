<?php

namespace App\components;

use App\contracts\ComponentsContract;

final class DebuggerComponent extends BaseComponent implements ComponentsContract
{

    const COMPONENT_NAME = 'Debugger';

    /**
     * @var array
     * Список ошибок
     */
    private $errorsList;

    public function init()
    {
        // TODO: Implement init() method.
    }

    public function test()
    {
        // TODO: Implement test() method.
    }
}