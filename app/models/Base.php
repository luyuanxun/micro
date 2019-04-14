<?php


namespace App\Models;

use Phalcon\Mvc\Model;

/**
 * model基础类：
 * model使用请参考文档：https://docs.phalconphp.com/3.4/zh-cn/db-models
 * Class Base
 * @package App\Models
 */
abstract class Base extends Model
{
    /**
     * 统计总数
     * @param array $params
     * @return array
     */
    abstract function getCount(array $params);

    /**
     * 获取所有数据
     * @param array $params
     * @return array
     */
    abstract function getAll(array $params);

    /**
     * 读写分离
     * master-slave architecture
     */
    public function initialize()
    {
        $this->setReadConnectionService('dbSlave');
        $this->setWriteConnectionService('dbMaster');
    }

    /**
     * 获取列表
     * @param int $page
     * @param int $pageSize
     * @param array $params
     * @return array
     */
    public function getList(int $page, int $pageSize, array $params = [])
    {
        $pageCount = $this->getCount($params);
        $params = array_merge($params, [
            'offset' => ($page - 1) * $pageSize,
            'limit' => $pageSize
        ]);

        $list = $this->getAll($params);
        $pagination = compact('page', 'pageSize', 'pageCount');
        return compact('pagination', 'list');
    }
}