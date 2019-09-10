<?php

use App\Models\Users;

class IndexController extends ControllerBase
{

    public function indexAction()
    {
//        $new = new SeederController();
//        $new->seeding();
        $this->view->users = Users::find();
    }

    public function index404Action()
    {

    }

    public function index503Action()
    {

    }

}

