<?php

namespace Luyuanxun\Micro\Scaffold\services;

class ControllerService extends BaseService
{
    /**
     * @param $params
     */
    public function create($params)
    {
        $this->init($params);
        var_dump($this->className, $this->lowerCamelize($this->className));
        exit();
        

    }
}