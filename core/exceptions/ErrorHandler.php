<?php

namespace App\exceptions;

final class ErrorHandler
{
    /**
     * @var object
     * Обработчик ошибок
     */
    static $handler;

    public static function init()
    {
        self::$handler = new self();
        set_error_handler([self::$handler, 'handle']);
    }

    public function handle(int $errno, string $errstr, string $errfile, int $errline)
    {
        echo '<tt><hr>Code: ' . $errno;
        echo '<hr>Message: ' . $errstr;
        echo '<hr>File: ' . $errfile;
        echo '<hr>Line: ' . $errline . '<hr></tt>';
        return true;
    }
}