<?php

namespace App\components;

use App\exceptions\RaptorException;
use PDO;
use PDOException;

final class DBComponent extends BaseComponent
{
    const COMPONENT_NAME = 'DB';

    const RETURNING_ASSOC = 1;
    const RETURNING_NUM = 2;
    const RETURNING_ONE = 3;
    const RETURNING_NONE = 4;

    const SUPPORTED_DATABASES = [
        'mysql',
        'postgresql'
    ];

    /**
     * @var PDO
     * Обьект для работы с БД
     */
    private static $pdo;

    public function init(): void
    {
        parent::init();
        $this->config['driver'] = $_ENV['DB_DRIVER'];
        $this->config['host'] = $_ENV['DB_HOST'];
        $this->config['port'] = $_ENV['DB_PORT'];
        $this->config['name'] = $_ENV['DB_NAME'];
        $this->config['user'] = $_ENV['DB_USER'];
        $this->config['pass'] = $_ENV['DB_PASS'];

        if (!in_array($this->config['driver'], self::SUPPORTED_DATABASES)) {
            LoggerComponent::log('UNSUPPORTED_DB_DRIVER', $this->config);
            throw new RaptorException(ComponentsManager::getErrorMessage('UNSUPPORTED_DB_DRIVER'));
        }

        switch ($this->config['driver']) {
            case 'mysql':
                $dsn = 'mysql:host=' . $this->config['host'] . ';port=' . $this->config['port'] .
                    ';dbname=' . $this->config['name'];
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ];
                try {
                    self::$pdo = new PDO($dsn, $this->config['user'], $this->config['pass'], $options);
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
                    self::$pdo = new PDO($dsn);
                } catch (PDOException $exception) {
                    LoggerComponent::log('BAD_ENV_DB', $this->config);
                    throw new RaptorException(ComponentsManager::getErrorMessage('BAD_ENV_DB'));
                }
                break;
        }
    }

    /**
     * @param string $query
     * @param int $returning
     * @return array|bool|mixed
     * Выполнить запрос к БД
     */
    public static function query(string $query, int $returning = 0)
    {
        $result = self::$pdo->query($query);
        if (!$result) return [];
        switch ($returning) {
            case 0:
            case self::RETURNING_NONE:
                break;
            case self::RETURNING_ASSOC:
                return $result->fetchAll(PDO::FETCH_ASSOC);
            case self::RETURNING_NUM:
                return $result->fetchAll(PDO::FETCH_NUM);
            case self::RETURNING_ONE:
                return $result->fetch(PDO::FETCH_NUM);
        }
    }

    /**
     * @param string $table
     * @return int
     * Вернет поледний ID
     */
    public static function getLastId(string $table): int
    {
        $r =  self::query('SELECT MAX(id) FROM ' . $table . ';', self::RETURNING_ONE);
        return current($r);
    }

    /**
     * @param string $table
     * @param int $id
     * @return array|bool|mixed
     */
    public static function getById(string $table, int $id)
    {
        $sql = 'SELECT * FROM ' . $table . 'WHERE id = ' . $id . ';';
        return self::query($sql, self::RETURNING_ONE);
    }

    public static function select(string $table, int $id)
    {
        $result = '';
        switch (gettype($id)) {
            case 'array':
                $query = '';
                foreach ($id as $i) {
                    $query .= $i . ', ';
                }
                $query = trim($query, ', ');
                $query = 'SELECT * FROM ' . $table . 'WHERE id IN (' . $query . ');';
                $result = self::query($query, self::RETURNING_ASSOC);
                break;
            case 'integer':
            case 'string':
                $query = 'SELECT * FROM ' . $table . ' WHERE id = ' . (int)$id . ';';
                $result = current(self::query($query, self::RETURNING_ASSOC));
                break;
        }

        return $result;
    }

    /**
     * @param string $table
     * @param array $data
     * @return bool
     */
    public static function insert(string $table, array $data): bool
    {
        $rows = '(';
        $values = '(';
        foreach ($data as $row => $value) {
            $rows .= $row . ', ';
            $values .= ':' . $row . ', ';
        }
        $rows = trim($rows, ' ,');
        $values = trim($values, ' ,');
        $rows .= ')';
        $values .= ')';
        $sql = 'INSERT INTO ' . $table . ' ' . $rows . ' VALUES ' . $values . ';';
        $sth = self::$pdo->prepare($sql);
        return $sth->execute($data);
    }

    /**
     * @param string $table
     * @param array $data
     * @return bool
     */
    public static function update(string $table, int $id, array $data): bool
    {
        $query = '';
        foreach ($data as $row => $value) {
            $query .= $row . ' = :' . $row . ', ';
        }
        $query = trim($query, ', ');
        $sql = 'UPDATE ' . $table . ' SET ' . $query . ' WHERE id = ' . $id . ';';
        $sth = self::$pdo->prepare($sql);
        return $sth->execute($data);
    }

    public static function delete(string $table, $id)
    {
        $result = '';
        switch (gettype($id)) {
            case 'array':
                $query = '';
                foreach ($id as $i) {
                    $query .= $i . ', ';
                }
                $query = trim($query, ', ');
                $query = 'DELETE ' . $table . 'WHERE id IN (' . $query . ');';
                $result = self::query($query, self::RETURNING_ONE);
                break;
            case 'integer':
            case 'string':
                $query = 'DELETE FROM ' . $table . ' WHERE id = ' . (int)$id . ';';
                $result = self::query($query, self::RETURNING_ONE);
                break;
        }

        return $result;
    }

    public function test(): void
    {
        parent::test();
        if ($this->test_status !== false) {
            $status = self::$pdo->getAttribute(PDO::ATTR_CONNECTION_STATUS);
            if (!$status) $this->test_status = false;
        } else $this->test_status = true;
    }

    /**
     * @param string $version
     */
    public static function migrate(string $version): void
    {
        if (file_exists($m = ROOT_DIR . 'config/database/migrations/' . $version . '.php'))
        {
            $migration = include_once $m;

            foreach ($migration as $action)
            {
                self::query($action);
            }

        } else {
            LoggerComponent::log(ComponentsManager::getErrorMessage('MIGRATION_NOT_FOUND'));
            throw new RaptorException(ComponentsManager::getErrorMessage('MIGRATION_NOT_FOUND'));
        }
    }

    public static function getTimestamp(): string
    {
        return date("Y-m-d H:i:s");
    }

}