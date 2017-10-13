<?php
namespace Anax\View;

use \Anax\User\User;

$db = $this->di->get("db");

?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h4>Frågor - <?= $tag ?></h4>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <a href='<?= url('commentary/createarticle') ?>'> + Lägg till fråga</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class='table'>
                <thead>
                    <tr>
                        <th></th>
                        <!-- <th></th> -->
                    </tr>
                </thead>
                <?php foreach($articles as $article) : ?>
                    <?php
                    $user = new User();
                    $user->setDb($db);
                    $user->find("id", $article->user);
                    ?>
                    <tr>
                        <td>
                            <a href='<?= url('commentary/article/'.$article->id) ?>'><?= $article->title ?></a>
                            <br />
                            <?php foreach(explode(", ", $article->tags) as $tag) : ?>
                                <span><a class='tags' href='<?= url('commentary/articles/'.$tag) ?>'><?= $tag ?></a></span>
                            <?php endforeach; ?>
                            <br />
                            <span class='floatright author'>Ställd <?= $article->created ?> av <a href='#'><?= $user->username ?></a></span>
                        </td>
                        <!-- <td></td> -->
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>
