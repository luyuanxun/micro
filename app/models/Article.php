<?php

namespace App\Models;

use App\Common\Code;
use Lyx\Micro\Tools\CustomException;
use Phalcon\Mvc\Model;

class Article extends Base
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $addedDate;

    /**
     * @var string
     */
    public $editedDate;

    /**
     * @var integer
     */
    public $isDeleted;

    /**
     * @var integer
     */
    public $status;

    /**
     * 允许显示的字段
     * @var array
     */
    public $getColumn = ['id', 'title', 'addedDate', 'editedDate', 'isDeleted', 'status'];

    /**
     * 允许创建|修改字段
     * @var array
     */
    public $saveColumn = ['title', 'addedDate', 'editedDate', 'isDeleted', 'status'];

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        parent::initialize();
        $this->setSchema("phalcon");
        $this->setSource("article");
    }

    /**
     * Returns table name mapped in the model.
     * @return string
     */
    public function getSource()
    {
        return 'article';
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
            'title' => 'title',
            'addedDate' => 'addedDate',
            'editedDate' => 'editedDate',
            'is_deleted' => 'isDeleted',
            'status' => 'status',
        ];
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function getCount(array $params)
    {
        return Article::count($params);
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

        return Article::find($params)->toArray();
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

        $article = Article::findFirst($params);
        if (!$article) {
            error_exit(Code::GET_DATA_FAILED, ['field' => 'Article']);
        }

        return $article->toArray();
    }

    /**
     * @param int $id
     * @return Model
     * @throws CustomException
     */
    public function model(int $id){
        $article = Article::findFirst($id);
        if (!$article) {
            error_exit(Code::GET_DATA_FAILED, ['field' => 'Article']);
        }

        return $article;
    }
}
