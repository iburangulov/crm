<?php

namespace App\contracts;

interface ComponentsContract
{
    /**
     * @return void
     * Инициализация компонента
     */
    public function init();

    /**
     * @return bool
     * Проверка компонента
     */
    public function test();

    /**
     * @return object
     * Возвращает компонент
     */
    public static function getComponent();

    /**
     * @return mixed
     * Возвращает имя компонента
     */
    public static function getComponentName();
}