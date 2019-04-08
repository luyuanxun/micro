<?php

namespace App\Controllers;

use App\Common\Authorization;
use App\Common\Code;
use App\Common\CustomValidation;
use App\Common\CustomException;

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

        $params = CustomValidation::validate($this->getParams(), $rules);

        /**
         * TODO 根据个人需求处理登录
         */
        $password = $this->security->hash("123456");
        if (!($params['name'] === 'test' && $this->security->checkHash($params['password'], $password))) {
            $this->security->hash(rand());
            error_exit(Code::LOGIN_ERROR);
        }

        $userId = 100;
        return Authorization::createToken($userId);
    }

    /**
     * 刷新token()
     * @return array
     * @throws CustomException
     */
    public function refresh()
    {
        $auth = Authorization::analyzeToken();
        return Authorization::createToken($auth['id']);
    }

    /**
     * 获取当前token的用户信息
     * @return array
     * @throws CustomException
     */
    public function getInfo()
    {
        return Authorization::analyzeToken();
    }
}

