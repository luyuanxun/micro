<?php

namespace App\Common;

class Code
{
    /**
     * 公用
     */
    const OK = 200;  //成功
    const UNAUTHORIZED = 401;//未经授权的
    const FORBIDDEN = 403;//禁止访问
    const NOT_FOUND = 404; //URL NOT_FOUND

    /**
     * 客户端错误40x开头：400xxx 401xxx
     */
    const INVALID_TOKEN = 400001;//token无效
    const INVALID_PARAMETER = 400000;//参数无效

    /**
     * 服务端错误50x开头：500xxx 501xxx
     */
    //===============user相关==================
    //登录失败
    const USER_LOGIN_ERROR = 500000;


}