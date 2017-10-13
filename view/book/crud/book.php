<div class="container">
    <h3>BOKBAS</h3>
    <div class="row">
        <div class="col-md-12">
            <a href=<?= $this->di->get("url")->create("book/view-all") ?>>Alla böcker</a> |
            <a href=<?= $this->di->get("url")->create("book/add-book") ?>>Lägg till bok</a> |
            <a href=<?= $this->di->get("url")->create("book/delete") ?>>Ta bort böcker</a>
        </div>
    </div>
</div>
