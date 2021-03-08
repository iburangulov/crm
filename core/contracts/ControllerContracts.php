<?php

namespace App\contracts;

interface ControllerContracts
{
    /**
     * @return void
     * Инициализирует контроллер
     */
    public function init();

    /**
     * @return object
     * Возвращает себя
     */
    public static function getController();
}