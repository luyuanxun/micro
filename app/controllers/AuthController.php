<?php

namespace App\Controllers;

use App\Common\Authorization;
use App\Common\Code;
use App\Common\CustomValidation;
use App\Common\CustomException;
use App\Models\User;
use Phalcon\Di;

class AuthController extends BaseController
{
    /**
     * 登录（token有效期2小时，前端自行缓存，建议在到期前5分钟刷新更换）
     * @return array
     * @throws CustomException
     */
    public function getToken()
    {
        $rules = [
            'username' => 'required|alphaNum',
            'password' => 'required|alphaNum|strLen:6,32'
        ];

        $params = CustomValidation::validate($this->request->getPost(), $rules);
        $user = User::findFirst([
            'columns' => 'id, password',
            'username = ?0',
            'bind' => [
                $params['username']
            ]
        ])->toArray();

        if (!($user && $this->security->checkHash($params['password'], $user['password']))) {
            $this->security->hash(rand());
            error_exit(Code::LOGIN_ERROR);
        }

        return Authorization::createToken($user['id']);
    }

    /**
     * 刷新token
     */
    public function refresh()
    {
        $auth = Di::getDefault()->getService('auth')->getDefinition();
        return Authorization::createToken($auth['id']);
    }

    /**
     * 获取当前token的用户信息(需要什么信息自行在UserService定义返回获取)
     * @return array
     * @throws CustomException
     */
    public function getInfo()
    {
        return $this->getUserId();
    }
}

