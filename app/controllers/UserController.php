<?php

use App\Models\Users;

use App\Forms\RegisterForm;
use App\Forms\LoginForm;

class UserController extends ControllerBase
{

    public function indexAction()
    {
    }

    public function indexRegisterAction()
    {
        $this->view->form = new RegisterForm();
    }

    public function submitRegisterAction()
    {
        $form = new RegisterForm();
        $user = new Users();

        if ($this->request->isPost()) {
            $userArrData = [
                'firstName' => $this->request->getPost('firstName', ['trim', 'string']),
                'lastName' => $this->request->getPost('lastName', ['trim', 'string']),
                'email' => $this->request->getPost('email', ['trim', 'email']),
                'password' => $this->request->getPost('password', ['trim']),
                'confirmPassword' => $this->request->getPost('confirmPassword', ['trim']),
                'type_id' => $this->request->getPost('type_id', ['trim', 'int']),
            ];
        } else {
            $this->flashSession->error('It is no post request');
            return $this->response->redirect('user/register');
        }

        $form->bind($userArrData, $user);
        if (!$form->isValid($userArrData)) {
            $messages = $form->getMessages();
            foreach ($messages as $message) {
                $this->flashSession->error($message);
                $this->dispatcher->forward(
                    [
                        'controller' => $this->router->getControllerName(),
                        'action' => 'indexRegister',
                    ]
                );
            }
            return false;
        }

        $user->setPassword($this->security->hash($userArrData['password']));

        $success = $user->save();
        if (!$success) {
            $messages = $user->getMessages();
            foreach ($messages as $message) {
                $this->flashSession->error($message);
                $this->dispatcher->forward(
                    [
                        'controller' => $this->router->getControllerName(),
                        'action' => 'indexRegister',
                    ]
                );
            }
            return false;
        }
        $this->flashSession->success('Thanks for registering!');
        return $this->response->redirect('user/register');
//        $this->view->disable();
    }

    public function indexLoginAction()
    {
        $this->view->form = new LoginForm();
    }

    public function submitLoginAction()
    {
        $form = new LoginForm();
        $userLogin = new Users();

        if (!$this->request->isPost()) {
            $this->flashSession->error('It is no post request');
            return $this->response->redirect('user/register');
        }

        $loginData = [
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
        ];

        if (!$this->security->checkToken()) {
            $this->flashSession->error('invalid token');
            return $this->response->redirect('user/indexLogin');
        }
        $form->bind($loginData, $userLogin);
        if (!$form->isValid()) {
            $messages = $form->getMessages();
            foreach ($messages as $message) {
                $this->flashSession->error($message);
                $this->dispatcher->forward(
                    [
                        'controller' => $this->router->getControllerName(),
                        'action' => 'indexLogin',
                    ]
                );
            }
            return false;
        }

        $user = Users::findFirstByEmail($loginData['email']);

        if ($user) {
            if ($this->security->checkHash($loginData['password'], $user->password)) {
                $this->session->set('AUTH_USER', $user->id);
                $this->flashSession->success('You are logged in!');
                return $this->response->redirect('/');
            }
        } else {
            $this->security->hash(rand());
        }
        $this->flashSession->error('Incorrect password. Try again');
        return $this->response->redirect('user/indexLogin');
    }

    public function logoutAction()
    {
        $this->session->destroy();
        return $this->response->redirect('user/indexLogin');
    }

}
