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
        <!-- <?= var_dump($useractivity) ?><br>
        <?= var_dump($useractivityall) ?> -->
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
                        <th>Rang</th>
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
                        <th>Rang</th>
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
    <!-- /rad 1 -->

    <div class="row">
        <div class="col-md-6">
            <h3>De fem mest aktiva användarna</h3>
            <table class='table'>
                <thead>
                    <tr>
                        <th colspan=2>Användare</th>
                        <th>Frågor</th>
                        <th>Svar</th>
                        <th>Kommentarer</th>
                        <th>Aktivitet</th>
                        <th>Rang</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($useractivity as $id => $activity) : ?>
                    <?php
                    $activityuser = new User();
                    $activityuser->setDb($db);
                    $activityuser->find("id", $id);

                    $default = "http://i.imgur.com/CrOKsOd.png"; // Optional
                    $gravatar = new \Maaa16\Gravatar\Gravatar(($activityuser->email !== null) ? $activityuser->email : 'na@na.na', $default);
                    $gravatar->size = 50;
                    $gravatar->rating = "G";
                    $gravatar->border = "FF0000";

                    $numbarticles           = $comm->getUserNumbArticles($id);
                    $numbanswers            = $comm->getUserNumbAnswers($id);
                    $numbarticlecomments    = $comm->getUserNumbArticleComments($id);
                    $numbanswercomments     = $comm->getUserNumbAnswerComments($id);

                    $numbcomments = intval($numbarticlecomments) + intval($numbanswercomments);

                    $rank                   = $comm->getUserRank($id);
                    // $rank                   = $comm->setUserRank($id);

                    ?>
                    <tr>
                        <td><?=$gravatar->toHTML()?></td>
                        <td>
                            <a href='<?= url('commentary/userinfo/'.$id) ?>'><?= $activityuser->firstname." ".$activityuser->surname ?></a>
                        </td>
                        <td align='center'><?= $numbarticles ?></td>
                        <td><?= $numbanswers ?></td>
                        <td><?= $numbcomments ?></td>
                        <td><?= $activity ?></td>
                        <td><?= $rank ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!-- /rad2 kolumn1 -->

        <div class="col-md-6">
            <h3>De fem högst rankade användarna</h3>
            <table class='table'>
                <thead>
                    <tr>
                        <th colspan=2>Användare</th>
                        <th>Frågor</th>
                        <th>Svar</th>
                        <th>Kommentarer</th>
                        <th>Aktivitet</th>
                        <th>Rang</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($userbyrank as $rankuser) : ?>
                    <?php
                    $default = "http://i.imgur.com/CrOKsOd.png"; // Optional
                    $gravatar = new \Maaa16\Gravatar\Gravatar(($rankuser->email !== null) ? $rankuser->email : 'na@na.na', $default);
                    $gravatar->size = 50;
                    $gravatar->rating = "G";
                    $gravatar->border = "FF0000";

                    $numbarticles           = $comm->getUserNumbArticles($rankuser->id);
                    $numbanswers            = $comm->getUserNumbAnswers($rankuser->id);
                    $numbarticlecomments    = $comm->getUserNumbArticleComments($rankuser->id);
                    $numbanswercomments     = $comm->getUserNumbAnswerComments($rankuser->id);

                    $numbcomments = intval($numbarticlecomments) + intval($numbanswercomments);

                    $rank                   = $comm->getUserRank($rankuser->id);
                    // $rank                   = $comm->setUserRank($id);

                    ?>
                    <tr>
                        <td><?=$gravatar->toHTML()?></td>
                        <td>
                            <a href='<?= url('commentary/userinfo/'.$rankuser->id) ?>'><?= $rankuser->firstname." ".$rankuser->surname ?></a>
                        </td>
                        <td align='center'><?= $numbarticles ?></td>
                        <td><?= $numbanswers ?></td>
                        <td><?= $numbcomments ?></td>
                        <td><?= $useractivityall[$rankuser->id] ?></td>
                        <td><?= $rank ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /rad2 -->
</div>
