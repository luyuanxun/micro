<?php

namespace App\Controllers;

use Phalcon\Mvc\Controller;

class BaseController extends Controller
{
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
