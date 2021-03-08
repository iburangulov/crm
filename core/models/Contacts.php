<?php

namespace App\models;

final class Contacts extends BaseModel
{
    const TABLE = 'contacts';

    protected $fields = [
        'account_id',
        'type',
        'contact',
        'created',
        'updated',
        'deleted'
    ];
}