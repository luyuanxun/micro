<?php

namespace Luyuanxun\Micro\Scaffold\services;

use Phalcon\Db\Column;

class BaseService
{
    protected $table;
    protected $className;
    protected $lowerClassName;
    protected $force;
    protected $db;
    protected $columns = [];
    protected $primaryKey;
    protected $templatesDir;

    /**
     * 初始化
     * @param $params
     */
    public function init($params)
    {
        if (empty($this->db)) {
            $this->db = $params['conn'];
        }

        $this->templatesDir = __DIR__ . '/../templates/';
        $this->table = $params['table'];
        $this->className = $this->camelize($params['table']);
        $this->lowerClassName = $this->lowerCamelize($this->className);
        $this->force = $params['force'];
        $exists = $this->db->tableExists($params['table']);
        if (!$exists) {
            die('提示：数据库中没有这张表' . $params['table']);
        }

        $fields = $this->db->describeColumns($params['table']);
        foreach ($fields as $field) {
            if ($field->isPrimary()) {
                $this->primaryKey = $this->lowerCamelize($field->getName());//小驼峰
            }

            $this->columns[] = [
                'fieldName' => $field->getName(),
                'name' => $this->lowerCamelize($field->getName()),
                'type' => $field->getType(),
                'size' => $field->getSize(),
                'isNotNull' => $field->isNotNull(),
            ];
        }

        return $this;
    }

    /**
     * 获取字段校验规则
     * @param $column
     */
    public function getColumnRule($column)
    {
        $rule = '';
        if ($column['isNotNull']) {
            $rule .= 'required|';
        }

        if (in_array($column['type'], [Column::TYPE_INTEGER, Column::TYPE_FLOAT, Column::TYPE_DOUBLE, Column::TYPE_BIGINTEGER])) {
            $rule .= 'num|';
        }

        if (in_array($column['type'], [Column::TYPE_VARCHAR, Column::TYPE_CHAR])) {
            $rule .= 'alphaNum' . ($column['size'] > 0 ? '|strLen:1,' . $column['size'] : '') . '|';
        }

        if ($column['type'] === Column::TYPE_DATE) {
            $rule .= 'date:Y-m-d|';
        }

        if (in_array($column['type'], [Column::TYPE_DATETIME, Column::TYPE_TIMESTAMP])) {
            $rule .= 'date:Y-m-d H:i:s|';
        }

        if (strpos($column['name'], 'email') !== false) {
            $rule .= 'email|';
        }

        return trim($rule, '|');
    }

    /**
     * Converts the underscore_notation to the UpperCamelCase
     *
     * @param string $string
     * @param string $delimiter
     * @return string
     */
    public function camelize($string, $delimiter = '_')
    {
        if (empty($delimiter)) {
            throw new \InvalidArgumentException('Please, specify the delimiter');
        }

        $delimiterArray = str_split($delimiter);

        foreach ($delimiterArray as $delimiter) {
            $stringParts = explode($delimiter, $string);
            $stringParts = array_map('ucfirst', $stringParts);

            $string = implode('', $stringParts);
        }

        return $string;
    }

    /**
     * Converts the underscore_notation to the lowerCamelCase
     *
     * @param string $string
     * @return string
     */
    public function lowerCamelize($string)
    {
        return lcfirst(self::camelize($string));
    }
}