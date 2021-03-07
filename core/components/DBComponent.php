<?php

namespace App\components;

use App\contracts\ComponentsContract;

final class DBComponent extends BaseComponent implements ComponentsContract
{
    const COMPONENT_NAME = 'DB';

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