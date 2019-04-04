<?php

namespace App\Common;

class CustomException extends \Exception
{
    public function __construct($code, $msg)
    {
        parent::__construct($msg, $code);
    }
}
