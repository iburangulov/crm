<?php

namespace App\components;

use App\contracts\ComponentsContract;
use PDO;

final class DBComponent extends BaseComponent implements ComponentsContract
{
    const COMPONENT_NAME = 'DB';

    /**
     * @var PDO
     * Обьект для работы с БД
     */
    private $db;

    public function init()
    {
        // TODO: Implement init() method.
    }

    public function test()
    {
        if (static::getComponent() !== $this) {
            LoggerComponent::getComponent()->log('AWD');
        }
    }
}