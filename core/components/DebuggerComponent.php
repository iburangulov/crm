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
        $errorsList = include ROOT_DIR . 'config/lang/' . $_ENV['LANG'] . '/errors/errors.php';
    }

    public function test()
    {
        // TODO: Implement test() method.
    }

    public static function debug(string $message): void
    {
        $debugger = static::getComponent();
        $debugger->debug_($message);
    }

    private function debug_($message)
    {
        echo $message;
    }
}