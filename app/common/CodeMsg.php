<?php

namespace App\Common;

class CodeMsg
{
    /**
     * 定义消息
     * @return array
     */
    private static function getAll()
    {
        return [
            Code::OK => "SUCCESS",
            Code::UNAUTHORIZED => "未经授权的",
            Code::FORBIDDEN => "禁止访问",
            Code::NOT_FOUND => "URL地址错误",
            Code::SERVER_ERROR => "服务端错误",
            Code::INVALID_TOKEN => "token无效",
            Code::INVALID_PARAMETER => "参数无效",
            Code::INVALID_ID => "ID无效",
            Code::LOGIN_ERROR => "账号或密码错误",
            Code::CREATE_FAILED => "创建失败",
            Code::UPDATE_FAILED => "修改失败",
            Code::DELETE_FAILED => "删除失败",
            Code::GET_DATA_FAILED => "获取:field:数据失败",
        ];
    }

    /**
     * 根据code获取信息
     * @param $code
     * @return mixed|string
     */
    public static function get($code)
    {
        $all = self::getAll();
        return $all[$code] ?? '';
    }
}