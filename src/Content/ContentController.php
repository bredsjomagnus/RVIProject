<?php

namespace Maaa16\Content;

use \Anax\Configure\ConfigureInterface;
use \Anax\Configure\ConfigureTrait;
use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;
use \Maaa16\Content\HTMLForm\CreateContentForm;
use \Maaa16\Content\HTMLForm\UpdateContentForm;
use \Maaa16\Content\HTMLForm\DeleteContentForm;

/**
 * A controller class.
 */
class ContentController implements
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
     * Books landing page.
     *
     * @return void
     */
    public function getIndex()
    {
        $title      = "Innehåll | Maaa16";
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");
        $content = new Content();
        $content->setDb($this->di->get("db"));

        $data = [
            "contents" => $content->findAll(),
        ];
        $view->add("admin/admincontent", $data);
        $pageRender->renderAdminPage(["title" => $title], "admin");
    }

    /**
     * Handler with form to create a new item.
     *
     * @return void
     */
    public function getPostCreateContent()
    {
        $title      = "Lägg till innehåll | Maaa16";
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");
        $form       = new CreateContentForm($this->di);

        $form->check();

        $data = [
            "form" => $form->getHTML(),
        ];

        $view->add("admin/admincreatecontent", $data);

        $pageRender->renderAdminPage(["title" => $title], "admin");
    }

    /**
     * Handler with form to update an book.
     *
     * @return void
     */
    public function getPostUpdateContent($id)
    {
        $title      = "Redigera innehåll | Maaa16";
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");
        $form       = new UpdateContentForm($this->di, $id);

        $form->check();

        $data = [
            "form" => $form->getHTML(),
        ];

        $view->add("admin/adminupdatecontent", $data);

        $pageRender->renderAdminPage(["title" => $title], "admin");
    }
}
