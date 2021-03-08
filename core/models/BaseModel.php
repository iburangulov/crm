<?php

namespace App\models;

use App\components\DBComponent;
use App\contracts\ModelsContract;

abstract class BaseModel implements ModelsContract
{
    protected const TABLE = '';

    /**
     * @var int
     * ID записи
     */
    protected $id;

    /**
     * @var array
     * Поле в БД => Значение
     */
    protected $fields = [];

    /**
     * @var bool
     */
    protected $saved = false;

    public function __construct()
    {
        $temp = [];
        foreach ($this->fields as $field => $value)
        {
            $temp[$value] = null;
        }
        $this->fields = $temp;
    }

    public static function find(int $id): ModelsContract
    {
        $data = DBComponent::select(static::TABLE, $id);
        if (!$data) return new static();
        $m = new static();
        $m->update($data);
        $m->id = $data['id'];
        $m->saved = true;
        return $m;
    }

    public static function delete(int $id)
    {
        return DBComponent::delete(static::TABLE, $id);
    }

    public static function create(array $params = [])
    {
        return new static();
    }

    public function save()
    {
        if (key_exists('updated', $this->fields)) $this->fields['updated'] = DBComponent::getTimestamp();
        if (key_exists('created', $this->fields) && !$this->saved) $this->fields['created'] = DBComponent::getTimestamp();

        $fiedls = [];

        foreach ($this->fields as $field => $value)
        {
            if ($value) $fiedls[$field] = $value;
        }

        if ($this->saved) DBComponent::update(static::TABLE, $this->id, $fiedls);
        else {
            DBComponent::insert(static::TABLE, $fiedls);
            $this->id = DBComponent::getLastId(static::TABLE);
        }
        $this->saved = true;
        return $this;
    }

    public function update(array $params)
    {
        foreach ($params as $param_name => $param_value)
        {
            if (key_exists($param_name, $this->fields)) $this->fields[$param_name] = $param_value;
        }
        return $this;
    }
}