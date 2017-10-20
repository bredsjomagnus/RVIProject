<?php
namespace Anax\View;

use \Anax\User\User;
use \Maaa16\Commentary\Article;
use \Maaa16\Commentary\AnswerSumView;

$db         = $this->di->get("db");
$session    = $this->di->get("session");
$comm       = $this->di->get("comm");
?>
<div class="container">
    <div class="row">

        <div class="col-md-12">
            <?= $tagbar ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <h3>De senaste fem frågorna</h3>
            <table class='table'>
                <thead>
                    <tr>
                        <th>Svar</th>
                        <th>Rank</th>
                        <th>Röster</th>
                        <th>Kommentarer</th>
                        <th>Fråga</th>
                    </tr>
                </thead>
                <?php foreach ($articles as $article) : ?>
                    <?php
                    $user = new User();
                    $user->setDb($db);
                    $user->find("id", $article['user']);


                    // $answersumview = new AnswerSumView();
                    // $answersumview->setDb($db);
                    $answersum = $comm->articleAnswerSum($article['id']);
                    $answers = (intval($answersum) != 0) ? $answersum : '0';
                    $articlevotesum             = intval($comm->getArticleVoteSum($article['id']) != 0) ?
                                                    $comm->getArticleVoteSum($article['id']) :
                                                    '0';
                    $totnumbofarticlevotes      = intval($comm->getTotNumbOfAricleVotes($article['id']) != 0) ?
                                                    $comm->getTotNumbOfAricleVotes($article['id']) :
                                                    '0';
                    $totnumbofarticlecomments   = $comm->getTotNumbOfArticleComments($article['id']);
                    ?>
                    <tr>
                        <td><?= $answers ?></td>
                        <td><?= $articlevotesum ?></td>
                        <td><?= $totnumbofarticlevotes ?></td>
                        <td><?= $totnumbofarticlecomments ?></td><td>
                            <a href='<?= url('commentary/article/'.$article['id']) ?>'><?= $article['title'] ?></a>
                            <br />
                            <?php
                            $tagpaths = explode(", ", $article['tagpaths']);
                            $tagnames = explode(", ", $article['tags']);
                            for ($x = 0; $x < count($tagpaths); $x = $x +1) {
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
        <div class="col-md-6">
            <h3>De senaste fem svaren</h3>
            <table class='table'>
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Röster</th>
                        <th>Kommentarer</th>
                        <th>Svar på fråga</th>
                    </tr>
                </thead>
                <?php foreach ($allanswers as $answer) : ?>
                    <?php
                    $answeruser = new User();
                    $answeruser->setDb($db);
                    $answeruser->find("id", $answer->user);

                    $answertoarticle = new Article();
                    $answertoarticle->setDb($db);
                    $answertoarticle->find("id", $answer->answerto);
                    // $answersumview = new AnswerSumView();
                    // $answersumview->setDb($db);
                    $answersum = $comm->articleAnswerSum($answertoarticle->id);
                    $answers = (intval($answersum) != 0) ? $answersum : '0';

                    $answervotesum              = intval($comm->getAnswerVoteSum($answer->id) != 0) ?
                                                    $comm->getAnswerVoteSum($answer->id) :
                                                    '0';
                    $totnumbofanswervotes       = $comm->getTotNumbOfAnswerVotes($answer->id);
                    $totnumbofanswercomments    = $comm->getTotNumbOfAnswerComments($answer->id);
                    ?>
                    <tr>
                        <td><?= $answervotesum ?></td>
                        <td><?= $totnumbofanswervotes ?></td>
                        <td><?= $totnumbofanswercomments ?></td>
                        <td>
                            <a href='<?= url('commentary/article/'.$answertoarticle->id) ?>'><?= $answertoarticle->title ?></a>
                            <br />
                            <?php
                            $tagpaths = explode(", ", $answertoarticle->tagpaths);
                            $tagnames = explode(", ", $answertoarticle->tags);
                            for ($x = 0; $x < count($tagpaths); $x = $x +1) {
                                echo "<span><a class='tags' href='".url('commentary/articles/'.$tagpaths[$x])."' >".$tagnames[$x]."</a></span>&nbsp;";
                            }
                            ?>
                            <br />
                            <span class='floatright author'>Svarat <?= substr($answertoarticle->created, 0, 16) ?> av <a href='<?= url('commentary/userinfo/'.$answeruser->id) ?>'><?= $answeruser->username ?></a></span>
                        </td>
                        <!-- <td></td> -->
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>
