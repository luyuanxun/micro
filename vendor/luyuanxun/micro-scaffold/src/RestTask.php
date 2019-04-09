<?php

namespace Luyuanxun\Micro\Scaffold;

use Phalcon\Cli\Task;

class RestTask extends Task
{
    public function crudAction($params)
    {
        var_dump('crud', $params);
        exit();
    }

}
