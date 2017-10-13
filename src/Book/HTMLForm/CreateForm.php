<?php

namespace Anax\Book\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \Anax\Book\Book;

/**
 * Form to create an item.
 */
class CreateForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Anax\DI\DIInterface $di a service container
     */
    public function __construct(DIInterface $di)
    {
        parent::__construct($di);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Lägg till ny bok",
            ],
            [
                "title" => [
                    "label"         => "Titel*",
                    "type"          => "text",
                    "class"         => "form-control",
                    // "validation"    => ["not_empty"],
                ],

                "author" => [
                    "label"         => "Författare*",
                    "type"          => "text",
                    "class"         => "form-control",
                    // "validation"    => ["not_empty"],
                ],

                "publisher" => [
                    "label"         => "Förlag",
                    "type"          => "text",
                    "class"         => "form-control",
                    // "validation"    => ["not_empty"],
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
                    "checked"   => ["not_categorised"],
                ],

                "submit" => [
                    "type"          => "submit",
                    "class"         => "btn btn-primary",
                    "value"         => "Lägg till bok",
                    "callback"      => [$this, "callbackSubmit"]
                ],
            ]
        );
    }



    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return boolean true if okey, false if something went wrong.
     */
    public function callbackSubmit()
    {
        if ($this->form->value("title") == "" || $this->form->value("author") == "") {
            $this->form->addOutput("Både titel och författare måste anges");
            return false;
        }

        $book = new Book();
        $book->setDb($this->di->get("db"));

        $book->title  = $this->form->value("title");
        $book->author = $this->form->value("author");
        $book->publisher = $this->form->value("publisher");
        $categories = $this->form->value("categories");
        $categories = implode(", ", $categories);
        $book->categories = $categories;
        $book->save();

        $this->form->addOutput($book->title . " tillagd i databasen");

        // $this->di->get("response")->redirect("book");
        return true;
    }
}
