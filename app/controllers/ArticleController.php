<?php

namespace App\Controllers;

use Lyx\Micro\Tools\CustomValidation;
use Lyx\Micro\Tools\CustomException;
use App\Services\ArticleService;

/**
 * Class ArticleController
 * @package App\Controllers
 */
class ArticleController extends BaseController
{
    /**
     * @var ArticleService
     */
    public $articleService;

    /**
     * 初始化
     */
    public function onConstruct()
    {
        $this->articleService = new ArticleService();
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
        return $this->articleService->getList($params);
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
        return $this->articleService->getInfo($params);
    }

    /**
     * 创建
     * @throws CustomException
     */
    public function create()
    {
        $rules = [
            'title' => 'required|strLen:1,150',
            'addedDate' => 'required|date:Y-m-d H:i:s',
            'editedDate' => 'required|date:Y-m-d H:i:s',
            'isDeleted' => 'required|num',
            'status' => 'required|num',
        ];

        $params = CustomValidation::validate($this->getParams(), $rules);
        $this->articleService->create($params);
    }

    /**
     * 修改
     * @throws CustomException
     */
    public function update()
    {
        $rules = [
            'id' => 'required|strLen:24',
            'title' => 'required|strLen:1,150',
            'addedDate' => 'required|date:Y-m-d H:i:s',
            'editedDate' => 'required|date:Y-m-d H:i:s',
            'isDeleted' => 'required|num',
            'status' => 'required|num',
        ];

        $params = CustomValidation::validate($this->getParams(), $rules);
        $this->articleService->update($params);
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
        $this->articleService->delete($params);
    }
}

