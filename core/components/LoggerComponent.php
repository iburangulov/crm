<?php

namespace App\components;

use App\contracts\ComponentsContract;

final class LoggerComponent extends BaseComponent implements ComponentsContract
{
    const COMPONENT_NAME = 'Logger';

    public function init()
    {
        // TODO: Implement init() method.
    }

    public function test()
    {
        // TODO: Implement test() method.
    }

    public function log(string $message)
    {
        echo $message;
    }
}