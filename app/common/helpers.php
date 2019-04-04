<?php

use App\Common\CodeMsg;
use App\Common\CustomException;

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
            $message = str_replace('{' . $k . '}', $v, $message);
        }
    } else {
        $message = empty($msg) ? CodeMsg::get($code) : $msg;
    }

    throw new CustomException($code, $message);
}

/**
 * 结果统计返回
 * @param $code
 * @param $msg
 * @param string $data
 */
function handleResult($code, $msg, $data = '')
{
    $response = new Phalcon\Http\Response();
    $response->setStatusCode(substr($code, 0, 3))->setContentType('text/json')->sendHeaders();
    echo json_encode(compact('code', 'msg', 'data'));
}