<?php

namespace App\contracts;

interface ComponentsManagerContract
{
    /**
     * @return void
     * Инициализация менеджера компонентов
     */
    public static function init();

    /**
     * @return void
     * Тестирование компонентов
     */
    public static function test();

    /**
     * @return object
     * Получить компонент
     */
    public static function getComponent(string $component);
}