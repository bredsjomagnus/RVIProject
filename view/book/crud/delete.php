<?php

namespace Anax\View;

/**
 * View to create a new book.
 */
// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());
// $id = isset($id) ? $id : null;
$books = isset($books) ? $books : null;
?>
<?php if (!$books) : ?>
    <div class="container">
        <h3>TA BORT BÖCKER</h3>
        <div class="row">
            <div class="col-md-12">
                <a href=<?= $this->di->get("url")->create("book") ?>>Tillbaka</a> |
                <a href=<?= $this->di->get("url")->create("book/view-all") ?>>Alla böcker</a> |
                <a href=<?= $this->di->get("url")->create("book/add-book") ?>>Lägg till bok</a>
            </div>
        </div>
        <p>Det finns inga böcker i databasen.</p>
    </div>
<?php
    return;
endif;?>
<div class="container">
    <h3>TA BORT BÖCKER</h3>
    <div class="row">
        <div class="col-md-12">
            <a href=<?= $this->di->get("url")->create("book") ?>>Tillbaka</a> |
            <a href=<?= $this->di->get("url")->create("book/view-all") ?>>Böcker</a> |
            <a href=<?= $this->di->get("url")->create("book/add-book") ?>>Lägg till bok</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= $form ?>
        </div>
    </div>
</div>
