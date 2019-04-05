<?php

namespace App\Controllers;

use App\Common\Authorization;
use App\Common\Code;
use App\Common\CustomValidation;
use App\Common\CustomException;
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
            'name' => 'required|alphaNum',
            'password' => 'required|alphaNum|strLen:6,32'
        ];

        $msg = [
            'name.required' => "姓名不能为空"
        ];

        $params = CustomValidation::validate($this->request->getPost(), $rules, $msg);
        if (!($params['name'] == 'demo' && $params['password'] == '123456')) {
            error_exit(Code::USER_LOGIN_ERROR);
        }

        $userId = 199;//TODO 通过数据库获取userId
        return Authorization::createToken($userId);
    }

    /**
     * 刷新token
     */
    public function refresh()
    {
        $auth = Di::getDefault()->getService('auth')->getDefinition();
        return Authorization::createToken($auth['jti']);
    }

    /**
     * 获取当前token的用户信息
     */
    public function getInfo()
    {
        return Di::getDefault()->getService('auth')->getDefinition();
    }
}

