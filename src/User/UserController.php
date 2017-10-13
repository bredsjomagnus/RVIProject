<?php

namespace Anax\User;

use \Anax\Configure\ConfigureInterface;
use \Anax\Configure\ConfigureTrait;
use \Anax\DI\InjectionAwareInterface;
use \Anax\Di\InjectionAwareTrait;
use \Anax\User\HTMLForm\UserLoginForm;
use \Anax\User\HTMLForm\CreateUserForm;

/**
 * A controller class.
 */
class UserController implements
    ConfigureInterface,
    InjectionAwareInterface
{
    use ConfigureTrait,
        InjectionAwareTrait;



    /**
     * @var $data description
     */
    //private $data;



    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return void
     */
    public function getIndex()
    {
        $title      = "A index page";
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");

        $data = [
            "content" => "An index page",
        ];

        $view->add("default2/article", $data);

        $pageRender->renderPage(["title" => $title]);
    }



    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return void
     */
    public function getPostLogin()
    {
        // $this->di->get("view")->add("login/login");
        // $title = "Login | maaa16";
        // $this->di->get("pageRender")->renderPage(["title" => $title], "login");

        // $title      = "A login page";
        // $view       = $this->di->get("view");
        // $pageRender = $this->di->get("pageRender");
        $form       = new UserLoginForm($this->di);

        $form->check();

        // $data = [
        //     "content" => $form->getHTML(),
        // ];

        // $view->add("default2/article", $data);
        //
        // $pageRender->renderPage(["title" => $title]);

        $this->di->get("view")->add("login/loginnew", ["form" => $form->getHTML()]);
        $title = "Login | maaa16";
        $this->di->get("pageRender")->renderPage(["title" => $title], "login");
    }



    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return void
     */
    public function getPostCreateUser()
    {
        // $title      = "A create user page";
        // $view       = $this->di->get("view");
        // $pageRender = $this->di->get("pageRender");
        $form       = new CreateUserForm($this->di);

        $form->check();

        // $data = [
        //     "content" => $form->getHTML(),
        // ];
        //
        // $view->add("default2/article", $data);
        //
        // $pageRender->renderPage(["title" => $title]);

        $this->di->get("view")->add("login/create", ["form" => $form->getHTML()]);
        $title = "Skapa nytt konto | maaa16";
        $this->di->get("pageRender")->renderPage(["title" => $title], "login");
    }

    public function accountInfoPage($id)
    {
        $this->di->get("view")->add("login/accountinfonew", ["id" => $id]);
        $title = "Kontosida | maaa16";
        $this->di->get("pageRender")->renderPage(["title" => $title], "login");
    }
}
