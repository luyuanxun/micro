<?php

namespace App\Services;

use App\Common\Code;
use App\Common\Constant;
use Lyx\Micro\Tools\CustomException;
use App\Models\Article;

/**
 * Class ArticleService
 * @package App\Services
 */
class ArticleService
{
    /**
     * @var Article
     */
    public $article;

    /**
     * 初始化
     */
    public function __construct()
    {
        $this->article = new Article();
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
        return $this->article->getList($page, $pageSize);
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

        return $this->article->getOne($data);
    }

    /**
     * 创建
     * @param array $params
     * @throws CustomException
     */
    public function create(array $params)
    {
        $ret = $this->article->create($params, $this->article->saveColumn);
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
        $ret = $this->article->model($params['id'])->update($params, $this->article->saveColumn);
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
        $ret = $this->article->model($params['id'])->delete();
        if (!$ret) {
            error_exit(Code::DELETE_FAILED);
        }
    }
}