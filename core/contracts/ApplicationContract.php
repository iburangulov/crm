<?php

namespace App\contracts;

interface ApplicationContract
{
    /**
     * @return void
     * Инициализация приложения
     */
    public function init();

    /**
     * @return void
     * Запуск приложения
     */
    public function start();

    /**
     * @return void
     * Завершение приложения
     */
    public function finish();
}