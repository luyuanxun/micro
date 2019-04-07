<?php

namespace App\Controllers;

use Exception;
use App\Common\Code;
use Phalcon\Mvc\Controller;
use App\Common\CustomException;

class BaseController extends Controller
{
    /**
     * 获取用户Id
     * @return array
     * @throws CustomException
     */
    public function getUserId()
    {
        try {
            $auth = $this->di->getService('auth')->getDefinition();
            return ['id' => $auth['id']];
        } catch (Exception $e) {
            error_exit(Code::UNAUTHORIZED);
        }
    }
}
