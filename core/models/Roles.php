<?php

namespace App\models;

final class Roles extends BaseModel
{
    const TABLE = 'roles';

    protected $fields = [
        'name',
        'created',
        'updated',
        'deleted'
    ];
}