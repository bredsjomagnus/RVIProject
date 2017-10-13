<?php
/**
* Routes.
*/
return [
    // Load these routefiles in order specified and optionally mount them
    // onto a base route.
    "routeFiles" => [
        // [
        //     // Add routes from ContentController and mount on admincontent/
        //     "mount" => "admincontent",
        //     "file" => __DIR__ . "/route/contentcontroller.php",
        // ],
        [
            // These are for internal error handling and exceptions
            "mount" => "commentary",
            "file" => __DIR__ . "/route/commentary.php",
        ],
        [
            // These are for internal error handling and exceptions
            "mount" => null,
            "file" => __DIR__ . "/route/login.php",
        ],
        // [
        //     // Add routes from userController and mount on user/
        //     "mount" => "user",
        //     "file" => __DIR__ . "/route/userController.php",
        // ],
        [
            // Add routes from bookController and mount on book/
            "mount" => "book",
            "file" => __DIR__ . "/route/bookcontroller.php",
        ],

        [
            // These are for internal error handling and exceptions
            "mount" => null,
            "file" => __DIR__ . "/route/internal.php",
        ],
        [
            // These are for internal error handling and exceptions
            "mount" => null,
            "file" => __DIR__ . "/route/admin.php",
        ],
        [
            // These are for internal error handling and exceptions
            "mount" => null,
            "file" => __DIR__ . "/route/internal.php",
        ],
        [
            // For debugging and development details on Anax
            "mount" => "debug",
            "file" => __DIR__ . "/route/debug.php",
        ],
        [
            // These are for internal error handling and exceptions
            "mount" => null,
            "file" => __DIR__ . "/route/remserver.php",
        ],
        [
            // To read flat file content in Markdown from content/
            "mount" => null,
            "file" => __DIR__ . "/route/flat-file-content.php",
        ],
        [
            // Keep this last since its a catch all
            "mount" => null,
            "file" => __DIR__ . "/route/404.php",
        ]
    ],

];
// require __DIR__ . "/route/remserver.php";
// require __DIR__ . "/route/commentary.php";
// require __DIR__ . "/route/admin.php";
// require __DIR__ . "/route/login.php";
// require __DIR__ . "/route/internal.php";
// require __DIR__ . "/route/debug.php";
// require __DIR__ . "/route/flat-file-content.php";
// require __DIR__ . "/route/views.php";
//
// // Catch all route last
// require __DIR__ . "/route/404.php";
