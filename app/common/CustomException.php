<?php

namespace App\Common;
use Phalcon\Exception;

/**
 * 自定义异常
 * Class CustomException
 * @package App\Common
 */
class CustomException extends Exception
{
    public function __construct($code, $msg)
    {
        parent::__construct($msg, $code);
    }
}
