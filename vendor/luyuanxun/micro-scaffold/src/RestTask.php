<?php

namespace Luyuanxun\Micro\Scaffold;

use Luyuanxun\Micro\Scaffold\services\ControllerService;
use Luyuanxun\Micro\Scaffold\services\ModelService;
use Luyuanxun\Micro\Scaffold\services\ServiceService;
use Phalcon\Cli\Task;

class RestTask extends Task
{
    /**
     * 根据模版生成控制器
     * @param $params
     */
    public function controllerAction($params)
    {
        $controllerService = new ControllerService();
        $controllerService->init($params)->create();
    }

    /**
     * 根据模版生成模型
     * @param $params
     */
    public function modelAction($params)
    {
        $modelService = new ModelService();
        $modelService->init($params)->create();
    }

    /**
     * 生成crud
     * @param $params
     */
    public function crudAction($params)
    {
        //controller
        $controllerService = new ControllerService();
        $controllerService->init($params)->create();

        //model
        $modelService = new ModelService();
        $modelService->init($params)->create();

        //service
        $serviceService = new ServiceService();
        $serviceService->init($params)->create();
        $serviceService->createRoute();//生成路由
        echo 'CURD完成！！！' . PHP_EOL;
        echo '恭喜恭喜，请根据' . APP_PATH . '/app.php的路由规则测试一波';
    }
}
