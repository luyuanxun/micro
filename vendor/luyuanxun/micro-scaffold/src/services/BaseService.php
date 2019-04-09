<?php

namespace Luyuanxun\Micro\Scaffold\services;

class BaseService
{
    protected $className;
    protected $force;

    /**
     * 初始化
     * @param $params
     */
    public function init($params)
    {
        $this->className = $this->camelize($params['table']);
        $this->force = $this->camelize($params['force']);
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