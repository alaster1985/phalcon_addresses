<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    public function isLoggedIn()
    {
        return $this->session->has('AUTH_USER') ? true : false;
    }

    public function isAdmin()
    {
        if ($this->isLoggedIn()) {
            $typeId = \App\Models\Users::findFirst($this->session->get('AUTH_USER'))->type_id;
            return $typeId == 1 ? true : false;
        }
        return false;
    }
}
