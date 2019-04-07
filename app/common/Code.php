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
    const NOT_FOUND = 404; //URL地址错误
    const SERVER_ERROR = 500; //服务端错误

    /**
     * 客户端错误40x开头：400xxx 401xxx
     */
    //=============公用================
    const INVALID_TOKEN = 400000;//token无效
    const INVALID_PARAMETER = 400001;//参数无效
    const INVALID_ID = 400002;//ID无效

    /**
     * 服务端错误50x开头：500xxx 501xxx
     */
    //==============公用===============
    const LOGIN_ERROR = 500000;//登录失败
    const CREATE_FAILED = 500001;//创建失败
    const UPDATE_FAILED = 500002;//修改失败
    const DELETE_FAILED = 500003;//删除失败
    const GET_DATA_FAILED = 500004;//获取数据失败

    //===============user相关==================
    //500100


}