<?php
namespace Anax\View;

use \Anax\User\User;
use \Maaa16\Commentary\AnswerSumView;
use \Maaa16\Commentary\ArticleVotes;
use \Maaa16\Commentary\Article;

$comm       = $this->di->get("comm");
$db         = $this->di->get("db");
$session    = $this->di->get("session");

$userpage = new User();
$userpage->setDb($db);
$userpage->find("id", $uid);

$default = "http://i.imgur.com/CrOKsOd.png"; // Optional
$gravatar = new \Maaa16\Gravatar\Gravatar(($userpage->email !== null) ? $userpage->email : 'na@na.na', $default);
$gravatar->size = 150;
$gravatar->rating = "G";
$gravatar->border = "FF0000";

$accountlink = ($userpage->id === $session->get("userid")) ?
                    "<a class='btn btn-default' href='".url('accountinfo')."' >
                            <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>&nbsp; Kontouppgifter
                    </a>" :
                    "";

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
            <h4><?= strtoupper($userpage->firstname." ".$userpage->surname." - ".$userpage->username) ?></h4>
            <!-- <?= var_dump($articleview) ?> -->

            <div class="row">
                <div class="col-md-2">
                    <?=$gravatar->toHTML()?>
                    <br>
                    <br>
                    <span class='small'><?= $accountlink ?></span>
                </div>

                <div class="col-md-6">
                    <table class='table'>
                        <thead>
                            <tr class='userinforankheader'>
                                <th>Frågor</th>
                                <th>Svar</th>
                                <th>Kommentarer</th>
                                <th># Röstningar</th>
                                <th>Aktivitet</th>
                                <th>Rang</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td align='center'><?= $numbarticles ?></td>
                                <td><?= $numbanswers ?></td>
                                <td><?= $numbcomments ?></td>
                                <td><?= $totnumberofcomments ?></td>
                                <td><?= $useractivity[$userpage->id] ?></td>
                                <td><?= $rank ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-8">
                    <table class="table">
                        <tr>
                            <td><b>Användarnamn</b></td><td><?= $userpage->username ?></td>
                        </tr>
                        <tr>
                            <td><b>Förnamn</b></td><td><?= $userpage->firstname ?></td>
                        </tr>
                        <tr>
                            <td><b>Efternamn</b></td><td><?= $userpage->surname ?></td>
                        </tr>
                        <tr>
                            <td><b>Email</b></td><td><?= ($userpage->email) ? $userpage->email : "" ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <h5>FRÅGOR</h5>
                    <table class='table userinfotable'>
                        <thead>
                            <tr class='userinfotableheader'>
                                <th># Svar</th>
                                <th>S:a Röst</th>
                                <th># Röst</th>
                                <th>Rang</th>
                                <th>Komm.</th>
                                <th>Fråga</th>
                            </tr>
                        </thead>
                        <?php foreach ($allusersarticles as $article) : ?>
                            <?php
                            $articleuser = new User();
                            $articleuser->setDb($db);
                            $articleuser->find("id", $uid);

                            // $answersumview = new AnswerSumView();
                            // $answersumview->setDb($db);
                            // $answers = ($answersumview->find("articleid", $article->articleid)) ? $answersumview->numbanswers : '0';

                            $answersum = $comm->articleAnswerSum($article->id);
                            $answers = (intval($answersum) != 0) ? $answersum : '0';

                            $articlevotesum             = $comm->getArticleVoteSum($article->id);
                            $totnumbofarticlevotes      = $comm->getTotNumbOfAricleVotes($article->id);
                            $totnumbofarticlecomments   = $comm->getTotNumbOfArticleComments($article->id);

                            $articlerangsum             = $comm->getOneArticleScore($article->id);

                            $articlevotesum = ($articlevotesum == 0) ? 0 : $articlevotesum;
                            ?>
                            <tr>
                                <td><?= $answers ?></td>
                                <td><?= $articlevotesum ?></td>
                                <td><?= $totnumbofarticlevotes ?></td>
                                <td><?= $articlerangsum ?> </td>
                                <td><?= $totnumbofarticlecomments ?></td>
                                <td align='left'>
                                    <a href='<?= url('commentary/article/'.$article->id) ?>'><?= $article->title ?></a>
                                    <br />
                                    <?php
                                    $tagpaths = explode(", ", $article->tagpaths);
                                    $tagnames = explode(", ", $article->tags);
                                    for ($x = 0; $x < count($tagpaths); $x = $x +1) {
                                        echo "<span><a class='tags' href='".url('commentary/articles/'.$tagpaths[$x])."' >".$tagnames[$x]."</a></span>&nbsp;";
                                    }
                                    ?>
                                    <br />
                                    <span class='floatright author'>Ställd <?= substr($article->created, 0, 16) ?> av <a href='<?= url('commentary/userinfo/'.$article->user) ?>'><?= $articleuser->username ?></a></span>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <!-- /articles -->

                <h5>SVAR</h5>
                <div class="col-md-6">
                    <table class='table userinfotable'>
                        <thead>
                            <tr class='userinfotableheader'>
                                <th>Rang</th>
                                <th>Röster</th>
                                <th>Kommentarer</th>
                                <th>Rang</th>
                                <th>Svarat på fråga</th>

                            </tr>
                        </thead>
                        <?php foreach ($allusersanswers as $answer) : ?>
                            <?php
                            $answeruser = new User();
                            $answeruser->setDb($db);
                            $answeruser->find("id", $uid);

                            $article = new Article();
                            $article->setDb($db);
                            $article->find("id", $answer->answerto);

                            $answervotesum              = $comm->getAnswerVoteSum($answer->id);
                            $totnumbofanswervotes       = $comm->getTotNumbOfAnswerVotes($answer->id);
                            $totnumbofanswercomments    = $comm->getTotNumbOfAnswerComments($answer->id);

                            $answervotesum = ($answervotesum == 0) ? 0 : $answervotesum;

                            $userinfoanswerrowclass = ($answer->accepted == 'yes') ? 'userinfoanswerrowclass' : '';
                            ?>
                            <tr class='<?= $userinfoanswerrowclass ?>'>
                                <td><?= $answervotesum ?></td>
                                <td><?= $totnumbofanswervotes ?></td>
                                <td><?= $totnumbofanswercomments ?></td>
                                <td><?= $answer->score ?></td>
                                <td align='left'>
                                    <a href='<?= url('commentary/article/'.$article->id) ?>'><?= $article->title ?></a>
                                    <br />
                                    <?php
                                    $tagpaths = explode(", ", $article->tagpaths);
                                    $tagnames = explode(", ", $article->tags);
                                    for ($x = 0; $x < count($tagpaths); $x = $x +1) {
                                        echo "<span><a class='tags' href='".url('commentary/articles/'.$tagpaths[$x])."' >".$tagnames[$x]."</a></span>&nbsp;";
                                    }
                                    ?>
                                    <br />
                                    <span class='floatright author'>Ställd <?= substr($answer->created, 0, 16) ?> av <a href='<?= url('commentary/userinfo/'.$answer->user) ?>'><?= $answeruser->username ?></a></span>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>





</div>
