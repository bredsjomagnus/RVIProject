<?php

namespace Anax\View;

use \Anax\User\User;

$db                     = $this->di->get("db");
$session                = $this->di->get("session");
$userid                 = $session->get("userid");
$addanswercommenturl = url('commentary/addarticlecommentprocess');
// $addanswercomment = "<a id='addanswercomment' href='commentary/addanswercomment?userid=".$userid."&articleid=".$article['article']->id."'</a>+ lägg till kommentar</a>";
$addanswercomment = "<a id='addanswercomment' href='#'</a>+ lägg till kommentar</a>";



$author = new User();
$author->setDb($db);
$author->find("id", $article['article']->user);
?>

<div class="container">
    <a href='<?= url('commentary/articles/alla')?>'>Tillbaka</a>
    <div class="row">
        <div class="col-md-8">
            <h2><?= $article['article']->title ?></h2>
            <?= $article['articledata']->text ?>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <?php
            $edit = "";
            if($article['article']->user == $session->get('userid')) {
                $edit = " - <a href='".url('commentary/updatearticle/'.$article['article']->id)."'>Ändra</a>";
            }
            ?>
            <?php foreach(explode(", ", $article['article']->tags) as $tag) : ?>
                <span><a class='tags' href='<?= url('commentary/articles/'.$tag) ?>'><?= $tag ?></a></span>
            <?php endforeach; ?>
        </div>
        <div class="col-md-5">
            <span class='author'>Ställd <?= substr($article['article']->created, 0, 16) ?> av <a href='#'><?= $author->username ?></a><?= $edit ?></span>
        </div>
    </div>
    <br>
    <div class="row">
        <?php if($hasAnswerComments) : ?>
            <div class="col-md-8 answercommentdiv">
                <table class='answercommenttable'>
                <?php foreach($answercomments as $answercomment) : ?>
                    <?php
                    $answercommentauthor = new User();
                    $answercommentauthor->setDb($db);
                    $answercommentauthor->find('id', $answercomment->user);
                    ?>

                    <tr>
                        <td class='answercomment'><?= $answercomment->data ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td class='answercommentauthor' valign='top' align='right'><?= $answercomment->created ?> - <a><?= $answercommentauthor->username ?></a></td>
                    </tr>
                <?php endforeach; ?>
                </table>
            </div>
        <?php endif; ?>
    </div>
    <br>
    <!-- ARTIKELKOMMENTAR -->
    <div class="row">
        <div class="col-md-12">
            <!-- ADD COMMENT COLLAPSE -->
            <a class='commentcollapsepointer' data-toggle="collapse" data-target="#addarticlecomment">+ Lägg till kommentar</a>
            <div id="addarticlecomment" class="collapse">
                <form action='<?= $addanswercommenturl ?>' method="POST">
                    <textarea class='form-control' name='data' value='' placeholder='Skriv kommentar här!'></textarea>
                    <br />
                    <input type='hidden' name='user' value='<?= $userid ?>'>
                    <input type='hidden' name='commentto' value='<?= $article['article']->id ?>'>
                    <input class='btn btn-default' type='submit' name='addarticlecommentbtn' value='Lägg till kommentar'>
                </form>
            </div>
        </div>
    </div>

    <br>
    <br>
    <table class='answertable'>
        <thead>
            <tr>
                <th class='avatarcolumn'>
                </th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($answers as $answer) : ?>
            <?php
            $answeruser = new User();
            $answeruser->setDb($db);
            $answeruser->find("id", $answer->user);

            $default = "http://i.imgur.com/CrOKsOd.png"; // Optional
            $gravatar = new \Maaa16\Gravatar\Gravatar(($answeruser->email !== null) ? $answeruser->email : 'na@na.na', $default);
            $gravatar->size = 50;
            $gravatar->rating = "G";
            $gravatar->border = "FF0000";
            $filteredcomment = $this->di->get("textfilter")->markdown($answer->data);
            $answerlikes = explode(",", $answer->likes);
            $likeanswereditline = "";
            if ($this->di->get("session")->get('userid') == $answer->user) {
                $editcommenturl = $this->di->get("url")->create("editcomment") ."?id=". $answer->id;
                $likeanswereditline = "<a href='".$editcommenturl."'>redigera</a>";
            } else if ($this->di->get("session")->has('user')) {
                $addlikeprocessurl = $this->di->get("url")->create("addlikeprocess")."?userid=".$this->di->get("session")->get('userid')."&commentid=".$answer->id;
                if (!in_array($this->di->get("session")->get('userid'), $answerlikes)) {
                    $likeanswereditline = "<a href='".$addlikeprocessurl."'>Gilla</a>&nbsp&nbsp&nbsp";
                } else {
                    $likeanswereditline = "<span>Gilla</span>&nbsp&nbsp&nbsp";
                }
            }
            $updated = "";
            if ($answer->updated !== null) {
                $updated = "<span class='text-muted'>REDIGERAD: " . $answer->updated."</span>";
                $likeanswereditline .= "&nbsp&nbsp&nbsp".$updated;
            }

            $numberlikes = "";
            // $likersusernames = "";
            // if (count($answerlikes) > 0 && $answerlikes[0] != "") {
            //     $likersusernames = $this->di->get("comm")->getLikersUsernames($answerlikes);
            //     $numberlikes = "<div class='likecircle' data-toggle='tooltip' data-placement='right' title='".$likersusernames."'>+".count($answerlikes)."</div>";
            // }
            ?>
            <tr>
                            <td valign=top><?=$gravatar->toHTML()?></td>
                            <td><?=$filteredcomment?></td>
                        </tr>
                        <tr class='commentarydottedunderline' >
                            <td></td>
                            <td>
                                <?=$numberlikes?>
                            </div>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><?=$likeanswereditline?></td>
                        </tr>
                        <tr>
                            <td class='commentaryunderline'></td>
                            <td class='text-muted commentaryunderline'><i><?=$answer->created?>&nbsp&nbsp&nbsp<?=$answeruser->username?>, <?= $answeruser->email ?></i></td>
                        </tr>
                        <!-- SVARSKOMMENTARKOMMENTAR -->


                        <!-- ADD COMMENT COLLAPSE -->
                        <tr>
                            <td colspan=2><a class='commentcollapsepointer' data-toggle="collapse" data-target="#addanswercomment<?=$answeruser->id?>">+ Lägg till kommentar</a></td>
                        </tr>



                        <tr>
                            <td colspan=2>
                                <div id="addanswercomment<?=$answeruser->id?>" class="collapse">
                                    <form action='<?= $addanswercommenturl ?>' method="POST">
                                        <textarea class='form-control' name='data' value='' placeholder='Skriv kommentar här!'></textarea>
                                        <br />
                                        <input type='hidden' name='user' value='<?= $userid ?>'>
                                        <input type='hidden' name='commentto' value='<?= $answeruser->id ?>'>
                                        <input class='btn btn-default' type='submit' name='addanswercommentbtn' value='Lägg till kommentar'>
                                    </form>
                                </div>
                            </td>
                        </tr>

        <?php endforeach; ?>
        </tbody>
    </table>
    <div class="row">
        <div class="col-md-8">
            <h4>Ditt svar</h4>
            <?= $form ?>
        </div>
    </div>

</div>
