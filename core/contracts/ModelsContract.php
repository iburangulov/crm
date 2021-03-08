<?php

namespace App\contracts;

interface ModelsContract
{
    /**
     * @param int $id
     * @return mixed
     * Вернуть модель по ID
     */
    public static function find(int $id);

    /**
     * @param int $id
     * @return mixed
     * Удалить модель по ID
     */
    public static function delete(int $id);

    /**
     * @param array $params
     * @return mixed
     * Создать пустую модель
     */
    public static function create(array $params = []);

    /**
     * @return mixed
     * Записать модель в БД
     */
    public function save();

    /**
     * @param array $params
     * @return mixed
     * Изменить поля в обьекте
     */
    public function update(array $params);

    /**
     * @return mixed
     * Записать изменения в БД
     */
    public function upgrade();

    /**
     * @param array $data
     * @return mixed
     * Заполняет данные модели из массива
     */
    public function full(array $data);
}