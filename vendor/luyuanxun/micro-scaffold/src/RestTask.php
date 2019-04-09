<?php

namespace Luyuanxun\Micro\Scaffold;

use Luyuanxun\Micro\Scaffold\services\ControllerService;
use Phalcon\Cli\Task;

class RestTask extends Task
{
    /**
     * @var ControllerService
     */
    public $controllerService;

    /**
     * 初始化
     */
    public function onConstruct()
    {
        $this->controllerService = new ControllerService();
    }

    /**
     * 根据模版生成控制器
     * @param $params
     */
    public function controllerAction($params)
    {
        $this->controllerService->create($params);
    }

    public function modelAction($params)
    {
        var_dump('modelAction', $params);
        exit();
    }

    public function crudAction($params)
    {
        var_dump('crudAction', $params);
        exit();
    }
}
