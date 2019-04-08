<?php

namespace App\Common;

use Exception;
use Firebase\JWT\JWT;
use Phalcon\Di;
use Phalcon\Http\Request;

class Authorization
{
    /**
     * 创建token
     * @param $id
     * @return array
     */
    public static function createToken($id)
    {
        $config = Di::getDefault()->get('config');
        $time = time();
        $expireTime = $time + $config->jwt->expire;
        $data = array(
            'iat' => $time,  //创建时间
            'exp' => $expireTime,//有效时间
            'id' => $id
        );

        $token = JWT::encode($data, $config->jwt->key);
        return compact('expireTime', 'token');
    }

    /**
     * 解析token
     * @return array
     * @throws CustomException
     */
    public static function analyzeToken()
    {
        $request = new Request();
        $auth = explode(' ', $request->getHeader('Authorization'));
        if (count($auth) !== 2 || $auth[0] !== 'Bearer') {
            error_exit(Code::INVALID_TOKEN);
        }

        try {
            $jwtKey = Di::getDefault()->get('config')->jwt->key;
            $ret = (array)JWT::decode($auth[1], $jwtKey, array('HS256'));
        } catch (Exception $e) {
            error_exit(Code::FORBIDDEN, $e->getMessage());
        }

        return $ret ?? [];
    }
}