<?php

namespace App\Controllers;

use Exception;
use App\Common\Code;
use Phalcon\Di;
use Phalcon\Mvc\Controller;
use App\Common\CustomException;

class BaseController extends Controller
{
    /**
     * 获取用户Id
     * @throws CustomException
     */
    public function getUserId()
    {
        try {
            $auth = Di::getDefault()->getService('auth')->getDefinition();
            $userId = $auth['jti'];
            return compact('userId');
        } catch (Exception $e) {
            error_exit(Code::UNAUTHORIZED);
        }
    }
}
