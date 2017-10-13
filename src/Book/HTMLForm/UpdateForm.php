<?php

namespace Anax\Book\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \Anax\Book\Book;

/**
 * Form to update an item.
 */
class UpdateForm extends FormModel
{
    /**
     * Constructor injects with DI container and the id to update.
     *
     * @param Anax\DI\DIInterface $di a service container
     * @param integer             $id to update
     */
    public function __construct(DIInterface $di, $id)
    {
        parent::__construct($di);
        $book = $this->getItemDetails($id);

        $categories = explode(", ", $book->categories);


        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Redigera bok",
            ],
            [
                "title" => [
                    "label"         => "Titel*",
                    "type"          => "text",
                    "class"         => "form-control",
                    "validation"    => ["not_empty"],
                    "value"         => $book->title
                ],

                "author" => [
                    "label"         => "Författare*",
                    "type"          => "text",
                    "class"         => "form-control",
                    "validation"    => ["not_empty"],
                    "value"         => $book->author
                ],

                "publisher" => [
                    "label"         => "Förlag",
                    "type"          => "text",
                    "class"         => "form-control",
                    // "validation"    => ["not_empty"],
                    "value"         => $book->publisher
                ],
                "categories" => [
                    "type"          => "select-multiple",
                    "label"         => "Välj en eller flera kategorier",
                    "class"         => "form-control",
                    // "description"   => "Here you can place a description.",
                    "size"          => 10,
                    "options"       => [
                        "Ingen_kategori"   => "Ingen",
                        "Skönlitteratur"             => "Skönlitteratur",
                        "Deckare"          => "Deckare",
                        "Fantasy"           => "Fantasy",
                        "Sci-Fi"            => "Sci-Fi",
                        "Barn"               => "Barn",
                        "Medicin"           => "Medicin",
                        "Fakta"             => "Fakta",
                        "Mat"              => "Mat",
                        "Inredning"            => "Inredning",
                    ],
                    "checked"   => $categories,
                ],

                "id" => [
                    "type"      => "hidden",
                    "value"     => $book->id
                ],

                "submit" => [
                    "type"          => "submit",
                    "class"         => "btn btn-primary",
                    "value"         => "Utför redigering",
                    "callback"      => [$this, "callbackSubmit"]
                ],

                "delete" => [
                    "type"          => "submit",
                    "class"         => "btn btn-danger",
                    "value"         => "Ta bort",
                    "callback"      => [$this, "callbackDelete"]
                ],

                "Återställ" => [
                    "type"      => "reset",
                    "class"     => "btn btn-default"
                ],
            ]
        );
    }



    /**
     * Get details on item to load form with.
     *
     * @param integer $id get details on item with id.
     *
     * @return object true if okey, false if something went wrong.
     */
    public function getItemDetails($id)
    {
        $book = new Book();
        $book->setDb($this->di->get("db"));
        $book->find("id", $id);
        return $book;
    }



    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return boolean true if okey, false if something went wrong.
     */
    public function callbackSubmit()
    {
        // $book = new Book();
        // $book->setDb($this->di->get("db"));
        // $book->find("id", $this->form->value("id"));
        // $book->column1 = $this->form->value("title");
        // $book->column2 = $this->form->value("column2");
        // $book->save();
        // $this->di->get("response")->redirect("book/update/{$book->id}");
        $book = new Book();
        $book->setDb($this->di->get("db"));
        $book->find("id", $this->form->value("id"));

        $book->title  = $this->form->value("title");
        $book->author = $this->form->value("author");
        $book->publisher = $this->form->value("publisher");
        $categories = $this->form->value("categories");
        $categories = implode(", ", $categories);
        $book->categories = $categories;
        $book->save();

        $this->form->addOutput($book->title . " redigerad");

        // $this->di->get("response")->redirect("book/view-all");
        return true;
    }

    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return boolean true if okey, false if something went wrong.
     */
    public function callbackDelete()
    {
        // $book = new Book();
        // $book->setDb($this->di->get("db"));
        // $book->find("id", $this->form->value("id"));
        // $book->column1 = $this->form->value("title");
        // $book->column2 = $this->form->value("column2");
        // $book->save();
        // $this->di->get("response")->redirect("book/update/{$book->id}");
        $book = new Book();
        $book->setDb($this->di->get("db"));
        $book->find("id", $this->form->value("id"));
        $book->delete();

        // $this->form->addOutput($book->title . " redigerad");

        $this->di->get("response")->redirect("book/view-all");
        // return true;
    }
}
