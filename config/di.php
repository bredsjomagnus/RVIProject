<?php
/**
 * Configuration file for DI container.
 */
return [

    // Services to add to the container.
    "services" => [
        "request" => [
            "shared" => true,
            "callback" => function () {
                $request = new \Anax\Request\Request();
                $request->init();
                return $request;
            }
        ],
        "response" => [
            "shared" => true,
            //"callback" => "\Anax\Response\Response",
            "callback" => function () {
                $obj = new \Anax\Response\ResponseUtility();
                $obj->setDI($this);
                return $obj;
            }
        ],
        "url" => [
            "shared" => true,
            "callback" => function () {
                $url = new \Anax\Url\Url();
                $request = $this->get("request");
                $url->setSiteUrl($request->getSiteUrl());
                $url->setBaseUrl($request->getBaseUrl());
                $url->setStaticSiteUrl($request->getSiteUrl());
                $url->setStaticBaseUrl($request->getBaseUrl());
                $url->setScriptName($request->getScriptName());
                $url->configure("url.php");
                $url->setDefaultsFromConfiguration();
                return $url;
            }
        ],
        "router" => [
            "shared" => true,
            "callback" => function () {
                $router = new \Anax\Route\Router();
                $router->setDI($this);
                $router->configure("route.php");
                return $router;
            }
        ],
        "view" => [
            "shared" => true,
            "callback" => function () {
                $view = new \Anax\View\ViewCollection();
                $view->setDI($this);
                $view->configure("view.php");
                return $view;
            }
        ],
        "viewRenderFile" => [
            "shared" => true,
            "callback" => function () {
                $viewRender = new \Anax\View\ViewRenderFile2();
                $viewRender->setDI($this);
                return $viewRender;
            }
        ],
        "session" => [
            "shared" => true,
            "active" => true,
            "callback" => function () {
                $session = new \Anax\Session\SessionConfigurable();
                $session->configure("session.php");
                $session->start();
                return $session;
            }
        ],
        "cookie" => [
            "shared" => true,
            "callback" => function () {
                $cookie = new \Maaa16\Cookie\Cookie();
                return $cookie;
            }
        ],
        "textfilter" => [
            "shared" => true,
            "callback" => "\Anax\TextFilter\TextFilter",
        ],
        "navbar" => [
            "shared" => true,
            "callback" => function () {
                $navbar = new \Maaa16\Navbar\Navbar();
                $navbar->configure("navbar.php");
                $navbar->setDI($this);
                return $navbar;
            }
        ],
        // "rem" => [
        //     "shared" => true,
        //     "callback" => function () {
        //         $rem = new \Anax\RemServer\RemServer();
        //         $rem->configure("remserver.php");
        //         $rem->injectSession($this->get("session"));
        //         return $rem;
        //     }
        // ],
        // "remController" => [
        //     "shared" => false,
        //     "callback" => function () {
        //         $remController = new \Anax\RemServer\RemServerController();
        //         $remController->setDI($this);
        //         return $remController;
        //     }
        // ],
        "articleFactory" => [
            "shared" => true,
            "callback" => function () {
                $obj = new \Maaa16\Commentary\ArticleFactory();
                $obj->setDI($this);
                return $obj;
            }
        ],
        "comm" => [
            "shared" => false,
            "callback" => function () {
                $comm = new \Maaa16\Commentary\Commentary();
                $comm->setDI($this);
                return $comm;
            }
        ],
        "commController" => [
            "shared" => false,
            "callback" => function () {
                $commController = new \Maaa16\Commentary\CommController();
                $commController->setDI($this);
                return $commController;
            }
        ],
        "commAssembler" => [
            "shared" => false,
            "callback" => function () {
                $commAssembler = new \Maaa16\Commentary\CommAssembler();
                $commAssembler->setDI($this);
                return $commAssembler;
            }
        ],
        "loginController" => [
            "shared" => false,
            "callback" => function () {
                $loginController = new \Maaa16\Login\LoginController();
                $loginController->setDI($this);
                return $loginController;
            }
        ],
        "login" => [
            "shared" => false,
            "callback" => function () {
                $login = new \Maaa16\Login\Login();
                $login->setDI($this);
                return $login;
            }
        ],
        "userController" => [
            "shared" => true,
            "callback" => function () {
                $obj = new \Anax\User\UserController();
                $obj->setDI($this);
                return $obj;
            }
        ],
        // "bookController" => [
        //     "shared" => true,
        //     "callback" => function () {
        //         $obj = new \Anax\Book\BookController();
        //         $obj->setDI($this);
        //         return $obj;
        //     }
        // ],
        // "contentController" => [
        //     "shared" => true,
        //     "callback" => function () {
        //         $obj = new \Maaa16\Content\ContentController();
        //         $obj->setDI($this);
        //         return $obj;
        //     }
        // ],
        // "contentFactory" => [
        //     "shared" => true,
        //     "callback" => function () {
        //         $obj = new \Maaa16\Content\ContentFactory();
        //         $obj->setDI($this);
        //         return $obj;
        //     }
        // ],
        // "database" => [
        //     "shared" => true,
        //     "callback" => function () {
        //         $database = new \Maaa16\Database\Maaa16Database();
        //         $database->configure("database.php");
        //         $database->setDefaultsFromConfiguration();
        //         return $database;
        //     }
        // ],
        "db" => [
            "shared" => true,
            "callback" => function () {
                $obj = new \Anax\Database\DatabaseQueryBuilder();
                $obj->configure("anaxdatabase.php");
                return $obj;
            }
        ],
        // "dbtest" => [
        //     "shared" => true,
        //     "callback" => function () {
        //         $obj = new \Anax\Database\DatabaseQueryBuilder();
        //         $obj->configure("databaseconfig.php");
        //         return $obj;
        //     }
        // ],
        "admin" => [
            "shared" => true,
            "callback" => function () {
                $admin = new \Maaa16\Admin\Admin();
                $admin->setDI($this);
                return $admin;
            }
        ],
        "paginator" => [
            "shared" => true,
            "callback" => function () {
                $paginator = new \Maaa16\Paginator\Paginator();
                $paginator->setDI($this);
                return $paginator;
            }
        ],
        "adminController" => [
            "shared" => false,
            "callback" => function () {
                $adminController = new \Maaa16\Admin\AdminController();
                $adminController->setDI($this);
                return $adminController;
            }
        ],
        "adminAssembler" => [
            "shared" => false,
            "callback" => function () {
                $adminAssembler = new \Maaa16\Admin\AdminAssembler();
                $adminAssembler->setDI($this);
                return $adminAssembler;
            }
        ],
        "errorController" => [
            "shared" => true,
            "callback" => function () {
                $obj = new \Anax\Page\ErrorController();
                $obj->setDI($this);
                return $obj;
            }
        ],
        "debugController" => [
            "shared" => true,
            "callback" => function () {
                $obj = new \Anax\Page\DebugController();
                $obj->setDI($this);
                return $obj;
            }
        ],
        "flatFileContentController" => [
            "shared" => true,
            "callback" => function () {
                $obj = new \Anax\Page\FlatFileContentController();
                $obj->setDI($this);
                return $obj;
            }
        ],
        "pageRender" => [
            "shared" => true,
            "callback" => function () {
                $obj = new \Anax\Page\PageRender();
                $obj->setDI($this);
                return $obj;
            }
        ],
    ],
];
