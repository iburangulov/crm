<?php

namespace App\models;

use App\components\DBComponent;
use App\contracts\ModelsContract;

abstract class BaseModel implements ModelsContract
{
    protected const TABLE = '';

    protected $fields = [];

    public static function find(int $id)
    {
        return DBComponent::select(static::TABLE, $id);
    }

    public static function delete(int $id)
    {
        return DBComponent::delete(static::TABLE, $id);
    }

    public static function create(array $params = [])
    {
        return new static();
    }

    public function save()
    {
        // TODO: Implement save() method.
    }

    public function update(array $params)
    {
        // TODO: Implement update() method.
    }

    public function upgrade()
    {
        // TODO: Implement upgrade() method.
    }

    public function full(array $data)
    {
        // TODO: Implement full() method.
    }
}