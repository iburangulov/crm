<?php

namespace App\contracts;

interface ModelsContract
{
    /**
     * @param int $id
     * @return mixed
     * Вернуть модель по ID
     */
    public static function getById(int $id);
}