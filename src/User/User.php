<?php

namespace Anax\User;

use \Anax\Database\ActiveRecordModel;

/**
 * A database driven model.
 */
class User extends ActiveRecordModel
{

    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "RVIXaccount";

    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
     public $id;
     public $active;
     public $role;
     public $rank;
     public $username;
     public $pass;
     public $firstname;
     public $surname;
     public $email;
     public $notes;
     public $created;
     public $updated;
     public $deleted;
     public $address;
     public $postnumber;
     public $phone;
     public $mobile;
     public $inlogged;
     public $city;

    /**
     * Set the password.
     *
     * @param string $password the password to use.
     *
     * @return void
     */
    public function setPassword($password)
    {
        $this->pass = password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Verify the acronym and the password, if successful the object contains
     * all details from the database row.
     *
     * @param string $acronym  acronym to check.
     * @param string $password the password to use.
     *
     * @return boolean true if acronym and password matches, else false.
     */
    public function verifyPassword($acronym, $password)
    {
        $this->find("username", $acronym);
        return password_verify($password, $this->pass);
    }

    public function uniqueUser($acronym)
    {
        return $this->find('username', $acronym);
    }
}
