<?php
namespace Anax\View;

use \Anax\User\User;
use \Maaa16\Commentary\AnswerSumView;

$db         = $this->di->get("db");
$session    = $this->di->get("session");
?>
<div class="container">
    <div class="row">

        <div class="col-md-12">
            <?= $tagbar ?>
            <br>
            <br>
            <h4>Frågor - <?= $tag ?></h4>

        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <a href='<?= url('commentary/createarticle') ?>'> + Lägg till fråga</a>
        </div>
    </div>
    <!-- <?= var_dump($articles) ?> -->
    <div class="row">
        <div class="col-md-12">
            <table class='table'>
                <thead>
                    <tr>
                        <th>Svar</th>
                        <th>Fråga</th>
                    </tr>
                </thead>
                <?php foreach ($articles as $article) : ?>
                    <?php
                    $user = new User();
                    $user->setDb($db);
                    $user->find("id", $article['user']);

                    $answersumview = new AnswerSumView();
                    $answersumview->setDb($db);
                    $answers = ($answersumview->find("articleid", $article['id'])) ? $answersumview->numbanswers : '0';
                    ?>
                    <tr>
                        <td><?= $answers ?></td>
                        <td>
                            <a href='<?= url('commentary/article/'.$article['id']) ?>'><?= $article['title'] ?></a>
                            <br />
                            <?php
                            $tagpaths = explode(", ", $article['tagpaths']);
                            $tagnames = explode(", ", $article['tags']);
                            for($x = 0; $x < count($tagpaths); $x = $x +1){
                                echo "<span><a class='tags' href='".url('commentary/articles/'.$tagpaths[$x])."' >".$tagnames[$x]."</a></span>&nbsp;";
                            }
                            ?>
                            <br />
                            <span class='floatright author'>Ställd <?= substr($article['created'], 0, 16) ?> av <a href='<?= url('commentary/userinfo/'.$user->id) ?>'><?= $user->username ?></a></span>
                        </td>
                        <!-- <td></td> -->
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>
