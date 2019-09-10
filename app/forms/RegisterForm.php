<?php

namespace App\Forms;

use App\Models\Types;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Select;

use Phalcon\Validation\Validator\Confirmation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Callback;

class RegisterForm extends Form
{
    public function initialize()
    {
        $firstName = new Text(
            'firstName',
            [
                'class' => 'form-control',
                'placeholder' => 'Enter your first name',
            ]
        );

        $firstName->addValidators([
            new PresenceOf(['message' => 'The first name field is required']),
            new StringLength([
                'max' => 50,
                'min' => 2,
                'messageMaximum' => 'It is too long name. Shorter please, max 50 characters',
                'messageMinimum' => 'It is too short name. Min 2 characters',
                'includedMaximum' => true,
                'includedMinimum' => true,
            ]),
        ]);

        $lastName = new Text(
            'lastName',
            [
                'class' => 'form-control',
                'placeholder' => 'Enter your last name',
            ]
        );

        $lastName->addValidators([
            new PresenceOf(['message' => 'The last name field is required']),
            new StringLength([
                'max' => 50,
                'min' => 2,
                'messageMaximum' => 'It is too long name. Shorter please, max 50 characters',
                'messageMinimum' => 'It is too short name. Min 2 characters',
                'includedMaximum' => true,
                'includedMinimum' => true,
            ]),
        ]);

        $email = new Text(
            'email',
            [
                'class' => 'form-control',
                'placeholder' => 'Enter your email',
            ]
        );

        $email->addValidators([
            new PresenceOf(['message' => 'The email field is required']),
            new Email(['message' => 'The email field is invalid'])
        ]);

        $password = new Password(
            'password',
            [
                'class' => 'form-control',
                'placeholder' => 'Enter password',
            ]
        );

        $password->addValidators([
            new PresenceOf(['message' => 'The password is required']),
            new StringLength([
                'max' => 50,
                'min' => 5,
                'messageMaximum' => 'It is too long password. Shorter please, max 50 characters',
                'messageMinimum' => 'It is too short password. Min 5 characters',
                'includedMaximum' => true,
                'includedMinimum' => true,
            ]),
            new Confirmation([
                "message" => "Password doesn't match confirmation",
                "with" => "confirmPassword",
            ])
        ]);

        $confirmPassword = new Password(
            'confirmPassword',
            [
                'class' => 'form-control',
                'placeholder' => 'Confirm password',
            ]
        );

        $confirmPassword->addValidator(
            new PresenceOf(['message' => 'The confirm password field is required'])
        );

        $type_id = new Select(
            'type_id',
            Types::find(),
            [
                'using' => [
                    'id',
                    'type',
                ],
                'useEmpty' => false,
                'class' => 'custom-select',
            ]
        );

        $type_id->addValidator(
            new Callback(
                [
                    "message" => "Nice try BRO ;) Please, use only current select. Tnx!",
                    "callback" => function ($data) {
                        if (!in_array($data['type_id'], Types::getColumns('id'))) {
                            return false;
                        }
                        return true;
                    }
                ]
            )
        );

        $submit = new Submit(
            'Submit',
            [
                'class' => 'btn btn-primary',
            ]
        );

        $this->add($firstName);
        $this->add($lastName);
        $this->add($email);
        $this->add($password);
        $this->add($confirmPassword);
        $this->add($type_id);
        $this->add($submit);
    }
}