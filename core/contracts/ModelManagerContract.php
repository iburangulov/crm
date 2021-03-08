<?php

namespace App\contracts;

interface ModelManagerContract
{
    /**
     * @param string $model
     * @return self
     * Возвращает пустой экземпляр модели
     */
    public static function getModel(string $model);

    /**
     * @param string $model
     * @param int $id
     * @return self
     * Возвращает обьект из БД
     */
    public static function find(string $model, int $id);
}