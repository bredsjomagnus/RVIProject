<!-- <?php
/**
 * Add and configure services and return the $app object.
 */

// Add all resources to $app
// $app = new \Anax\App\App();
// $app->request    = new \Anax\Request\Request();
// $app->response   = new \Anax\Response\Response();
// $app->url        = new \Anax\Url\Url();
// $app->router     = new \Anax\Route\RouterInjectable();
// $app->view       = new \Anax\View\ViewContainer();
// $app->textfilter = new \Anax\TextFilter\TextFilter();
// $app->session    = new \Anax\Session\SessionConfigurable();
// $app->navbar     = new \Maaa16\Navbar\Navbar();
// Add the REM server
// $app->rem           = new \Anax\RemServer\RemServer();
// $app->remController = new \Anax\RemServer\RemServerController();
// // Add the Commentary
// $app->comm           = new \Maaa16\Commentary\Commentary();
// $app->commController = new \Maaa16\Commentary\CommController();
// $app->commAssembler = new \Maaa16\Commentary\CommAssembler();
// // Add login
// $app->LoginController = new \Maaa16\Login\LoginController();
// // $app->Login = new \Maaa16\Login\Login();
//
// $app->adminController = new \Maaa16\Admin\AdminController();
// $app->adminAssembler = new \Maaa16\Admin\AdminAssembler();
// $app->admin = new \Maaa16\Admin\Admin();
//
// $app->cookie = new \Maaa16\Cookie\Cookie();
//
// $app->session->start();
//
//
// // Add database
// $app->database  = new \Maaa16\Database\Database();
// // Init REM Server
// $app->rem->configure("remserver.php");
// $app->rem->inject(["session" => $app->session]);
//
// // Init controller for the REM Server
// $app->remController->setApp($app);
//
// // Inject $app to Database
// $app->database->setApp($app);
//
// // Inject $app to Login
// $app->LoginController->setApp($app);
//
// // Inject $app to Admin
// $app->adminController->setApp($app);
// $app->adminAssembler->setApp($app);
// $app->admin->setApp($app);
//
// // Configure Database
// $app->database->configure("database.php");
// $app->database->setDefaultsFromConfiguration();
//
// // Init commentary
// // $app->rem->configure("remserver.php");
// $app->comm->inject(["session" => $app->session]);
//
// // Init controller for the Commentary
// $app->commController->setApp($app);
// $app->commAssembler->setApp($app);
//
// // Configure request
// $app->request->init();
//
// // Configure router
// $app->router->setApp($app);
//
// // Configure session
// $app->session->configure("session.php");
//
// // Configure url
// $app->url->setSiteUrl($app->request->getSiteUrl());
// $app->url->setBaseUrl($app->request->getBaseUrl());
// $app->url->setStaticSiteUrl($app->request->getSiteUrl());
// $app->url->setStaticBaseUrl($app->request->getBaseUrl());
// $app->url->setScriptName($app->request->getScriptName());
// $app->url->configure("url.php");
// $app->url->setDefaultsFromConfiguration();
//
// // Configure view
// $app->view->setApp($app);
// $app->view->configure("view.php");
//
// // Configure navbar
// $app->navbar->setApp($app);
// $app->navbar->configure("navbar.php");
//
// // Return the populated $app
// return $app;
