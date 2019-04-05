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
            Code::NOT_FOUND => "地址错误",
            Code::INVALID_TOKEN => "token无效",
            Code::INVALID_PARAMETER => "参数无效",
            Code::USER_LOGIN_ERROR => "账号或密码错误",
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