<?php
// $app->session->start();
// if (isset($_POST['createuserbtn'])) {
//     $forname = isset($_POST['forname']) ? htmlentities($_POST['forname']) : null;
//     $surname = isset($_POST['surname']) ? htmlentities($_POST['surname']) : null;
//     $email = isset($_POST['email']) ? htmlentities($_POST['email']) : null;
//     $username = isset($_POST['username']) ? htmlentities($_POST['username']) : null;
//     $passone = isset($_POST['passone']) ? htmlentities($_POST['passone']) : null;
//     $passtwo = isset($_POST['passtwo']) ? htmlentities($_POST['passtwo']) : null;
//
//     unset($_SESSION['createusererrormsg']);
//
//     // echo $forname . " " . $surname . " " . $email . " " . $username . " " . $passone . " " . $passtwo;
//     if ($forname == null || $surname == null || $email == null || $username == null || $passone == null || $passtwo == null) {
//         $_SESSION['createusererrormsg'] = "<br /><p class='formerror'>Nytt konto skapades inte.</p><p class='formerror'>Alla fält måste fyllas i när du skapar nytt konto.</p>";
//         header('Location: login');
//     } else {
//         $app->database->connect();
//         $sql = "SELECT * FROM ramverk1accounts WHERE username = '$username'";
//         if ($passone != $passtwo) {
//             $app->session->set('createusererrormsg', "<br /><p class='formerror'>Nytt konto skapades inte.</p><p class='formerror'>Lösenordet var inte samma vid upprepning.</p>");
//             header('Location: login');
//         } else if ($app->database->executeFetchAll($sql)) {
//             $app->session->set('createusererrormsg', "<br /><p class='formerror'>Nytt konto skapades inte.</p><p class='formerror'>Det finns redan konto med det användarnamnet.</p>");
//             header('Location: login');
//         } else if ($passone == $passtwo) {
//             $securepass = password_hash($passone, PASSWORD_DEFAULT);
//             $sql = "INSERT INTO ramverk1accounts (role, username, pass, forname, surname, email) VALUES (?, ?, ?, ?, ?, ?)";
//             $params = ['user', $username, $securepass, $forname, $surname, $email];
//             $sth = $app->database->execute($sql, $params);
//             $app->session->set("user", $username);
//             $app->session->set("email", $email);
//             $app->session->set("role", 'user');
//             $app->cookie->set("user", $username);
//             $app->session->set("userid", $app->database->lastInsertId());
//             $app->cookie->set("forname", $forname);
//
//             header("Location: about");
//         }
//     }
// }
