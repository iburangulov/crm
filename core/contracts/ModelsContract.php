<?php

namespace App\contracts;

interface ModelsContract
{
    /**
     * @param int $id
     * @return self
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
     * @return self
     * Создать пустую модель
     */
    public static function create(array $params = []);

    /**
     * @return self
     * Записать модель в БД
     */
    public function save();

    /**
     * @param array $params
     * @return self
     * Изменить поля в обьекте
     */
    public function update(array $params);
}