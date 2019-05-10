<?php

namespace App\Controllers;

use Lyx\Micro\Tools\CustomValidation;
use Lyx\Micro\Tools\CustomException;
use App\Services\AdminService;

/**
 * Class AdminController
 * @package App\Controllers
 */
class AdminController extends BaseController
{
    /**
     * @var AdminService
     */
    public $adminService;

    /**
     * 初始化
     */
    public function onConstruct()
    {
        $this->adminService = new AdminService();
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
        return $this->adminService->getList($params);
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
        return $this->adminService->getInfo($params);
    }

    /**
     * 创建
     * @throws CustomException
     */
    public function create()
    {
        $rules = [
            'name' => 'required|strLen:1,32',
            'password' => 'required|strLen:1,100',
            'status' => 'required|num',
            'isDeleted' => 'required|num',
            'createTime' => 'date:Y-m-d H:i:s',
            'updateTime' => 'date:Y-m-d H:i:s',
        ];

        $params = CustomValidation::validate($this->getParams(), $rules);
        $this->adminService->create($params);
    }

    /**
     * 修改
     * @throws CustomException
     */
    public function update()
    {
        $rules = [
            'id' => 'required|strLen:24',
            'name' => 'required|strLen:1,32',
            'password' => 'required|strLen:1,100',
            'status' => 'required|num',
            'isDeleted' => 'required|num',
            'createTime' => 'date:Y-m-d H:i:s',
            'updateTime' => 'date:Y-m-d H:i:s',
        ];

        $params = CustomValidation::validate($this->getParams(), $rules);
        $this->adminService->update($params);
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
        $this->adminService->delete($params);
    }
}

