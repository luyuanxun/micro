<?php

namespace Luyuanxun\Micro\Scaffold\services;

use Phalcon\Di;

/**
 * Class ControllerService
 * @package Luyuanxun\Micro\Scaffold\services
 */
class ControllerService extends BaseService
{
    /**
     * 生成控制器
     */
    public function create()
    {
        $controllersDir = Di::getDefault()->get('config')->application->controllersDir;
        $controllerName = $controllersDir . $this->className . 'Controller.php';
        if (file_exists($controllerName) && !$this->force) {
            echo '提示：生成失败，controller已存在：' . $controllerName . PHP_EOL;
            return;
        }

        $template = file_get_contents($this->templatesDir . 'controller.php');
        $template = str_replace(':className:', $this->className, $template);
        $template = str_replace(':lowerClassName:', $this->lowerClassName, $template);
        $template = str_replace(':primaryKey:', $this->primaryKey, $template);

        /**
         * 字段验证规则
         */
        $saveRules = '';
        foreach ($this->columns as $column) {
            if ($column['name'] !== $this->primaryKey) {
                $saveRules .= str_repeat(' ', 12) . "'" . $column['name'] . "' => '" . $this->getColumnRule($column) . "'," . PHP_EOL;
            }
        }

        $saveRules = rtrim($saveRules, PHP_EOL);
        $saveRules = ltrim($saveRules, str_repeat(' ', 12));
        $template = str_replace(':saveRules:', $saveRules, $template);
        file_put_contents($controllerName, $template);
        echo 'controller生成成功：' . $controllerName . PHP_EOL;
    }
}