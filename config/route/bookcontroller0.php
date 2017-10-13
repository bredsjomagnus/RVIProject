<?php
/**
 * Routes for controller.
 */
return [
    "routes" => [
        [
            "info" => "Landing page.",
            "requestMethod" => "get",
            "path" => "",
            "callable" => ["bookController", "getIndex"],
        ],
        [
            "info" => "View all books.",
            "requestMethod" => "get",
            "path" => "view-all",
            "callable" => ["bookController", "getAllBooks"],
        ],
        [
            "info" => "Create an item.",
            "requestMethod" => "get|post",
            "path" => "add-book",
            "callable" => ["bookController", "getPostCreateBook"],
        ],
        [
            "info" => "Delete books.",
            "requestMethod" => "get|post",
            "path" => "delete",
            "callable" => ["bookController", "getPostDeleteBooks"],
        ],
        [
            "info" => "Update an item.",
            "requestMethod" => "get|post",
            "path" => "edit/{id:digit}",
            "callable" => ["bookController", "getPostEditBook"],
        ],
    ]
];
