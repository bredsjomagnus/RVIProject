<?php
/**
 * Routes for the Login procedure.
 */
return [
    "routes" => [
        [
            "info" => "Login sidan",
            "requestMethod" => null,
            "path" => "",
            "callable" => ["loginController", "getHome"]
        ],


        [
            "info" => "Login sidan",
            "requestMethod" => null,
            "path" => "login",
            "callable" => ["loginController", "loginpage"]
        ],
        [
            "info" => "Logga ut process",
            "requestMethod" => null,
            "path" => "logout",
            "callable" => ["loginController", "logoutProcess"]
        ],
        [
            "info" => "Logga in process",
            "requestMethod" => null,
            "path" => "loginprocess",
            "callable" => ["loginController", "loginProcess"]
        ],
        [
            "info" => "Kontosida",
            "requestMethod" => null,
            "path" => "accountinfo",
            "callable" => ["loginController", "accountPage"]
        ],
        [
            "info" => "Skapa nytt konto",
            "requestMethod" => "post",
            "path" => "createaccount",
            "callable" => ["loginController", "createAccountProcess"]
        ],
        [
            "info" => "Användaren redigerar sina kontouppgifter",
            "requestMethod" => "post",
            "path" => "usereditaccountprocess/{id:digit}",
            "callable" => ["loginController", "userEditAccountProcess"]
        ],
        [
            "info" => "Användaren redigerar sitt lösenord",
            "requestMethod" => "post",
            "path" => "usereditpasswordprocess/{id:digit}",
            "callable" => ["loginController", "userEditPasswordProcess"]
        ],
        // [
        //     "info" => "Ändra användares lösenord",
        //     "requestMethod" => "post",
        //     "path" => "changepassword",
        //     "callable" => ["loginController", "changePasswordProcess"]
        // ]
    ]
];


// $app->router->add("login", [$app->LoginController, "loginpage"]);
// $app->router->add("accountinfo", [$app->LoginController, "accountpage"]);
// // $app->router->post("loginprocess", [$app->LoginController, "loginprocess"]);
//
// $app->router->add("createuser", function () use ($app) {
//     $app->view->add("login/create_user");
//     $app->response->setBody([$app->view, "render"])
//                   ->send();
// });
// $app->router->add("logout", function () use ($app) {
//     $app->view->add("login/logout");
//     $app->response->setBody([$app->view, "render"])
//                   ->send();
// });
// $app->router->add("logoutscreen", function () use ($app) {
//     $app->view->add("login/logoutscreen");
//     $app->response->setBody([$app->view, "render"])
//                   ->send();
// });
