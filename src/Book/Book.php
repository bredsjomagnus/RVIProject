<?php

namespace Anax\Book;

use \Anax\Database\ActiveRecordModel;

/**
 * A database driven model.
 */
class Book extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "RVDBbook";



    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    // public $image;
    public $title;
    public $author;
    public $publisher;
    public $categories;
    // public $link;
}
