<?php

namespace App\Models;

use App\Common\Code;
use App\Common\CustomException;
use Phalcon\Mvc\Model;

class User extends Base
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $username;

    /**
     *
     * @var string
     */
    public $password;

    /**
     *
     * @var integer
     */
    public $status;

    /**
     *
     * @var string
     */
    public $createTime;

    /**
     *
     * @var string
     */
    public $updateTime;

    /**
     *
     * @var integer
     */
    public $isDeleted;

    /**
     * 允许显示的字段
     * @var array
     */
    public $getColumn = ['id', 'username', 'status', 'createTime', 'updateTime', 'isDeleted'];

    /**
     * 允许创建|修改字段
     * @var array
     */
    public $saveColumn = ['username', 'password'];

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        parent::initialize();
        $this->setSchema("phalcon");
        $this->setSource("user");
    }

    /**
     * Returns table name mapped in the model.
     * @return string
     */
    public function getSource()
    {
        return 'user';
    }

    /**
     * 处理更新时间
     */
    public function beforeSave()
    {
        $this->updateTime = date('Y-m-d H:i:s');
    }

    /**
     * 字段转驼峰
     * @return array
     */
    public function columnMap()
    {
        return [
            'id' => 'id',
            'username' => 'username',
            'password' => 'password',
            'status' => 'status',
            'create_time' => 'createTime',
            'update_time' => 'updateTime',
            'is_deleted' => 'isDeleted',
        ];
    }

    /**
     * @param $params
     * @return mixed
     */
    public function getCount($params)
    {
        return User::count($params);
    }

    /**
     * @param $params
     * @return array
     */
    public function getAll($params)
    {
        if (empty($params['columns'])) {
            $params['columns'] = $this->getColumn;
        }

        return User::find($params)->toArray();
    }

    /**
     * @param $params
     * @return array
     * @throws CustomException
     */
    public function getOne($params)
    {
        if (empty($params['columns'])) {
            $params['columns'] = $this->getColumn;
        }

        $user = User::findFirst($params);
        if (!$user) {
            error_exit(Code::GET_DATA_FAILED, ['field' => 'User']);
        }

        return $user->toArray();
    }

    /**
     * @param $id
     * @return Model
     * @throws CustomException
     */
    public function model($id){
        $user = User::findFirst($id);
        if (!$user) {
            error_exit(Code::GET_DATA_FAILED, ['field' => 'User']);
        }

        return $user;
    }
}
