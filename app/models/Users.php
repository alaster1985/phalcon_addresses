<?php

namespace App\Models;

use Phalcon\Validation;
use Phalcon\Validation\Validator\Email as EmailValidator;
use Phalcon\Validation\Validator\Uniqueness as Uniqueness;

class Users extends BaseModel
{

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var string
     */
    protected $firstName;

    /**
     *
     * @var string
     */
    protected $lastName;

    /**
     *
     * @var string
     */
    protected $email;

    /**
     *
     * @var string
     */
    protected $password;

    /**
     *
     * @var integer
     */
    protected $type_id;

    /**
     * Method to set the value of field id
     *
     * @param integer $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Method to set the value of field firstname
     *
     * @param string $firstname
     * @return $this
     */
    public function setFirstname($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Method to set the value of field lastname
     *
     * @param string $lastname
     * @return $this
     */
    public function setLastname($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Method to set the value of field email
     *
     * @param string $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Method to set the value of field password
     *
     * @param string $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Method to set the value of field type_id
     *
     * @param integer $type_id
     * @return $this
     */
    public function setTypeId($type_id)
    {
        $this->type_id = $type_id;

        return $this;
    }

    /**
     * Returns the value of field id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the value of field firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstName;
    }

    /**
     * Returns the value of field lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastName;
    }

    /**
     * Returns the value of field email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Returns the value of field password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Returns the value of field type_id
     *
     * @return integer
     */
    public function getTypeId()
    {
        return $this->type_id;
    }

    /**
     * Validations and business logic
     *
     * @return boolean
     */
    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            'email',
            new EmailValidator([
                'model' => $this,
                'message' => 'Please enter a correct email address',
            ])
        );

        $validator->add(
            'email',
            new Uniqueness([
                'model' => $this,
                'message' => 'This email is already in use. Please use another email',
                'cancelOnFail' => true,
            ])
        );

        return $this->validate($validator);
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("phalconttdb");
        $this->setSource("users");
        $this->hasMany('id', 'Addresses', 'user_id', ['alias' => 'Addresses']);
        $this->belongsTo('type_id', 'Types', 'id', ['alias' => 'Types']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'users';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Users[]|Users|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Users|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    /**
     * Independent Column Mapping.
     * Keys are the real names in the table and the values their names in the application
     *
     * @return array
     */
    public function columnMap()
    {
        return [
            'id' => 'id',
            'firstname' => 'firstName',
            'lastname' => 'lastName',
            'email' => 'email',
            'password' => 'password',
            'type_id' => 'type_id',
        ];
    }

    public function getFullName()
    {
        return $this->firstName . ' ' . $this->lastName;
    }
}
