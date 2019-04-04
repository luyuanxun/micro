<?php

namespace App\Controllers;

use App\Services\UserService;

class UserController extends BaseController
{
    /**
     * 登录
     * @return string
     * @throws \App\Common\CustomException
     */
    public function login()
    {
        $name = $this->request->getPost('name');
        $password = $this->request->getPost('password');
        return UserService::login($name, $password);
    }
}

