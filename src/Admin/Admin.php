<?php

namespace Maaa16\Admin;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;
use \Anax\User\User;

/**
 * REM Server.
 */
class Admin implements InjectionAwareInterface
{
    use InjectionAwareTrait;

    public function getComments()
    {
        $this->di->get("db")->connect();
        $sql = "SELECT * FROM RVIXcomment";
        $res = $this->di->get("db")->executeFetchAll($sql);
        return $res;
    }

    public function getAccounts()
    {
        $this->di->get("db")->connect();
        $sql = "SELECT * FROM RVIXaccount";
        $res = $this->di->get("db")->executeFetchAll($sql);
        return $res;
    }

    public function getAccount($id)
    {
        $user = new User();
        $user->setDb($this->di->get("db"));
        $user->find("id", $id);

        return $user;
    }

    public function getContent()
    {
        $this->di->get("db")->connect();
        $sql = "SELECT * FROM RV1content";
        $res = $this->di->get("db")->executeFetchAll($sql);
        return $res;
    }

    public function getLastLoggedIn($id, $default)
    {
        $this->di->get("db")->connect();
        $sql = "SELECT inlogged FROM RVIXaccount WHERE id = ?";
        $params = [$id];
        $res = $this->di->get("db")->executeFetchAll($sql, $params);
        if ($res[0]->inlogged != null) {
            $result = $res[0]->inlogged;
        } else {
            $result = $default;
        }
        return $result;
    }

    public function getSingleAccount($id)
    {
        $this->di->get("db")->connect();
        $sql = "SELECT * FROM RVIXaccount WHERE id = ?";
        $params = [$id];
        // $res = $this->di->get("db")->executeFetchAll($sql, $params);
        return $this->di->get("db")->executeFetchAll($sql, $params);
    }

    public function editAccount($id, $userdata)
    {
        $this->di->get("db")->connect();
        $sql = "UPDATE RVIXaccount SET role = ?, active = ?, firstname = ?, surname = ?, email = ?, address = ?, postnumber = ?, city = ?, phone = ?, mobile = ?, notes = ? WHERE id = ?";
        $params = [$userdata['role'], $userdata['active'], $userdata["firstname"], $userdata["surname"], $userdata["email"], $userdata["address"], $userdata["postnumber"], $userdata["city"], $userdata["phone"], $userdata["mobile"], $userdata["notes"], $id];
        $this->di->get("db")->execute($sql, $params);

        $sql = "UPDATE RVIXaccount SET updated = CURRENT_TIMESTAMP WHERE id = ?";
        $params = [$id];
        $this->di->get("db")->execute($sql, $params);
    }

    public function resetPassword($id, $password)
    {
        $this->di->get("db")->connect();
        $securepass = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE RVIXaccount SET pass = ? WHERE id = ?";
        $params = [$securepass, $id];
        $this->di->get("db")->execute($sql, $params);
    }

    public function deleteAccount($id)
    {
        $this->di->get("db")->connect();
        $sql = "SELECT * FROM RVIXaccount WHERE id = ?";
        $params = [$id];
        $res = $this->di->get("db")->executeFetchAll($sql, $params);
        $username = $res[0]->username;

        $sql = "DELETE FROM RVIXaccount WHERE id = ?";
        $params = [$id];
        $this->di->get("db")->execute($sql, $params);

        // Måste kolla igenom alla jävla kommentarer för att se om den gillats.... skiter i det förresten.
        $sql = "SELECT * FROM RVIXcomment";
        $res = $this->di->get("db")->executeFetchAll($sql, $params);
        $remove = [$id];
        foreach ($res as $comment) {
            $likes = $comment->likes;
            $likes = explode(",", $likes);
            if (in_array($id, $likes)) {
                $likes = array_diff($likes, $remove);
                $likes = implode(",", $likes);
                $sql = "UPDATE RVIXcomment SET likes = ? WHERE id = ?";
                $params = [$likes, $comment->id];
                $this->di->get("db")->execute($sql, $params);
            }
        }

        $sql = "DELETE FROM RVIXcomment WHERE username = ?";
        $params = [$username];
        $this->di->get("db")->execute($sql, $params);
    }

    public function validatePasswordEdit($id, $userdata)
    {
        $db         = $this->di->get("db");
        $session    = $this->di->get("session");
        $isValid    = false;
        $user       = new User();

        //------------------------------

        $user->setDb($db);
        $user->find("id", $id);

        //------------------------------

        $currentpassword    = $user->pass;
        if (password_verify($userdata['oldpass'], $currentpassword)) {
            if ($userdata['newpassone'] == $userdata['newpasstwo']) {
                $isValid = true;
            } else {
                $msg = "Nya lösenordet matchade inte. Försök igen.";
                $session->set("usereditpassmsg", $msg);
            }
        } else {
            $msg = "Ditt nuvarande lösenord matchade inte. Försök igen.";
            $session->set("usereditpassmsg", $msg);
        }
        return $isValid;
    }
}
