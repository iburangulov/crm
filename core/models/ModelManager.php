<?php

namespace App\models;

use App\components\ComponentsManager;
use App\components\LoggerComponent;
use App\contracts\ModelManagerContract;
use App\contracts\ModelsContract;
use App\exceptions\RaptorException;

final class ModelManager implements ModelManagerContract
{
    const MODELS = [
        'account' => 'Accounts',
        'contacts' => 'Contacts',
        'roles' => 'Roles'
    ];

    public static function getModel(string $model): ModelsContract
    {
        if (isset(self::MODELS[$model]))
        {
            $m = '\\App\\models\\' . self::MODELS[$model];
            return new $m;
        }

        LoggerComponent::log('MODEL_NOT_FOUND', $model);

        throw new RaptorException(ComponentsManager::getErrorMessage('MODEL_NOT_FOUND'));
    }

    /**
     * @param string $model
     * @param int $id
     * @return ModelsContract
     * Возвращает
     */
    public static function find(string $model, int $id): ModelsContract
    {
        if (isset(self::MODELS[$model]))
        {
            $m = '\\App\\models\\' . self::MODELS[$model];
            return $m::find($id);
        }

        LoggerComponent::log(ComponentsManager::getErrorMessage('MODEL_NOT_FOUND'));

        throw new RaptorException(ComponentsManager::getErrorMessage('MODEL_NOT_FOUND'));
    }
}