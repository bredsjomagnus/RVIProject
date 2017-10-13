<?php

namespace Maaa16\Content\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \Maaa16\Content\Content;

/**
 * Form to update an item.
 */
class UpdateContentForm extends FormModel
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
        $content = $this->getItemDetails($id);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Redigera innehåll",
            ],
            [
                "title" => [
                    "label"         => "Titel*",
                    "type"          => "text",
                    "class"         => "form-control",
                    "validation"    => ["not_empty"],
                    "value"         => $content->title
                ],

                "status" => [
                    "type"          => "select",
                    "label"         => "Välj status",
                    "class"         => "form-control",
                    "description"   => "<i>Ett publiserat innehåll visas för användaren.</i>",
                    "size"          => 2,
                    "options"       => [
                        "notPublished"      => "Inte publiserad",
                        "published"         => "Publiserad",
                    ],
                    "value"         => $content->status,
                ],
                "data" => [
                    "label"         => "Text",
                    "type"          => "textarea",
                    "class"         => "form-control",
                    "value"         => $content->data
                ],

                "id" => [
                    "type"      => "hidden",
                    "value"     => $content->id
                ],

                "submit" => [
                    "type"          => "submit",
                    "class"         => "btn btn-primary",
                    "value"         => "Redigering",
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
        $content = new Content();
        $content->setDb($this->di->get("db"));
        $content->find("id", $id);
        return $content;
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
        $content = new Content();
        $content->setDb($this->di->get("db"));
        $content->find("id", $this->form->value("id"));

        $content->title  = $this->form->value("title");
        $slug = $this->di->get("contentFactory")->slugify($this->form->value("title"));
        $content->slug = $slug;
        $content->status  = $this->form->value("status");
        $content->data = $this->form->value("data");
        $content->updated = date("Y-m-d H:i:s");
        $content->save();

        // $this->form->addOutput($content->title . " redigerad");

        $this->di->get("response")->redirect("admincontent");
        // return true;
    }

    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return boolean true if okey, false if something went wrong.
     */
    public function callbackDelete()
    {
        $content = new Content();
        $content->setDb($this->di->get("db"));
        $content->find("id", $this->form->value("id"));
        $content->deleted = date("Y-m-d H:i:s");
        $content->save();

        $this->di->get("response")->redirect("admincontent");
        // return true;
    }
}
