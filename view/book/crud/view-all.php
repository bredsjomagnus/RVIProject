<?php

namespace Anax\View;

/**
 * View to display all books.
 */
// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

// Gather incoming variables and use default values if not set
$books = isset($books) ? $books : null;

// Create urls for navigation
// $urlToCreate = url("book/create");
// $urlToDelete = url("book/delete");



?>
<?php if (!$books) : ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3>ALLA BÖCKER</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <a href=<?= $this->di->get("url")->create("book") ?>>Tillbaka</a> |
                <a href=<?= $this->di->get("url")->create("book/add-book") ?>>Lägg till bok</a> |
                <a href=<?= $this->di->get("url")->create("book/delete") ?>>Ta bort böcker</a>
                <br /><br />
            </div>
        </div>
        <p>Det finns inga böcker i databasen.</p>
    </div>
<?php
    return;
endif;?>


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3>ALLA BÖCKER</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <a href=<?= $this->di->get("url")->create("book") ?>>Tillbaka</a> |
            <a href=<?= $this->di->get("url")->create("book/add-book") ?>>Lägg till bok</a> |
            <a href=<?= $this->di->get("url")->create("book/delete") ?>>Ta bort böcker</a>
            <br /><br />
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class='table'>
                <tr>
                    <!-- <th>Id</th> -->
                    <th>Titel</th>
                    <th>Författare</th>
                    <th>Förlag</th>
                    <th>Kategorier</th>
                </tr>
                <?php foreach ($books as $book) : ?>
                <tr>
                    <td><a href="<?= url("book/edit/{$book->id}"); ?>"><?= $book->title ?></a></td>
                    <td><?= $book->author ?></td>
                    <td><?= $book->publisher ?></td>
                    <td><?= $book->categories ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>

<!-- <p>
    <a href="<?= $urlToCreate ?>">Create</a> |
    <a href="<?= $urlToDelete ?>">Delete</a>
</p> -->
