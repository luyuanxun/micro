<?php

namespace App\Controllers;

use Luyuanxun\Micro\Tools\CustomValidation;
use Luyuanxun\Micro\Tools\CustomException;
use App\Services\UserService;

/**
 * Class UserController
 * @package App\Controllers
 */
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

    /**
     * 获取列表
     * @return array
     * @throws CustomException
     */
    public function getList()
    {
        $rules = [
            'page' => 'required|digit|between:1',
            'pageSize' => 'required|digit|between:1',
        ];

        $params = CustomValidation::validate($this->getParams(), $rules);
        $this->di->getService('encryptFields')->setDefinition(['id']);//若主键名为id，此行可删掉，默认加密id
        return $this->userService->getList($params);
    }

    /**
     * 根据ID获取详情
     * @return array
     * @throws CustomException
     */
    public function getInfo()
    {
        $rules = [
            'id' => 'required|strLen:24',
        ];

        $params = CustomValidation::validate($this->getParams(), $rules);
        $this->di->getService('encryptFields')->setDefinition(['id']);//若主键名为id，此行可删掉，默认加密id
        return $this->userService->getInfo($params);
    }

    /**
     * 创建
     * @throws CustomException
     */
    public function create()
    {
        $rules = [
            'username' => 'required|alphaNum|strLen:1,32',
            'password' => 'required|alphaNum|strLen:1,100',
            'status' => 'required|num',
            'isDeleted' => 'required|num',
            'createTime' => 'date:Y-m-d H:i:s',
            'updateTime' => 'date:Y-m-d H:i:s',
        ];

        $params = CustomValidation::validate($this->getParams(), $rules);
        $this->userService->create($params);
    }

    /**
     * 修改
     * @throws CustomException
     */
    public function update()
    {
        $rules = [
            'id' => 'required|strLen:24',
            'username' => 'required|alphaNum|strLen:1,32',
            'password' => 'required|alphaNum|strLen:1,100',
            'status' => 'required|num',
            'isDeleted' => 'required|num',
            'createTime' => 'date:Y-m-d H:i:s',
            'updateTime' => 'date:Y-m-d H:i:s',
        ];

        $params = CustomValidation::validate($this->getParams(), $rules);
        $this->userService->update($params);
    }

    /**
     * 删除
     * @throws CustomException
     */
    public function delete()
    {
        $rules = [
            'id' => 'required|strLen:24',
        ];

        $params = CustomValidation::validate($this->getParams(), $rules);
        $this->userService->delete($params);
    }
}

