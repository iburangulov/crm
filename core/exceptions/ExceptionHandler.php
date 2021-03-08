<?php

namespace App\exceptions;

final class ExceptionHandler
{
    /**
     * @var object
     * Обьект - обработчик ошибок
     */
    private static $handler;

    public static function init()
    {
        set_exception_handler([new self(), 'handle']);
    }

    public function handle(object $exception)
    {
        echo '<html lang="ru"><body style="background-color: #4b4b4b; font-size: 24px;"> <span style="color: #cdcdcd;">
<tt>Code: ' . $exception->getCode() . '<hr>';
        echo 'Message: ' . $exception->getMessage() . '<hr>';
        echo 'File: ' . $exception->getFile() . '<hr>';
        echo 'Line: ' . $exception->getLine() . '<hr></tt></span></body></html>';
        echo xdebug_get_formatted_function_stack();
    }
}