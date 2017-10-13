<?php
$usermsg = "";
$passmsg = "";
$loginmsg = isset($_SESSION['createusererrormsg']) ? $_SESSION['createusererrormsg']: "";
if (isset($_POST['loginsubmit'])) {
    $userdone = true;
    $passdone = true;
    // $passdone = false;
    if ($user == "") {
        $_SESSION['usermsg'] = "&nbsp;&nbsp;&nbsp; Måste fylla i användarnamn";
        $userdone = false;
        echo "kommer hit inget usercheck";
    }
    if ($pass == "") {
        $_SESSION['passmsg'] = "&nbsp;&nbsp;&nbsp;* Måste fylla i lösenord";
        $passdone = false;
        echo "kommer hit inget passcheck";
    }
    if ($userdone && $passdone) {
        echo "både user och pass är ifyllt";
        $loginuser =  htmlentities($user);
        $loginpass =  htmlentities($pass);
        $app->database->connect();
        $sql = "SELECT * FROM ramverk1accounts WHERE BINARY username = BINARY '$loginuser'";
        if ($res = $app->database->executeFetchAll($sql)) {
            echo "Det fanns en sådan user";
            $dbpass = $res[0]->pass;
            $passwordverify = password_verify($loginpass, $dbpass);
            if ($res[0]->active != 'yes') {
                $_SESSION['loginmsg'] = "<span class='formerror'>&nbsp;&nbsp;&nbsp; Konto deaktiverat av administratör.</span>";
            } else if ($passwordverify) {
                $app->session->set("user", $loginuser);
                $app->session->set("role", $res[0]->role);
                $app->session->set("hash", password_hash($loginpass, PASSWORD_DEFAULT));
                // $app->session->set("forname", $res[0]->forname);
                $app->cookie->set("user", $loginuser);
                $app->cookie->set("forname", $res[0]->forname);
                if (isset($_POST['remember'])) {
                    $app->cookie->set("password", $loginpass);
                }
                // $app->cookie->set("name", $app->database->get($))
                header("Location: about");
            } else {
                $_SESSION['loginmsg'] = "<span class='formerror'>&nbsp;&nbsp;&nbsp; Felaktigt användarnamn eller lösenord</span>";
                header("Location: login");
            }
        } else {
            echo "<br />Det fanns ingen sådan user - " . $user;
            $_SESSION['loginmsg'] = "<span class='formerror'>&nbsp;&nbsp;&nbsp; Felaktigt användarnamn eller lösenord</span>";
            header("Location: login");
        }
    }
}
