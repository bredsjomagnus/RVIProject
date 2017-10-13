<?php
/**
 * Routes for the Commentary.
 */
 /** Go to article page index.md with admincontroll features */
return [
    "routes" => [
        [
            "info" => "Admin startsida",
            "requestMethod" => null,
            "path" => "admin",
            "callable" => ["adminController", "adminPage"]
        ],
        [
            "info" => "Admin kommentarer",
            "requestMethod" => null,
            "path" => "admincomments",
            "callable" => ["adminController", "adminComments"]
        ],
        [
            "info" => "Admin konton",
            "requestMethod" => null,
            "path" => "adminaccounts",
            "callable" => ["adminController", "adminAccounts"]
        ],
        [
            "info" => "Admin innehåll",
            "requestMethod" => null,
            "path" => "admincontent",
            "callable" => ["adminController", "adminContent"]
        ],
        [
            "info" => "Admin redigera konto",
            "requestMethod" => "get",
            "path" => "admineditaccount",
            "callable" => ["adminController", "adminEditAccount"]
        ],
        [
            "info" => "Admin redigering av medlems process",
            "requestMethod" => "post",
            "path" => "admineditaccountprocess",
            "callable" => ["adminController", "adminEditAccountProcess"]
        ],
        [
            "info" => "Admin redigering av medlems process",
            "requestMethod" => "post",
            "path" => "adminresetpassword",
            "callable" => ["adminController", "adminResetPassword"]
        ],
        [
            "info" => "Admin redigering av medlems process",
            "requestMethod" => "post",
            "path" => "adminresetpasswordprocess",
            "callable" => ["adminController", "adminResetPasswordProcess"]
        ],
    ]
];

// $app->router->add("adminpage", [$app->adminController, "adminPage"]);
$app->router->add("admincomments", [$app->adminController, "adminComments"]);
