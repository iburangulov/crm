<?php

namespace App\models;

use App\contracts\ModelsContract;

abstract class BaseModel implements ModelsContract
{
    protected const MODEL_NAME = '';

    public static function getById(int $id)
    {

    }
}