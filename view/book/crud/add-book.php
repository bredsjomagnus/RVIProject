<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3>LÄGG TILL BOK</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <a href=<?= $this->di->get("url")->create("book") ?>>Tillbaka</a> |
            <a href=<?= $this->di->get("url")->create("book/view-all") ?>>Alla böcker</a> |
            <a href=<?= $this->di->get("url")->create("book/delete") ?>>Ta bort böcker</a>
            <br /><br />
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= $form ?>
            <i class='text-muted'>* Titel och författare måste anges</i>
        </div>
    </div>
</div>
