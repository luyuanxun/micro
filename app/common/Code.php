<?php

namespace App\Common;

class Code
{
    /**
     * 公用
     */
    const OK = 200;  //成功
    const NOT_FOUND = 404; //URL NOT_FOUND

    /**
     * 客户端错误40x开头：400xxx 401xxx
     */
    const INVALID_PARAMETER = 400000;

    /**
     * 服务端错误50x开头：500xxx 501xxx
     */
    //user 相关
    const USER_LOGIN_ERROR = 500000;


}