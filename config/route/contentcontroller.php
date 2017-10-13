<?php
/**
 * Routes for controller.
 */
return [
    "routes" => [
        [
            "info" => "Artiklar",
            "requestMethod" => null,
            "path" => "",
            "callable" => ["contentController", "getIndex"]
        ],
        [
            "info" => "Create an article",
            "requestMethod" => "get|post",
            "path" => "create",
            "callable" => ["contentController", "getPostCreateContent"],
        ],
        [
            "info" => "Uppdatera artiklar",
            "requestMethod" => "get|post",
            "path" => "update/{id:digit}",
            "callable" => ["contentController", "getPostUpdateContent"],
        ],

    ]
];
