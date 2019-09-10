<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 08.09.2019
 * Time: 9:21
 */

use App\Forms\AddressForm;
use App\Models\Users;

class AddressController extends ControllerBase
{
    public function indexAction()
    {
        if ($this->isAdmin()) {
            $users = Users::find();
            $this->view->users = $users;
        }
    }

    public function indexUserAction($userId)
    {
        $user = Users::findFirst($userId);
        $allUsers = Users::find();
        $form = new AddressForm(null, ['userId' => $userId]);
        if ($user) {
            $addressesByUserId = $user->addresses;
            $this->view->setVars([
                'addresses' => $addressesByUserId,
                'user' => $user,
                'allUser' => $allUsers,
                'form' => $form,
            ]);
        } else {
            $this->flashSession->error('There is no such user you try to find');
            return $this->response->redirect('/');
        }
    }

    public function addAddressAction()
    {
        $form = new AddressForm();
        $address = new Addresses();

        if ($this->request->isPost()) {
            $addressArrData = [
                'city' => $this->request->getPost('city', ['trim']),
                'postcode' => $this->request->getPost('postcode', ['trim']),
                'region' => $this->request->getPost('region', ['trim']),
                'street' => $this->request->getPost('street', ['trim']),
                'user_id' => $this->request->getPost('user_id', ['trim']),
            ];
        } else {
            $this->flashSession->error('It is no post request');
            return $this->response->redirect($this->request->getHTTPReferer());
        }

        if (!$this->security->checkToken()) {
            $this->flashSession->error('invalid token');
            return $this->response->redirect($this->request->getHTTPReferer());
        }

        $form->bind($addressArrData, $address);
        if (!$form->isValid($addressArrData)) {
            $messages = $form->getMessages();
            foreach ($messages as $message) {
                $this->flashSession->error($message);
            }
            return $this->response->redirect($this->request->getHTTPReferer());
        }

        $success = $address->save();
        if (!$success) {
            $messages = $address->getMessages();
            foreach ($messages as $message) {
                $this->flashSession->error($message);
            }
            return $this->response->redirect($this->request->getHTTPReferer());
        }
        $this->flashSession->success('New address has been added!');
        return $this->response->redirect('address/user/' . $addressArrData['user_id']);
    }

    public function deleteAction($addressId)
    {
        $address = Addresses::findFirst($addressId);
        if (!$address) {
            $this->flashSession->error('Invalid address ID');
            return $this->response->redirect($this->request->getHTTPReferer());
        }
        if (!$address->delete()){
            foreach ($address->getMessages() as $message) {
                $this->flashSession->error($message);
            }
            return $this->response->redirect($this->request->getHTTPReferer());
        } else {
            $this->flashSession->success('Address was deleted!');
            return $this->response->redirect($this->request->getHTTPReferer());
        }
    }

    public function ajaxAction()
    {
        if ($this->request->isPost()) {
            if ($this->request->isAjax()) {
                $userId = $this->request->getPost('userId');
            }
        }
        if (!$this->isAdmin()) {
            $userId = 0;
        }
        if ($userId == 0) {
            $addresses = Addresses::find()->toArray();
        } else {
            $addresses = Addresses::findByUser_id($userId)->toArray();
        }
        foreach ($addresses as $key => $address) {
            $addresses[$key]['user'] = Users::findFirst($address['user_id'])->getFullName();
        }
        return json_encode($addresses);
    }
}