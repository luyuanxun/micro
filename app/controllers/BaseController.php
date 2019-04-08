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

    /**
     * 获取参数
     */
    public function getParams()
    {
        $params = $this->request->get();
        $json = $this->request->getJsonRawBody(true);
        if ($json) {
            array_merge($params, $json);
        } elseif ($this->request->isPost()) {
            $params = array_merge($params, $this->request->getPost());
        } elseif ($this->request->isPatch() || $this->request->isPut()) {
            $params = array_merge($params, $this->request->getPut());
        }

        return $params;
    }
}
