<?php

namespace Anax\View;

use \Anax\User\User;

$db                     = $this->di->get("db");
$session                = $this->di->get("session");
$userid                 = $session->get("userid");
$addarticlecommenturl = url('commentary/addarticlecommentprocess');
$addanswercommenturl = url('commentary/addanswercommentprocess');
// $addanswercomment = "<a id='addanswercomment' href='commentary/addanswercomment?userid=".$userid."&articleid=".$article['article']->id."'</a>+ lägg till kommentar</a>";
$addanswercomment = "<a id='addanswercomment' href='#'</a>+ lägg till kommentar</a>";

$nousercommsg = $session->has("user") ? "" : "<a class='commentcollapsepointer' href='".url('login')."'>+ Logga in för att kunna kommentera</a>";

$author = new User();
$author->setDb($db);
$author->find("id", $article['article']->user);
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
    <div class="row">
        <div class="col-md-9">
            <h2><?= $article['article']->title ?></h2>
            <?= $article['articledata']->text ?>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <?php
            $edit = "";
            if ($article['article']->user == $session->get('userid')) {
                $edit = " - <a href='".url('commentary/updatearticle/'.$article['article']->id)."'>Ändra</a>";
            }
            ?>
            <?php
            $tagpaths = explode(", ", $article['article']->tagpaths);
            $tagnames = explode(", ", $article['article']->tags);
            for($x = 0; $x < count($tagpaths); $x = $x +1){
                echo "<span><a class='tags' href='".url('commentary/articles/'.$tagpaths[$x])."' >".$tagnames[$x]."</a></span>&nbsp;";
            }
            ?>
            <!-- <?php foreach (explode(", ", $article['article']->tags) as $tag) : ?>
                <span><a class='tags' href='<?= url('commentary/articles/'.$tag) ?>'><?= $tag ?></a></span>
            <?php endforeach; ?> -->
        </div>
        <div class="col-md-5">
            <span class='author'>Ställd <?= substr($article['article']->created, 0, 16) ?> av <a href='<?= url('commentary/userinfo/'.$author->id) ?>'><?= $author->username ?></a><?= $edit ?></span>
        </div>
    </div>
    <br>
    <div class="row">
        <?php if ($hasArticleComments) : ?>
            <div class="col-md-8 articlecommentdiv">
                <table class='articlecommenttable'>
                <?php foreach ($articlecomments as $articlecomment) : ?>
                    <?php
                    $articlecommentauthor = new User();
                    $articlecommentauthor->setDb($db);
                    $articlecommentauthor->find('id', $articlecomment->user);
                    ?>

                    <tr>
                        <td class='articlecomment'><?= $articlecomment->data ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td class='articlecommentauthor articlecomment' valign='top' align='right'><?= $articlecomment->created ?> - <a href='<?= url('commentary/userinfo/'.$articlecommentauthor->id) ?>'><?= $articlecommentauthor->username ?></a></td>
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
            <?php if ($session->has("user")) : ?>
            <!-- ADD COMMENT COLLAPSE -->
            <a class='commentcollapsepointer' data-toggle="collapse" data-target="#addarticlecomment">+ Lägg till kommentar</a>
            <div id="addarticlecomment" class="collapse">
                <form action='<?= $addarticlecommenturl ?>' method="POST">
                    <textarea style='padding: 5px;' class='form-control' name='data' data-provide='markdown' value='' placeholder='Skriv kommentar här!'></textarea>
                    <br />
                    <input type='hidden' name='user' value='<?= $userid ?>'>
                    <input type='hidden' name='commentto' value='<?= $article['article']->id ?>'>
                    <input class='btn btn-default' type='submit' name='addarticlecommentbtn' value='Lägg till kommentar'>
                </form>
            </div>
            <?php endif; ?>
            <?= $nousercommsg ?>
        </div>
    </div>

    <br>
    <br>
    <div class="row">
        <div class="col-md-8">
            <table class='answertable'>
                <thead>
                    <tr>
                        <th class='avatarcolumn'></th>
                        <th class='answersecondcolumn'></th>
                        <th class='answerthirdcolumn'></th>
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
                                    <td colspan=2><?=$filteredcomment?></td>
                                </tr>
                                <tr class='commentarydottedunderline' >
                                    <td></td>
                                    <td colspan=2>
                                        <?=$numberlikes?>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan=2><?=$likeanswereditline?></td>
                                </tr>
                                <tr>
                                    <td class='commentaryunderline'></td>
                                    <td colspan=2 class='text-muted commentaryunderline'><i><?=$answer->created?>&nbsp&nbsp&nbsp<a href='<?= url('commentary/userinfo/'.$answeruser->id) ?>'><?=$answeruser->username?></a>, <?= $answeruser->email ?></i></td>
                                </tr>
                                <!-- SVARSKOMMENTARKOMMENTAR -->

                                <?php foreach ($answercomments as $answercomment) : ?>
                                    <?php if ($answercomment->commentto == $answer->id) : ?>
                                        <?php
                                        $answercommentauthor = new User();
                                        $answercommentauthor->setDb($db);
                                        $answercommentauthor->find('id', $answercomment->user);
                                        ?>

                                        <tr class='answercommenttr'>
                                            <td align='left' class='answercomment' colspan=2><?= $answercomment->data ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                            <td class='answercomment' valign='top' align='right'><?= $answercomment->created ?> - <a href='<?= url('commentary/userinfo/'.$answercommentauthor->id) ?>'><?= $answercommentauthor->username ?></a></td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>

                                <!-- ADD COMMENT COLLAPSE -->
                                <?php
                                $target = "#addanswercomment".$answeruser->id."-".$answer->id;
                                if ($session->has("user")) {

                                    echo "<tr>
                                        <td colspan=3><a class='commentcollapsepointer' data-toggle='collapse' data-target='$target'>+ Lägg till kommentar</a></td>
                                    </tr>";
                                } else {
                                    echo "<tr>
                                        <td colspan=3>$nousercommsg</td>
                                    </tr>";
                                }
                                ?>



                                <!-- ADD ANSWERCOMMENT -->
                                <tr>
                                    <td colspan=3>
                                        <div id='<?="addanswercomment".$answeruser->id."-".$answer->id?>' class="collapse">
                                            <form action='<?= $addanswercommenturl ?>' method="POST">
                                                <textarea style='padding: 5px;' class='form-control' name='data' data-provide='markdown' value='' placeholder='Skriv kommentar här!'></textarea>
                                                <br />
                                                <input type='hidden' name='user' value='<?= $userid ?>'>
                                                <input type='hidden' name='commentto' value='<?= $answer->id ?>'>
                                                <input type='hidden' name='articleid' value='<?= $article['article']->id ?>'>
                                                <input class='btn btn-default' type='submit' name='addanswercommentbtn' value='Lägg till kommentar'>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-8">
            <h4>Ditt svar</h4>
            <?= $form ?>
        </div>
    </div>

</div>
