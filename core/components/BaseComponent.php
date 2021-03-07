<?php

namespace App\components;

use App\contracts\ComponentsContract;

abstract class BaseComponent implements ComponentsContract
{
    /**
     * @var bool
     * Статус тестирования компонента
     */
    protected $test_status;

    /**
     * @var array
     * Конфигурация компонента
     */
    protected $config = [];

    public function init()
    {
        $this->config['component'] = static::class;
    }

    public static function getComponent()
    {
        return ComponentsManager::getComponent(static::COMPONENT_NAME) ?? null;
    }

    public function test()
    {
        if (ComponentsManager::getComponent(static::COMPONENT_NAME) !== $this) {
            LoggerComponent::log('BAD_COMPONENT', $this->config);
            $this->test_status = false;
        }
    }
}