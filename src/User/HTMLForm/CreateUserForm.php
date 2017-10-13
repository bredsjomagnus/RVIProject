<?php

namespace Anax\User\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \Anax\User\User;

/**
 * Example of FormModel implementation.
 */
class CreateUserForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Anax\DI\DIInterface $di a service container
     */
    public function __construct(DIInterface $di)
    {
        parent::__construct($di);

        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Skapa konto",
            ],
            [
                "username" => [
                    "label"       => "Användarnamn",
                    "type"        => "text",
                    "class"       => "form-control"
                ],

                "password" => [
                    "label"       => "Lösenord",
                    "type"        => "password",
                    "class"       => "form-control"
                ],

                "password-again" => [
                    "label"       => "Upprepa lösenord",
                    "type"        => "password",
                    "validation" => [
                        "match" => "password"
                    ],
                    "class"       => "form-control"
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Skapa konto",
                    "class"     => "btn btn-primary",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
    }

    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return boolean true if okey, false if something went wrong.
     */
    public function callbackSubmit()
    {
        // Get values from the submitted form
        $acronym       = $this->form->value("username");
        $password      = $this->form->value("password");
        $passwordAgain = $this->form->value("password-again");

        // Check password matches
        if ($password !== $passwordAgain) {
            $this->form->rememberValues();
            $this->form->addOutput("Password did not match.");
            return false;
        }

        // samma som nedan fast med active record
        $user = new User();
        $user->setDb($this->di->get("db"));
        $res = $user->uniqueUser($acronym);
        if (!$res) {
            $user->setDb($this->di->get("db"));
            $user->username = $acronym;
            $user->firstname = 'anon';
            $user->surname = 'anon';
            $user->role = 'user';
            $user->email = 'anon@anon.se';
            $user->setPassword($password);
            $user->save();
        } else {
            $this->form->addOutput("Användarnamet redan knutet till existerande konto");
            return false;
        }



        // Save to database
        // $db = $this->di->get("db");
        // $password = password_hash($password, PASSWORD_DEFAULT);
        // $db->connect()
        //    ->insert("RVDBaccounts", ["username", "pass"])
        //    ->execute([$acronym, $password]);
        $this->di->get("response")->redirect("user/login");
        $this->form->addOutput("User was created.");
        return true;
    }
}
    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return boolean true if okey, false if something went wrong.
     */
    // public function callbackSubmit()
    // {
    //     // These return a single value
    //     // Type checkbox returns true if checked
    //     $elements = [
    //         // HTML401.
    //         "text", "password", "hidden", "file", "textarea", "select",
    //         "radio", "checkbox",
    //         // HTML5
    //         "color", "date", "datetime", "datetime-local", "time",
    //         "week", "month", "number", "range", "search", "tel",
    //         "email", "url", "file-multiple",
    //     ];
    //     foreach ($elements as $name) {
    //         $this->form->addOutput(
    //             "$name has value: "
    //             . $this->form->value($name)
    //             . "</br>"
    //         );
    //     }
    //
    //     // Select multiple returns an array
    //     $elements = [
    //         "selectm",
    //     ];
    //     foreach ($elements as $name) {
    //         $this->form->addOutput(
    //             "$name has value: "
    //             . implode($this->form->value($name), ", ")
    //             . "</br>"
    //         );
    //     }
    //
    //     // Remember values during resubmit, useful when failing (retunr false)
    //     // and asking the user to resubmit the form.
    //     $this->form->rememberValues();
    //
    //     return true;
    // }
