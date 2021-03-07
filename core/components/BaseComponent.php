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

    protected const COMPONENT_NAME = '';

    public function init(): void
    {
        $this->config['component'] = static::class;
    }

    /**
     * @return object|null
     */
    public static function getComponent(): ?object
    {
        return ComponentsManager::getComponent(static::COMPONENT_NAME) ?? null;
    }

    /**
     * @throws \App\exceptions\RaptorException
     */
    public function test(): void
    {
        if (ComponentsManager::getComponent(static::COMPONENT_NAME) !== $this) {
            LoggerComponent::log('BAD_COMPONENT', $this->config);
            $this->test_status = false;
        }
    }

    /**
     * @return string
     */
    public static function getComponentName(): string
    {
        return static::COMPONENT_NAME;
    }
}