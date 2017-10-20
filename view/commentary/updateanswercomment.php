<div class="container">
    <div class="row">
        <div class="row">
            <div class="col-md-9">
                <h2><?= $article['article']->title ?></h2>
                <?= $article['articledata']->text ?>
            </div>
        </div>
        <div class="col-md-8">
            <?= $form ?>
        </div>
    </div>
</div>
