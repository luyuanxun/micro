<?php

namespace App\Controllers;

use App\Common\CustomValidation;
use App\Common\CustomException;
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
        return $this->userService->getInfo($params);
    }

    /**
     * 创建
     * @throws CustomException
     */
    public function create()
    {
        $rules = [
            'username' => 'required|alphaNum|unique:user',
            'password' => 'required|strLen:6,32'
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
            'username' => 'required|alphaNum',
            'password' => 'required|strLen:6,32'
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

