<?php

namespace App\Services;

use \App\Common\Code;
use \Firebase\JWT\JWT;

class UserService
{
    /**
     * 登录
     * @param $name
     * @param $password
     * @return string
     * @throws \App\Common\CustomException
     */
    public static function login($name, $password)
    {
        if ($name == 'demo' && $password == '123456') {
            $key = "example_key";
            $data = array(
                "iss" => "http://example.org",
                "aud" => "http://example.com",
                "iat" => 1356999524,
                "nbf" => 1357000000
            );

            return JWT::encode($data, $key);
        } else {
            error_exit(Code::USER_LOGIN_ERROR);
        }
    }
}