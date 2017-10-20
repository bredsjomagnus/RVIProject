<?php

namespace Maaa16\Login;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;

/**
 * A controller for the Commentary.
 *
 * @SuppressWarnings(PHPMD)
 */
class LoginController implements InjectionAwareInterface
{
    use InjectionAwareTrait;

    /**
    * Index redirect.
    *
    * @return void
    */
    public function getHome()
    {
        $this->di->get("response")->redirect("commentary/overview");
    }

    /**
    * Loginpage.
    *
    * @return void
    */
    public function loginpage()
    {
        $this->di->get("view")->add("login/login");
        $title = "Login | maaa16";
        $this->di->get("pageRender")->renderPage(["title" => $title]);
    }

    /**
    * Loginprocess
    *
    * @return void
    */
    public function loginProcess()
    {
        if (null != $this->di->get("request")->getPost("loginsubmit")) {
            $userdone = true;
            $passdone = true;
            // $passdone = false;
            if ($this->di->get("request")->getPost('user') == "") {
                $this->di->get("session")->set("usermsg", "&nbsp;&nbsp;&nbsp; Måste fylla i användarnamn");
                $userdone = false;
            }
            if ($this->di->get("request")->getPost('pass') == "") {
                $this->di->get("session")->set("passmsg", "&nbsp;&nbsp;&nbsp;* Måste fylla i lösenord");
                $passdone = false;
            }
            if ($userdone && $passdone) {
                $loginuser =  htmlentities($this->di->get("request")->getPost("user"));
                $loginpass =  htmlentities($this->di->get("request")->getPost("pass"));
                $this->di->get("db")->connect();
                $sql = "SELECT * FROM RVIXaccount WHERE BINARY username = BINARY '$loginuser'";
                if ($res = $this->di->get("db")->executeFetchAll($sql)) {
                    $dbpass = $res[0]->pass;
                    $this->di->get("session")->set("loginmsg", "<span>kommer åt databasen vid inloggningsförsök</span>");
                    $passwordverify = /** @scrutinizer ignore-call */ password_verify($loginpass, $dbpass);
                    if ($res[0]->active != 'yes') {
                        $this->di->get("session")->set("loginmsg", "<span class='formerror'>&nbsp;&nbsp;&nbsp; Konto deaktiverat av administratör.</span>");
                    } else if ($passwordverify) {
                        // $this->di->get("session")->set("user", $loginuser);
                        // $this->di->get("session")->set("user", "fiskmås");

                        $this->di->get("session")->set("user", $loginuser);
                        $this->di->get("session")->set("role", $res[0]->role);
                        $this->di->get("session")->set("email", $res[0]->email);
                        $this->di->get("session")->set("userid", $res[0]->id);
                        $this->di->get("session")->set("hash", /** @scrutinizer ignore-call */ password_hash($loginpass, PASSWORD_DEFAULT));
                        // $app->session->set("firstname", $res[0]->firstname);
                        $this->di->get("cookie")->set("user", $loginuser);
                        $this->di->get("cookie")->set("firstname", $res[0]->firstname);
                        // if (isset($_POST['remember'])) {
                        //     $this->di->get("cookie")->set("password", $loginpass);
                        // }
                        // $loginmsg = "<span class='formerror'>&nbsp;&nbsp;&nbsp; Du är nu inloggad, ".$res[0]->firstname.", ".$this->di->get("session")->get('email')."</span>";
                        $this->di->get("session")->set("loginmsg", "<span class='formerror'>&nbsp;&nbsp;&nbsp; Du är nu inloggad, ".$this->di->get("session")->get('user').", ".$this->di->get("session")->get('email')."</span>");
                        // Koden nedan ger maximum nesting reached.
                        // $app->view->add("login/welcome");
                        // $app->renderPage(["title" => "välkommen"], "login");
                        // exit;

                        $this->di->get("session")->delete("loginmsg");
                        $this->di->get("session")->delete("usermsg");
                        $this->di->get("session")->delete("passmsg");

                        $sql = "UPDATE RVIXaccount SET inlogged = CURRENT_TIMESTAMP WHERE BINARY username = BINARY ?";
                        $params = [$loginuser];
                        $this->di->get("db")->execute($sql, $params);

                        $this->di->get("response")->redirect("commentary/articles/alla");


                        // funkar inte.
                    } else {
                        $this->di->get("session")->set("loginmsg", "<span class='formerror'>&nbsp;&nbsp;&nbsp; Felaktigt användarnamn eller lösenord</span>");
                    }
                } else {
                    $this->di->get("session")->set("loginmsg", "<span class='formerror'>&nbsp;&nbsp;&nbsp; Felaktigt användarnamn eller lösenord</span>");
                }
            }
        }
        $this->loginpage();
    }

    /**
    * Accountpage
    *
    * @return void
    */
    public function accountPage()
    {
        if ($this->checkUserRole()) {
            $title      = "Konto | Småris";
            $session    = $this->di->get("session");
            $admin      = $this->di->get("admin");

            //----------------------------------

            $userid     = $session->get("userid");
            $account    = $admin->getAccount($userid);
            $isAdmin    = ($session->get("role") == 'admin') ? true : false;

            //----------------------------------

            $data = [
                "account" => $account,
                "isAdmin" => $isAdmin
            ];

            $this->di->get("view")->add("login/accountinfo", $data);
            $this->di->get("pageRender")->renderPage(["title" => $title]);
        } else {
            $this->loginPage();
        }
    }

    /**
    * Logoutprocess
    *
    * @return void
    */
    public function logoutProcess()
    {
        // $this->di->get("session")->delete('user');
        // $this->di->get("session")->delete('role');
        // $this->di->get("session")->delete('email');
        $this->di->get("session")->destroy();
        // $this->di->get("cookie")->delete('user');
        $this->di->get("cookie")->delete('firstname');
        $this->loginpage();
    }

    /**
    * Logoutprocess
    *
    *
    * @SuppressWarnings("PMD")
    * @return void
    */
    public function createAccountProcess()
    {

        // if ($this->di->get("request")->getPost("createuserbtn") != null) {
        if (isset($_POST['createuserbtn'])) {
            // $firstname = isset($_POST['firstname']) ? htmlentities($_POST['firstname']) : null;
            // $surname = isset($_POST['surname']) ? htmlentities($_POST['surname']) : null;
            // $email = isset($_POST['email']) ? htmlentities($_POST['email']) : null;
            // $username = isset($_POST['username']) ? htmlentities($_POST['username']) : null;
            // $passone = isset($_POST['passone']) ? htmlentities($_POST['passone']) : null;
            // $passtwo = isset($_POST['passtwo']) ? htmlentities($_POST['passtwo']) : null;
            $firstname = (null != $this->di->get("request")->getPost("firstname")) ? htmlentities($this->di->get("request")->getPost("firstname")) : null;
            $surname = (null != $this->di->get("request")->getPost("surname")) ? htmlentities($this->di->get("request")->getPost("surname")) : null;
            $email = (null != $this->di->get("request")->getPost("email")) ? htmlentities($this->di->get("request")->getPost("email")) : null;
            $username = (null != $this->di->get("request")->getPost("username")) ? htmlentities($this->di->get("request")->getPost("username")) : null;
            $passone = (null != $this->di->get("request")->getPost("passone")) ? htmlentities($this->di->get("request")->getPost("passone")) : null;
            $passtwo = (null != $this->di->get("request")->getPost("passtwo")) ? htmlentities($this->di->get("request")->getPost("passtwo")) : null;
            $this->di->get("session")->delete('createusererrormsg');
            if ($firstname === null || $surname === null || $username === null || $passone === null || $passtwo === null) {
                $this->di->get("session")->set('createusererrormsg', "<br /><p class='formerror'>Nytt konto skapades inte.</p><p class='formerror'>Alla fält måste fyllas i när du skapar nytt konto.</p>");
                $this->loginpage();
            } else {
                $this->di->get("login")->createNewAccount($firstname, $surname, $email, $username, $passone, $passtwo);
                $this->di->get("response")->redirect("accountinfo");
            }
        }

        // $this->di->get("response")->redirect("about");
    }
    public function userEditAccountProcess($id)
    {
        if ($this->checkUserRole()) {
            $request        = $this->di->get("request");
            $session        = $this->di->get("session");
            $admin          = $this->di->get("admin");

            //----------------------------------
            $userdata = array();
            $userdata["role"]       = htmlentities($request->getPost("role"));
            $userdata["active"]     = htmlentities($request->getPost("active"));
            $userdata["notes"]      = htmlentities($request->getPost("notes"));

            $userdata["firstname"]  = ($request->getPost("firstname") != null && $request->getPost("firstname") != '') ? htmlentities($request->getPost("firstname")) : null;
            $userdata["surname"]    = ($request->getPost("surname") != null && $request->getPost("surname") != '') ? htmlentities($request->getPost("surname")) : null;
            $userdata["email"]      = ($request->getPost("email") != null && $request->getPost("email") != '') ? htmlentities($request->getPost("email")) : null;
            $userdata["address"]    = ($request->getPost("address") != null && $request->getPost("address") != '') ? htmlentities($request->getPost("address")) : null;
            $userdata["postnumber"] = ($request->getPost("postnumber") != null && $request->getPost("postnumber") != '') ? htmlentities($request->getPost("postnumber")) : null;
            $userdata["city"]       = ($request->getPost("city") != null && $request->getPost("city") != '') ? htmlentities($request->getPost("city")) : null;
            $userdata["phone"]      = ($request->getPost("phone") != null && $request->getPost("phone") != '') ? htmlentities($request->getPost("phone")) : null;
            $userdata["mobile"]     = ($request->getPost("mobile") != null && $request->getPost("mobile") != '') ? htmlentities($request->getPost("mobile")) : null;

            //----------------------------------

            if ($userdata["firstname"] != null && $userdata["surname"] != null) {
                $admin->editAccount($id, $userdata);
                $session->delete("usereditinfomsg");
            } else {
                $usereditmsg = "<p>Förnamn och efternamn måste vara ifyllda.</p>";
                $session->set("usereditinfomsg", $usereditmsg);
            }
            $this->accountPage();
        } else {
            $this->loginPage();
        }
    }

    public function userEditPasswordProcess($id)
    {
        if ($this->checkUserRole()) {
            $request        = $this->di->get("request");
            $session        = $this->di->get("session");
            $admin          = $this->di->get("admin");

            //----------------------------------

            $userdata = array();
            $userdata["oldpass"]    = ($request->getPost("oldpass") != null && $request->getPost("oldpass") != '') ? htmlentities($request->getPost("oldpass")) : null;
            $userdata["newpassone"] = ($request->getPost("newpassone") != null && $request->getPost("newpassone") != '') ? htmlentities($request->getPost("newpassone")) : null;
            $userdata["newpasstwo"] = ($request->getPost("newpasstwo") != null && $request->getPost("newpasstwo") != '') ? htmlentities($request->getPost("newpasstwo")) : null;

            //----------------------------------

            if ($userdata["oldpass"] != null && $userdata["newpassone"] != null && $userdata["newpasstwo"] != null) {
                $isValid = $admin->validatePasswordEdit($id, $userdata);
                if ($isValid) {
                    $admin->resetPassword($id, $userdata['newpassone']);
                    $session->delete('usereditpassmsg');
                }
            } else {
                $usereditmsg = "<p>Alla fält måste vara ifyllda.</p>";
                $session->set("usereditpassmsg", $usereditmsg);
            }
            $this->accountPage();
        } else {
            $this->loginPage();
        }
    }

    /**
    * Change password process
    *
    * @return void
    */
    public function changePasswordProcess()
    {
        $this->di->get("db")->connect();
        $username = $this->di->get("session")->get('user', "");
        $this->di->get("login")->changePasswordProcess($username);
    }

    public function checkUserRole()
    {
        return ($this->di->get("session")->get("role") == "user" || $this->di->get("session")->get("role") == "admin") ? true : false;
    }
}
