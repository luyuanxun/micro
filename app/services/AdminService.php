<?php

namespace App\Services;

use App\Common\Code;
use App\Common\Constant;
use Lyx\Micro\Tools\CustomException;
use App\Models\Admin;

/**
 * Class AdminService
 * @package App\Services
 */
class AdminService
{
    /**
     * @var Admin
     */
    public $admin;

    /**
     * 初始化
     */
    public function __construct()
    {
        $this->admin = new Admin();
    }

    /**
     * 获取列表
     * @param array $params
     * @return array
     */
    public function getList(array $params)
    {
        $page = $params['page'] ?? 1;
        $pageSize = $params['pageSize'] ?? Constant::PAGE_SIZE;
        return $this->admin->getList($page, $pageSize);
    }

    /**
     * 获取详情
     * @param array $params
     * @return array
     * @throws CustomException
     */
    public function getInfo(array $params)
    {
        $data = [
            'columns' => [],
            'conditions' => 'id = :id:',
            'bind' => [
                'id' => $params['id']
            ]
        ];

        return $this->admin->getOne($data);
    }

    /**
     * 创建
     * @param array $params
     * @throws CustomException
     */
    public function create(array $params)
    {
        $ret = $this->admin->create($params, $this->admin->saveColumn);
        if (!$ret) {
            error_exit(Code::CREATE_FAILED);
        }
    }

    /**
     * 修改
     * @param array $params
     * @throws CustomException
     */
    public function update(array $params)
    {
        $ret = $this->admin->model($params['id'])->update($params, $this->admin->saveColumn);
        if (!$ret) {
            error_exit(Code::UPDATE_FAILED);
        }
    }

    /**
     * 删除
     * @param array $params
     * @throws CustomException
     */
    public function delete(array $params)
    {
        $ret = $this->admin->model($params['id'])->delete();
        if (!$ret) {
            error_exit(Code::DELETE_FAILED);
        }
    }
}