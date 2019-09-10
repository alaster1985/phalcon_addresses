<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 06.09.2019
 * Time: 15:34
 */

namespace App\Forms;

use App\Models\Users;
use Phalcon\Forms\Element\Numeric;
use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Select;

use Phalcon\Validation\Validator\Between;
use Phalcon\Validation\Validator\Numericality;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Callback;

class AddressForm extends Form
{
    public function initialize($entity = null, $options = [])
    {
        $userId = $options['userId'] ?? 1;
        $city = new Text(
            'city',
            [
                'class' => 'form-control',
                'placeholder' => 'Enter city name',
            ]
        );

        $city->addValidators([
            new PresenceOf(['message' => 'The city field is required']),
            new StringLength([
                'max' => 50,
                'min' => 3,
                'messageMaximum' => 'It is too long city name. Shorter please, max 50 characters',
                'messageMinimum' => 'It is too short city name. Min 3 characters',
                'includedMaximum' => true,
                'includedMinimum' => true,
            ]),
        ]);

        $postcode = new Numeric(
            'postcode',
            [
                'class' => 'form-control',
                'placeholder' => 'Enter postcode',
                'min' => 100000,
                'max' => 999999,
            ]
        );

        $postcode->addValidators([
            new PresenceOf(['message' => 'The postcode field is required']),
            new Numericality(["message" => ":field must be numeric"]),
            new StringLength([
                'max' => 6,
                'min' => 6,
                'messageMaximum' => 'Only 6 digits for postcode fieldx',
                'messageMinimum' => 'Only 6 digits for postcode fieldn',
                'includedMaximum' => true,
                'includedMinimum' => true,
            ]),
            new Between(
                [
                    "minimum" => 100000,
                    "maximum" => 999999,
                    "message" => "The postcode field must be unsigned, numeric value, consist of 6 digits",
                ]
            )
        ]);

        $region = new Text(
            'region',
            [
                'class' => 'form-control',
                'placeholder' => 'Enter region',
            ]
        );

        $region->addValidators([
            new PresenceOf(['message' => 'The region field is required']),
            new StringLength([
                'max' => 50,
                'min' => 3,
                'messageMaximum' => 'It is too long region. Shorter please, max 50 characters',
                'messageMinimum' => 'It is too short region. Min 3 characters',
                'includedMaximum' => true,
                'includedMinimum' => true,
            ]),
        ]);

        $street = new Text(
            'street',
            [
                'class' => 'form-control',
                'placeholder' => 'Enter street',
            ]
        );

        $street->addValidators([
            new PresenceOf(['message' => 'The street field is required']),
            new StringLength([
                'max' => 50,
                'min' => 3,
                'messageMaximum' => 'It is too long street. Shorter please, max 50 characters',
                'messageMinimum' => 'It is too short street. Min 3 characters',
                'includedMaximum' => true,
                'includedMinimum' => true,
            ]),
        ]);

        $user_id = new Select(
            'user_id',
            Users::find(["columns"=>"id, concat(firstName,' ',lastName) as fullName"]),
            [
                'using' => [
                    'id',
                    "fullName",
                ],
                'useEmpty' => false,
                'class' => 'custom-select',
                'value' => $userId
            ]
        );

        $user_id->addValidator(
            new Callback(
                [
                    "message" => "Nice try BRO ;) Please, use only current select. Tnx!",
                    "callback" => function ($data) {
                        if (!in_array($data['user_id'], Users::getColumns('id'))) {
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

        $this->add($city);
        $this->add($postcode);
        $this->add($region);
        $this->add($street);
        $this->add($user_id);
        $this->add($submit);
    }
}