<?php

namespace App\Controllers;

use App\Services\UserService;

class UserController extends BaseController
{
    /**
     * @var UserService
     */
    public $userService;

    /**
     * 初始化
     */
    public function onConstruct()
    {
        $this->userService = new UserService();
    }

}

