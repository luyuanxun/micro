<?php

use App\Common\CodeMsg;
use App\Common\CustomException;
use Phalcon\Crypt;

if (!function_exists('error_exit')) {
    /**
     * 错误退出
     * @param $code
     * @param $msg
     * @throws CustomException
     */
    function error_exit($code, $msg = '')
    {
        if (is_array($msg)) {
            $message = CodeMsg::get($code);
            foreach ($msg as $k => $v) {
                $message = str_replace(':' . $k . ':', $v, $message);
            }
        } else {
            $message = empty($msg) ? CodeMsg::get($code) : $msg;
        }

        throw new CustomException($code, $message);
    }
}


if (!function_exists('handleResult')) {
    /**
     * 结果统计返回
     * @param $code
     * @param $msg
     * @param array $data
     */
    function handleResult($code, $msg, $data = [])
    {
        $response = new Phalcon\Http\Response();
        $response->setStatusCode(substr($code, 0, 3))->setContentType('text/json')->sendHeaders();
        echo json_encode(compact('code', 'msg', 'data'));
        exit();
    }
}

if (!function_exists('handleCrypt')) {
    /**
     * 批量加密
     * @param Crypt $crypt
     * @param array $data
     * @param array $whiteList
     */
    function handleCryptBase64(Crypt $crypt, array &$data, array $whiteList)
    {
        if (empty($data)) {
            return;
        }

        foreach ($data as $k => &$v) {
            //分页数据跳过
            if ($k === 'pagination') {
                continue;
            }

            if (is_array($v) && !empty($v)) {
                handleCryptBase64($crypt, $v, $whiteList);
            } else {
                if (in_array($k, $whiteList)) {
                    $v = $crypt->encryptBase64(strval($v));
                }
            }
        }
    }
}