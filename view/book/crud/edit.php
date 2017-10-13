<?php

namespace Anax\View;

/**
 * View to create a new book.
 */
// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());
// $id = isset($id) ? $id : null;
?>
<div class="container">
    <h3>REDIGERA BOK</h3>
    <div class="row">
        <div class="col-md-12">
            <a href=<?= $this->di->get("url")->create("book/view-all") ?>>Böcker</a> |
            <a href=<?= $this->di->get("url")->create("book/add-book") ?>>Lägg till bok</a> |
            <a href=<?= $this->di->get("url")->create("book/delete") ?>>Ta bort böcker</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= $form ?>
        </div>
    </div>
</div>
