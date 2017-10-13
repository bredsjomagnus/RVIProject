<?php

namespace Anax\User\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \Anax\User\User;

/**
 * Example of FormModel implementation.
 */
class UserLoginForm extends FormModel
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
                "legend" => "Logga in"
            ],
            [
                "user" => [
                    "label"       => "Användarnamn",
                    "type"        => "text",
                    "class"       => "form-control"
                    //"description" => "Here you can place a description.",
                    //"placeholder" => "Here is a placeholder",
                ],

                "password" => [
                    "label"       => "Lösenord",
                    "type"        => "password",
                    "class"       => "form-control"
                    //"description" => "Here you can place a description.",
                    //"placeholder" => "Here is a placeholder",
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Login",
                    "class"       => "btn btn-primary",
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
        $acronym       = $this->form->value("user");
        $password      = $this->form->value("password");


        // samma som nedan fast med acitve record
        $user = new User();
        $user->setDb($this->di->get("db"));
        $res = $user->verifyPassword($acronym, $password);

        if (!$res) {
            $this->form->rememberValues();
            $this->form->addOutput("User or password did not match.");
            return false;
        }



        // Try to login
        // $db = $this->di->get("db");
        // $db->connect();
        // $user = $db->select("password")
        //            ->from("User")
        //            ->where("acronym = ?")
        //            ->executeFetch([$acronym]);
        //
        // // $user is false if user is not found
        // if (!$user || !password_verify($password, $user->password)) {
        //    $this->form->rememberValues();
        //    $this->form->addOutput("User or password did not match.");
        //    return false;
        // }

        $this->form->addOutput("User logged in.");
        $this->di->get("session")->set("user", $acronym);
        // $this->di->get("session")->set("email", $email);
        $this->di->get("session")->set("role", $user->role);
        // $this->di->get("cookie")->set("user", $username);
        // $this->di->get("session")->set("userid", $this->di->get("database")->lastInsertId());
        // $this->di->get("cookie")->set("forname", $forname);
        $this->di->get("cookie")->set("user", $acronym);
        $this->di->get("response")->redirect("user/accountinfo");
        return true;
    }


    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return boolean true if okey, false if something went wrong.
     */
    // public function callbackSubmit()
    // {
    //     $this->form->addOutput(
    //         "Trying to login as: "
    //         . $this->form->value("user")
    //         . "<br>Password is kept a secret..."
    //         //. $this->form->value("password")
    //     );
    //
    //     // Remember values during resubmit, useful when failing (retunr false)
    //     // and asking the user to resubmit the form.
    //     $this->form->rememberValues();
    //
    //     return true;
    // }
}
