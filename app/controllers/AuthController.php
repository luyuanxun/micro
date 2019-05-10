<?php

namespace App\Controllers;

use App\Common\Code;
use App\Models\Admin;
use App\Services\AdminService;
use Lyx\Micro\Tools\Authorization;
use Lyx\Micro\Tools\CustomValidation;
use Lyx\Micro\Tools\CustomException;

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
            'name' => 'required',
            'password' => 'required|strLen:6,32'
        ];

        $params = CustomValidation::validate($this->getParams(), $rules);
        $admin = Admin::findFirstByName($params['name']);
        if (!($admin && $this->security->checkHash($params['password'], $admin->password))) {
            $this->security->hash(rand());
            error_exit(Code::LOGIN_ERROR);
        }

        $ret = Authorization::createToken($admin->id);
        return $ret;
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
        $jwt = Authorization::analyzeToken();
        $id = $jwt['id'];
        $admin = new AdminService();
        return $admin->getInfo(compact('id'));
    }
}

