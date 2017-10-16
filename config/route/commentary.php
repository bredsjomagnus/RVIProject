<?php
/**
 * Routes for the Commentary.
 */
return [
    "routes" => [
        [
            "info" => "Startsida eller sammanfattningssida med senaste frågorna, mest aktiva användarna mm.",
            "requestMethod" => null,
            "path" => "overview",
            "callable" => ["commController", "overview"]
        ],

        [
            "info" => "Sidan med frågor/artiklar och möjlighet att skapa nya frågor/artiklar",
            "requestMethod" => null,
            "path" => "articles/{tag:alphanum}",
            "callable" => ["commController", "articles"]
        ],
        [
            "info" => "Lägg till svar på en fråga",
            "requestMethod" => "get|post",
            "path" => "addanswerprocess",
            "callable" => ["commController", "addAnswerProcess"]
        ],
        [
            "info" => "Lägg till kommentar på en fråga",
            "requestMethod" => "get|post",
            "path" => "addarticlecommentprocess",
            "callable" => ["commController", "addArticleCommentProcess"]
        ],
        [
            "info" => "Lägg till kommentar på ett svar",
            "requestMethod" => "get|post",
            "path" => "addanswercommentprocess",
            "callable" => ["commController", "addAnswerCommentProcess"]
        ],
        [
            "info" => "Lägg till kommentar på ett svar",
            "requestMethod" => "get|post",
            "path" => "userinfo/{id:digit}",
            "callable" => ["commController", "userInfo"]
        ],

        // likeroutes
        [
            "info" => "Lägg till kommentar på ett svar",
            "requestMethod" => "get|post",
            "path" => "votearticleprocess/{id:digit}",
            "callable" => ["commController", "voteArticleProcess"]
        ],




        // [
        //     "info" => "Lägg till kommentar",
        //     "requestMethod" => "get|post",
        //     "path" => "createcomment",
        //     "callable" => ["commController", "addComment"]
        // ],
        [
            "info" => "Redigera kommentar",
            "requestMethod" => "get",
            "path" => "editcomment",
            "callable" => ["commController", "editComment"]
        ],
        [
            "info" => "Redigera kommentar process",
            "requestMethod" => "post",
            "path" => "editcommentprocess",
            "callable" => ["commController", "editCommentProcess"]
        ],
        [
            "info" => "Lägg till gilla process",
            "requestMethod" => "get",
            "path" => "addlikeprocess",
            "callable" => ["commController", "addLikeProcess"]
        ],
        [
            "info" => "Gå till artikel",
            "requestMethod" => null,
            "path" => "article/{id:digit}",
            "callable" => ["commController", "articlePage"]
        ],
        [
            "info" => "Gå till artikel",
            "requestMethod" => null,
            "path" => "tags",
            "callable" => ["commController", "tagsPage"]
        ],

        // Articles Routes
        // [
        //     "info" => "Artiklar",
        //     "requestMethod" => null,
        //     "path" => "",
        //     "callable" => ["commController", "getArticles"]
        // ],
        [
            "info" => "Create an article",
            "requestMethod" => "get|post",
            "path" => "createarticle",
            "callable" => ["commController", "getPostCreateArticle"],
        ],
        [
            "info" => "Create an article",
            "requestMethod" => "get|post",
            "path" => "deletearticle/{id:digit}",
            "callable" => ["commController", "getPostCreateArticle"],
        ],
        [
            "info" => "Uppdatera artiklar",
            "requestMethod" => "get|post",
            "path" => "updatearticle/{id:digit}",
            "callable" => ["commController", "getPostUpdateArticle"],
        ],
    ]
];
