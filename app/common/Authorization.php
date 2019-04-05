<?php


namespace App\Common;


use Exception;
use Firebase\JWT\JWT;
use Phalcon\Di;

class Authorization
{
    /**
     * 创建token
     * @param $jti
     * @return array
     */
    public static function createToken($jti)
    {
        $time = time();
        $expireTime = $time + Di::getDefault()->getConfig()->jwt->expire;
        $data = array(
            'iat' => $time,  //创建时间
            'exp' => $expireTime,//有效时间
            'jti' => $jti
        );

        $token = JWT::encode($data, Di::getDefault()->getConfig()->jwt->key);
        return compact('expireTime', 'token');
    }

    /**
     * 解析token
     * @param $auth
     * @return array
     * @throws CustomException
     */
    public static function check($auth)
    {
        $auth = explode(' ', $auth);
        if (count($auth) !== 2 || $auth[0] !== 'Bearer') {
            error_exit(Code::INVALID_TOKEN);
        }

        try {
            $ret = JWT::decode($auth[1], Di::getDefault()->getConfig()->jwt->key, array('HS256'));
            return (array)$ret;
        } catch (Exception $e) {
            error_exit(Code::FORBIDDEN, $e->getMessage());
        }

    }
}