<?php

namespace App\Models;

use App\Common\Code;
use Lyx\Micro\Tools\CustomException;
use Phalcon\Mvc\Model;

class Admin extends Base
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $password;

    /**
     * @var integer
     */
    public $status;

    /**
     * @var integer
     */
    public $isDeleted;

    /**
     * @var string
     */
    public $createTime;

    /**
     * @var string
     */
    public $updateTime;

    /**
     * 允许显示的字段
     * @var array
     */
    public $getColumn = ['id', 'name', 'password', 'status', 'isDeleted', 'createTime', 'updateTime'];

    /**
     * 允许创建|修改字段
     * @var array
     */
    public $saveColumn = ['name', 'password', 'status', 'isDeleted', 'createTime', 'updateTime'];

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        parent::initialize();
        $this->setSchema("phalcon");
        $this->setSource("admin");
    }

    /**
     * Returns table name mapped in the model.
     * @return string
     */
    public function getSource()
    {
        return 'admin';
    }

    /**
     * 处理更新时间
     */
    public function beforeSave()
    {

    }

    /**
     * 字段转驼峰
     * @return array
     */
    public function columnMap()
    {
        return [
            'id' => 'id',
            'name' => 'name',
            'password' => 'password',
            'status' => 'status',
            'is_deleted' => 'isDeleted',
            'create_time' => 'createTime',
            'update_time' => 'updateTime',
        ];
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function getCount(array $params)
    {
        return Admin::count($params);
    }

    /**
     * @param array $params
     * @return array
     */
    public function getAll(array $params)
    {
        if (empty($params['columns'])) {
            $params['columns'] = $this->getColumn;
        }

        return Admin::find($params)->toArray();
    }

    /**
     * @param array $params
     * @return array
     * @throws CustomException
     */
    public function getOne(array $params)
    {
        if (empty($params['columns'])) {
            $params['columns'] = $this->getColumn;
        }

        $admin = Admin::findFirst($params);
        if (!$admin) {
            error_exit(Code::GET_DATA_FAILED, ['field' => 'Admin']);
        }

        return $admin->toArray();
    }

    /**
     * @param int $id
     * @return Model
     * @throws CustomException
     */
    public function model(int $id){
        $admin = Admin::findFirst($id);
        if (!$admin) {
            error_exit(Code::GET_DATA_FAILED, ['field' => 'Admin']);
        }

        return $admin;
    }
}
