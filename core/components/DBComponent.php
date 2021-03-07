<?php

namespace App\components;

use App\exceptions\RaptorException;
use PDO;
use PDOException;

final class DBComponent extends BaseComponent
{
    const COMPONENT_NAME = 'DB';

    const SUPPORTED_DATABASES = [
        'mysql',
        'postgresql'
    ];

    /**
     * @var PDO
     * Обьект для работы с БД
     */
    private $db;

    public function init(): void
    {
        parent::init();
        $this->config['driver'] = $_ENV['DB_DRIVER'];
        $this->config['host'] = $_ENV['DB_HOST'];
        $this->config['port'] = $_ENV['DB_PORT'];
        $this->config['name'] = $_ENV['DB_NAME'];
        $this->config['user'] = $_ENV['DB_USER'];
        $this->config['pass'] = $_ENV['DB_PASS'];

        if (!in_array($this->config['driver'], self::SUPPORTED_DATABASES))
        {
            LoggerComponent::log('UNSUPPORTED_DB_DRIVER', $this->config);
            throw new RaptorException(ComponentsManager::getErrorMessage('UNSUPPORTED_DB_DRIVER'));
        }

        switch ($this->config['driver']) {
            case 'mysql':
                $dsn = 'mysql:host=' . $this->config['host'] . ';port=' . $this->config['port'] .
                    'dbname=' . $this->config['name'];
                $options = [
                    PDO::MYSQL_ATTR_COMPRESS,
                ];
                try {
                    $this->db = new PDO($dsn, $this->config['user'], $this->config['pass'], $options);
                } catch (PDOException $exception) {
                    LoggerComponent::log('BAD_ENV_DB', $this->config);
                    throw new RaptorException(ComponentsManager::getErrorMessage('BAD_ENV_DB'));
                }
                break;
            case 'postgresql':
                $dsn = 'pgsql:host=' . $this->config['host'] . ';port=' . $this->config['port'] .
                    ';dbname=' . $this->config['name'] . ';user=' . $this->config['user'] .
                    ';password=' . $this->config['pass'];
                try {
                    $this->db = new PDO($dsn);
                } catch (PDOException $exception) {
                    LoggerComponent::log('BAD_ENV_DB', $this->config);
                    throw new RaptorException(ComponentsManager::getErrorMessage('BAD_ENV_DB'));
                }
                break;
        }
    }

    public function test(): void
    {
        parent::test();
        if ($this->test_status !== false)
        {
            $status = $this->db->getAttribute(PDO::ATTR_CONNECTION_STATUS);
            if (!$status) $this->test_status = false;
        } else $this->test_status = true;
    }
}