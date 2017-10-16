<?php
/**
* config file for navbar
*/



return [
    "navbar-main" => [
        "config" => [
            "navbar-class" => "nav navbar-nav"
        ],
        "items" => [
            "hem" => [
                "text" => "Översikt",
                "route" => "",
                "class" => ""
            ],
            "om" => [
                "text" => "OM",
                "route" => "about",
                "class" => ""
            ],
            // "redovisningar" => [
            //     "text" => "REDOVISNINGAR",
            //     "route" => "report",
            //     "class" => ""
            // ],
            "questions" => [
                "text" => "Frågor",
                "route" => "commentary/articles/alla",
                "class" => ""
            ],
            "tags" => [
                "text" => "Taggar",
                "route" => "commentary/tags",
                "class" => ""
            ],
            // "books" => [
            //     "text" => "BÖCKER",
            //     "route" => "book",
            //     "class" => ""
            // ],
            // "kommentarsmodul" => [
            //     "text" => "KOMMENTARSMODUL",
            //     "route" => "commentary",
            //     "class" => ""
            // ],
            "login" => [
                "text" => "LOGGA IN",
                "route" => "login",
                "class" => ""
            ],
            "logout" => [
                "text" => "LOGGA UT",
                "route" => "logout",
                "class" => ""
            ]
        ],
        // "dropdown" => [
        //     "namn" => "ARTIKLAR",
        //     "items" => [
        //         "mvc" => [
        //             "text" => "MVC",
        //             "route" => "article/mvc"
        //         ],
        //         "books" => [
        //             "text" => "BÖCKER",
        //             "route" => "article/books"
        //         ],
        //         "food" => [
        //             "text" => "MAT",
        //             "route" => "article/food"
        //         ]
        //     ]
        // ]
    ],
    "navbar-admin" => [
        "config" => [
            "navbar-class" => "nav navbar-nav"
        ],
        "items" => [
            "hem" => [
                "text" => "HEM",
                "route" => "",
                "class" => ""
            ],
            "comments" => [
                "text" => "KOMMENTARER",
                "route" => "admincomments",
                "class" => ""
            ],
            "accounts" => [
                "text" => "ANVÄNDARE",
                "route" => "adminaccounts",
                "class" => ""
            ],
            "content" => [
                "text" => "INNEHÅLL",
                "route" => "admincontent",
                "class" => ""
            ],
            "login" => [
                "text" => "LOGGA IN",
                "route" => "login",
                "class" => ""
            ],
            "logout" => [
                "text" => "LOGGA UT",
                "route" => "logout",
                "class" => ""
            ]
        ]
    ]
];
