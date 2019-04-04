<?php

namespace App\Controllers;

use App\Common\Code;

class TestController extends BaseController
{
    /**
     * 返回数组
     * @return array
     */
    public function index()
    {
        $data = [
            'title' => 'phalcon micro demo',
            'version' => '1.0',
        ];

        return $data;
    }

    /**
     * 错误退出
     * @throws \App\Common\CustomException
     */
    public function error()
    {
        error_exit(Code::INVALID_PARAMETER);
    }
}

