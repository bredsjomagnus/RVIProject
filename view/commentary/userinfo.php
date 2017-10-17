<?php
namespace Anax\View;

use \Anax\User\User;
use \Maaa16\Commentary\AnswerSumView;
use \Maaa16\Commentary\ArticleVotes;

$comm   = $this->di->get("comm");
$db     = $this->di->get("db");

$userpage = new User();
$userpage->setDb($db);
$userpage->find("id", $uid);

?>
<div class="container">

            <div class="row">

                <div class="col-md-12">
                    <?= $tagbar ?>
                    <br>
                    <br>
                    <a href='<?= url('commentary/articles/alla')?>'>Tillbaka</a>
                    <!-- <h4>Frågor - <?= $tag ?></h4> -->

                </div>
            </div>
            <h4><?= $userpage->username ?></h4>
            <!-- <?= var_dump($articleview) ?> -->
            <div class="row">
                <div class="col-md-6">
                    <table class='table'>
                        <thead>
                            <tr>
                                <th>Svar</th>
                                <th>Rang</th>
                                <th>Röster</th>
                                <th>Ställt frågor</th>
                            </tr>
                        </thead>
                        <?php foreach ($articleview as $article) : ?>
                            <?php
                            $user = new User();
                            $user->setDb($db);
                            $user->find("id", $article->userid);

                            $answersumview = new AnswerSumView();
                            $answersumview->setDb($db);
                            $answers = ($answersumview->find("articleid", $article->articleid)) ? $answersumview->numbanswers : '0';

                            $articlevotesum             = $comm->getArticleVoteSum($article->articleid);
                            $totnumbofarticlevotes      = $comm->getTotNumbOfAricleVotes($article->articleid);

                            $articlevotesum = ($articlevotesum == 0) ? 0 : $articlevotesum;
                            ?>
                            <tr>
                                <td><?= $answers ?></td>
                                <td><?= $articlevotesum ?></td>
                                <td><?= $totnumbofarticlevotes ?></td>
                                <td>
                                    <a href='<?= url('commentary/article/'.$article->articleid) ?>'><?= $article->title ?></a>
                                    <br />
                                    <?php
                                    $tagpaths = explode(", ", $article->tagpaths);
                                    $tagnames = explode(", ", $article->tags);
                                    for ($x = 0; $x < count($tagpaths); $x = $x +1) {
                                        echo "<span><a class='tags' href='".url('commentary/articles/'.$tagpaths[$x])."' >".$tagnames[$x]."</a></span>&nbsp;";
                                    }
                                    ?>
                                    <br />
                                    <span class='floatright author'>Ställd <?= substr($article->created, 0, 16) ?> av <a href='<?= url('commentary/userinfo/'.$article->userid) ?>'><?= $article->username ?></a></span>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <!-- /articles -->


                <div class="col-md-6">
                    <table class='table'>
                        <thead>
                            <tr>
                                <th>Svarat på frågor</th>
                                <th></th>
                            </tr>
                        </thead>
                        <?php foreach ($answerview as $answer) : ?>
                            <?php
                            $user = new User();
                            $user->setDb($db);
                            $user->find("id", $answer->userid);

                            // $answersumview = new AnswerSumView();
                            // $answersumview->setDb($db);
                            // $answers = ($answersumview->find("articleid", $article->articleid)) ? $answersumview->numbanswers : '0';
                            ?>
                            <tr>
                                <!-- <td><?= $answers ?></td> -->
                                <td>
                                    <a href='<?= url('commentary/article/'.$answer->articleid) ?>'><?= $answer->title ?></a>
                                    <br />
                                    <?php
                                    $tagpaths = explode(", ", $answer->tagpaths);
                                    $tagnames = explode(", ", $answer->tags);
                                    for ($x = 0; $x < count($tagpaths); $x = $x +1) {
                                        echo "<span><a class='tags' href='".url('commentary/articles/'.$tagpaths[$x])."' >".$tagnames[$x]."</a></span>&nbsp;";
                                    }
                                    ?>
                                    <br />
                                    <span class='floatright author'>Ställd <?= substr($answer->created, 0, 16) ?> av <a href='<?= url('commentary/userinfo/'.$answer->articleuserid) ?>'><?= $answer->username ?></a></span>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>





</div>
