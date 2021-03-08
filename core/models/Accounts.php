<?php

namespace App\models;

final class Accounts extends BaseModel
{
    protected const TABLE = 'accounts';

    protected const FIELDS = [
        'id',
        'first_name',
        'second_name',
        'role',
        'tariff',
        'created',
        'updated',
        'deleted'
    ];
}