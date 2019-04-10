<?php

namespace App\Services;

use App\Common\Code;
use App\Common\Constant;
use Luyuanxun\Micro\Tools\CustomException;
use App\Models\User;

/**
 * Class UserService
 * @package App\Services
 */
class UserService
{
    /**
     * @var User
     */
    public $user;

    /**
     * 初始化
     */
    public function __construct()
    {
        $this->user = new User();
    }

    /**
     * 获取列表
     * @param $params
     * @return array
     */
    public function getList($params)
    {
        $page = $params['page'] ?? 1;
        $pageSize = $params['pageSize'] ?? Constant::PAGE_SIZE;
        return $this->user->getList($page, $pageSize);
    }

    /**
     * 获取详情
     * @param $params
     * @return array
     * @throws CustomException
     */
    public function getInfo($params)
    {
        $data = [
            'columns' => [],
            'conditions' => 'id = :id:',
            'bind' => [
                'id' => $params['id']
            ]
        ];

        return $this->user->getOne($data);
    }

    /**
     * 创建
     * @param $params
     * @throws CustomException
     */
    public function create($params)
    {
        $ret = $this->user->create($params, $this->user->saveColumn);
        if (!$ret) {
            error_exit(Code::CREATE_FAILED);
        }
    }

    /**
     * 修改
     * @param $params
     * @throws CustomException
     */
    public function update($params)
    {
        $ret = $this->user->model($params['id'])->update($params, $this->user->saveColumn);
        if (!$ret) {
            error_exit(Code::UPDATE_FAILED);
        }
    }

    /**
     * 删除
     * @param $params
     * @throws CustomException
     */
    public function delete($params)
    {
        $ret = $this->user->model($params['id'])->delete();
        if (!$ret) {
            error_exit(Code::DELETE_FAILED);
        }
    }
}