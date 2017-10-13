<?php

namespace Anax\Book;

use \Anax\Configure\ConfigureInterface;
use \Anax\Configure\ConfigureTrait;
use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;
use \Anax\Book\HTMLForm\CreateForm;
use \Anax\Book\HTMLForm\EditForm;
use \Anax\Book\HTMLForm\DeleteForm;
use \Anax\Book\HTMLForm\UpdateForm;

/**
 * A controller class.
 */
class BookController implements
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
        $title      = "Bokbas | Maaa16";
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");
        // $book = new Book();
        // $book->setDb($this->di->get("db"));

        // $data = [
        //     "items" => $book->findAll(),
        // ];
        //
        // $view->add("book/crud/view-all", $data);
        $view->add("book/crud/book");

        $pageRender->renderPage(["title" => $title]);
    }


    /**
     * Show all items.
     *
     * @return void
     */
    public function getAllBooks()
    {
        $title      = "Alla böcker | Maaa16";
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");
        $book = new Book();
        $book->setDb($this->di->get("db"));

        // $data = [
        //     "items" => $book->findAll(),
        // ];
        //
        $view->add("book/crud/view-all", ["books" => $book->findAll()]);
        // $view->add("book/crud/book");

        $pageRender->renderPage(["title" => $title]);
    }




    /**
     * Handler with form to create a new item.
     *
     * @return void
     */
    public function getPostCreateBook()
    {
        $title      = "Lägg till bok | Maaa16";
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");
        $form       = new CreateForm($this->di);

        $form->check();

        $data = [
            "form" => $form->getHTML(),
        ];

        $view->add("book/crud/add-book", $data);

        $pageRender->renderPage(["title" => $title]);
    }



    /**
     * Handler with form to delete an item.
     *
     * @return void
     */
    public function getPostDeleteBooks()
    {
        $title      = "Ta bort böcker | Maaa16";
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");
        $form       = new DeleteForm($this->di);
        $book = new Book();
        $book->setDb($this->di->get("db"));
        $form->check();


        $view->add("book/crud/delete", ["books" => $book->findAll(), "form" => $form->getHTML()]);

        $pageRender->renderPage(["title" => $title]);
    }



    /**
     * Handler with form to update an book.
     *
     * @return void
     */
    public function getPostEditBook($id)
    {
        $title      = "Redigera bokinformation | Maaa16";
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");
        $form       = new UpdateForm($this->di, $id);

        $form->check();

        $data = [
            "form" => $form->getHTML(),
        ];

        $view->add("book/crud/edit", $data);

        $pageRender->renderPage(["title" => $title]);
    }
}
