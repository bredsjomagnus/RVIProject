<?php

namespace Maaa16\Content\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \Maaa16\Content\Content;

// use \Maaa16\Content\ContentFactory;

/**
 * Form to create an item.
 */
class CreateContentForm extends FormModel
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
                "legend" => "Lägg till nytt innehåll",
            ],
            [
                "title" => [
                    "label"         => "Titel*",
                    "type"          => "text",
                    "class"         => "form-control",
                    // "validation"    => ["not_empty"],
                ],

                "type" => [
                    "label"         => "Sort/Typ",
                    "type"          => "text",
                    "class"         => "form-control",
                    "value"         => "article",
                    "readonly"      => true,
                    // "validation"    => ["not_empty"],
                ],
                "status" => [
                    "type"          => "select",
                    "label"         => "Välj status publiserad/inte publiserad",
                    "class"         => "form-control",
                    // "description"   => "Here you can place a description.",
                    "size"          => 2,
                    "options"       => [
                        "notPublished"      => "Inte publiserad",
                        "published"         => "Publiserad",
                    ],
                    "value"   => "notPublished",
                ],
                "filter" => [
                    "label"         => "Filter",
                    "type"          => "text",
                    "class"         => "form-control",
                    "value"         => "markdown",
                    "readonly"      => true,
                    // "validation"    => ["not_empty"],
                ],

                "data" => [
                    "label"         => "Text",
                    "type"          => "textarea",
                    "class"         => "form-control"
                ],

                "submit" => [
                    "type"          => "submit",
                    "class"         => "btn btn-primary",
                    "value"         => "Lägg till innehåll",
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
        $title = $this->form->value("title");
        if ($title == "") {
            $this->form->addOutput("Title måste anges");
            return false;
        }
        $slug = $this->di->get("contentFactory")->slugify($title);
        $content = new Content();
        $content->setDb($this->di->get("db"));

        $content->title  = $this->form->value("title");
        $content->slug  = $slug;
        $content->type = $this->form->value("type");
        $content->filter = $this->form->value("filter");
        $content->status = $this->form->value("status");
        $content->data = $this->form->value("data");
        $content->save();

        $this->form->addOutput($content->title . " tillagd i databasen");

        // $this->di->get("response")->redirect("book");
        return true;
    }
}
