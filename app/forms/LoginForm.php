<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 06.09.2019
 * Time: 15:35
 */

namespace App\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Text;

use Phalcon\Validation\Validator\PresenceOf;

class LoginForm extends Form
{
    public function initialize()
    {
        $email = new Text(
            'email',
            [
                'class' => 'form-control',
                'placeholder' => 'Enter your email',
            ]
        );

        $email->addValidators([
            new PresenceOf(['message' => 'The email field is required']),
        ]);

        $password = new Password(
            'password',
            [
                'class' => 'form-control',
                'placeholder' => 'Enter password',
            ]
        );

        $password->addValidator(
            new PresenceOf(['message' => 'The password is required'])
        );

        $submit = new Submit(
            'Login',
            [
                'class' => 'btn btn-primary',
            ]
        );

        $this->add($email);
        $this->add($password);
        $this->add($submit);
    }
}