<?php

namespace Anax\View;

use \Anax\User\User;

$db                     = $this->di->get("db");
$session                = $this->di->get("session");
$comm                   = $this->di->get("comm");
$userid                 = $session->get("userid");
$addarticlecommenturl   = url('commentary/addarticlecommentprocess');
$addanswercommenturl    = url('commentary/addanswercommentprocess');
$nousercommsg           = $session->has("user") ? "" : "<a class='commentcollapsepointer' href='".url('login')."'>+ Logga in för att kunna kommentera</a>";
// $addanswercomment       = "<a id='addanswercomment' href='#'</a>+ lägg till kommentar</a>";

// $author = Userobj of article author.
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

    <!-- row with tags and authorinfo -->
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
            for ($x = 0; $x < count($tagpaths); $x = $x +1) {
                echo "<span><a class='tags' href='".url('commentary/articles/'.$tagpaths[$x])."' >".$tagnames[$x]."</a></span>&nbsp;";
            }
            ?>
        </div>
        <div class="col-md-5">
            <span class='author'>Ställd <?= substr($article['article']->created, 0, 16) ?> av <a href='<?= url('commentary/userinfo/'.$author->id) ?>'><?= $author->username ?></a><?= $edit ?></span>
        </div>
    </div>
    <!-- /row with tags and authorinfo -->

    <br>

    <!-- up- and downvotemarkers -->
    <!-- $articlevotes innehåller alla röster för denna artikel. -->
    <div class="row">
        <div class="col-md-3">
            <?php
            // Man kan inte rösta om man redan röstat ELLER om man skrivit artikeln själv
            $disabledarticlevotebuttons   = ($hasvotedonarticle || $ownarticle || !$session->has("user")) ? "disabled" : "";

            // Man kan välja att ångra rösten om man redan röstat på artikeln.
            $cancelvote = $hasvotedonarticle ? "&nbsp;&nbsp;&nbsp;<a class='cancelarticlevote small' href='".url('commentary/cancelarticlevote/'.$article['article']->id)."'> - Ångra</a>" : "" ;

            // Är man själv ägare till artikeln kan man inte ångra någon röst. Annars blir det som $cancelvote ovan.
            $cancelvote = $ownarticle ? "": $cancelvote;

            if ($articlevotesum == 0) {
                $votes = '&plusmn; 0';
            } elseif ($articlevotesum > 0) {
                $votes = '+ '.$articlevotesum;
            } elseif ($articlevotesum < 0) {
                $votes = $articlevotesum;
            }
            ?>

            <!-- VOTEBUTTONS FOR ARTICLE -->
            <div class="btn-group votediv">
                <a class='btn articlevotemarker articlevotesummarker' href="#"> <?= $votes ?> </a>
                <a class='btn btn-default articlevotemarker' href="<?= url('commentary/votearticleprocess/'.$article['article']->id.'?vote=up') ?>" <?= $disabledarticlevotebuttons ?>>
                    <span class="glyphicon glyphicon-menu-up" aria-hidden="true">
                </a>
                <a class='btn btn-default articlevotemarker' href="<?= url('commentary/votearticleprocess/'.$article['article']->id.'?vote=down') ?>" <?= $disabledarticlevotebuttons ?>>
                    <span class="glyphicon glyphicon-menu-down" aria-hidden="true">
                </a>
            </div>
            <div class='numbvotediv'>
                <span class='small'>Antal röster: <?= $totnumbofarticlevotes ?> st <?= $cancelvote ?></span>
            </div>
            <!-- /VOTEBUTTONS FOR ARTICLE -->

        </div>
    </div>
    <!-- /up- and downvotemarkers -->

    <br>

    <!-- ARITKELKOMMENTARER SOM ÄR INLAGDA -->
    <div class="row">
        <?php if ($hasArticleComments) : ?>
            <div class="col-md-8 articlecommentdiv">
                <table class='articlecommenttable'>
                <?php foreach ($articlecomments as $articlecomment) : ?>
                    <?php

                    // ARTIKELKOMMENTARENS FÖRFATTARE
                    $articlecommentauthor = new User();
                    $articlecommentauthor->setDb($db);
                    $articlecommentauthor->find('id', $articlecomment->user);

                    // ARTIKELKOMMENTAREN MARKDOWNFILTRERAD
                    $filteredarticlecomment = $this->di->get("textfilter")->markdown($articlecomment->data);

                    $disabledarticlecommentvotebuttons = "";

                    $articlecommentvotesum = $comm->getArticleCommentVoteSum($articlecomment->id);

                    if ($articlecommentvotesum == 0) {
                        $articlecommentvotesumhtml = '0';
                    } else {
                        $articlecommentvotesumhtml = $articlecommentvotesum;
                    }

                    $hasvotedonarticlecomment   = $comm->userHasVotedOnArticlecomment($articlecomment->id);
                    $ownarticlecomment          = $comm->ownArticleComment($articlecomment->id);

                    $disabledarticlecommentvotebuttons   = ($hasvotedonarticlecomment || $ownarticlecomment || !$session->has("user")) ? "disabledvotelink" : "";

                    // Man kan välja att ångra rösten om man redan röstat på artikeln.
                    $cancelarticlecommentvote = $hasvotedonarticlecomment ? "&nbsp;&nbsp;&nbsp;<a class='cancelarticlevote small' href='".url('commentary/cancelarticlecommentvote/'.$article['article']->id."?articlecommentid=".$articlecomment->id)."'>Ångra röst</a>" : "" ;

                    // Är man själv ägare till artikeln kan man inte ångra någon röst. Annars blir det som $cancelvote ovan.
                    $cancelarticlecommentvote = $ownarticlecomment ? "": $cancelarticlecommentvote;
                    ?>

                    <tr class='articlecommentcontent'>
                        <td valign='top' class='articlecommentvotesum'><?= $articlecommentvotesumhtml ?></td>
                        <td valign='top' class='articlecommentvotecell'>

                            <div class="btn-group votediv">
                                <a class='articlevotemarker <?= $disabledarticlecommentvotebuttons ?>' href="<?= url('commentary/votearticlecommentprocess/'.$article['article']->id.'?articlecommentid='.$articlecomment->id.'&vote=up') ?>">
                                    <span class="glyphicon glyphicon-menu-up" aria-hidden="true">
                                </a>
                                <br />
                                <a class='articlevotemarker <?= $disabledarticlecommentvotebuttons ?>' href="<?= url('commentary/votearticlecommentprocess/'.$article['article']->id.'?articlecommentid='.$articlecomment->id.'&vote=down') ?>">
                                    <span class="glyphicon glyphicon-menu-down" aria-hidden="true">
                                </a>
                            </div>

                        </td>
                        <td class='articlecomment'><?= $filteredarticlecomment ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td class='articlecommentauthor articlecomment' valign='top' align='right'>
                            <?= $articlecomment->created ?> - <a href='<?= url('commentary/userinfo/'.$articlecommentauthor->id) ?>'><?= $articlecommentauthor->username ?></a>
                            <br /><span class='small'><?= $cancelarticlecommentvote ?></span>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </table>
            </div>
        <?php endif; ?>
    </div>
    <br>

    <!-- ARTIKELKOMMENTAR 'LÄGG TILL LÄNK' -->
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
                    /*
                    * VARIABLER FÖR SVARSDELEN
                    * $answer                       = dbobj RVIXanswer (id, answerto, user, data, created, updated, deleted)
                    * $answeruser                   = dbobj User för den som skrivit svaret.
                    * $filteredanswer               = det markdownfiltrerade svaret
                    * $disabledanswervotebuttons    = för att avgöra om röstknapparna skall vara disabled eller inte
                    * $answervotes                  = dbobj RVIXanswervotes för denna artikel (articleid, answerid, authorid, voterid, vote)
                    * $hasvotedonanswer             = boolean if user has voted on answer
                    * $ownanswer                    = boolean, true if user is owner of answer.
                    * $answervotesum                = Summerade rösträkningen för svaret.
                    * $sumanswervotes               = Summerade rösträkningen för svaret med tillagt +, - eller +- framför.
                    * $cancelanswervote             = String med länk som ger det möjligt att ångra röst.
                    *
                    */


                    //-------------------- HANTERING AV RÖSTVARIABLER ---------------------------------
                    // För att se om nuvarande användare redan röstat på svaret.
                    $hasvotedonanswer   = $comm->userHasVotedOnAnswer($answer->id);
                    $ownanswer          = $comm->ownAnswer($answer->id);

                    $answervotesum      = $comm->getAnswerVoteSum($answer->id);
                    if ($answervotesum == 0) {
                        $sumanswervotes = '&plusmn; 0';
                    } elseif ($answervotesum > 0) {
                        $sumanswervotes = '+ '.$answervotesum;
                    } elseif ($answervotesum < 0) {
                        $sumanswervotes = $answervotesum;
                    }

                    // Kan användaren rösta på svaret?
                    $disabledanswervotebuttons = ($hasvotedonanswer || $ownanswer || !$session->has("user")) ? "disabled" : "";

                    // Man kan välja att ångra rösten om man redan röstat på artikeln.
                    $cancelanswervote   = $hasvotedonanswer ? "&nbsp;&nbsp;&nbsp;<a class='cancelarticlevote small' href='".url('commentary/cancelanswervote/'.$article['article']->id."?answerid=".$answer->id)."'> - Ångra</a>" : "" ;

                    // Är man själv ägare till artikeln kan man inte ångra någon röst. Annars blir det som $cancelvote ovan.
                    $cancelanswervote   = $ownanswer ? "": $cancelanswervote;

                    $totnumbanswervotes = $comm->getTotNumbOfAnswerVotes($answer->id);

                    //-------------------------- /HANTERING AV RÖSTVARIABLER ---------------------------------

                    $answeruser = new User();
                    $answeruser->setDb($db);
                    $answeruser->find("id", $answer->user);

                    $default = "http://i.imgur.com/CrOKsOd.png"; // Optional
                    $gravatar = new \Maaa16\Gravatar\Gravatar(($answeruser->email !== null) ? $answeruser->email : 'na@na.na', $default);
                    $gravatar->size = 50;
                    $gravatar->rating = "G";
                    $gravatar->border = "FF0000";

                    // Markdownfiltrerat svar
                    $filteredanswer = $this->di->get("textfilter")->markdown($answer->data);


                    ?>

                    <!-- AVATAR AND MESSAGE -->
                    <tr>
                        <td valign=top align='center'>

                            <?=$gravatar->toHTML()?>
                            <br />
                            <span class='answeruserinfo'>
                                <a href='<?= url('commentary/userinfo/'.$answeruser->id) ?>'><?=$answeruser->username?></a>
                                <br />
                                <?= substr($answer->created, 0, 10) ?>
                            </span>
                        </td>
                        <td colspan=2><?=$filteredanswer?></td>
                    </tr>
                    <tr class='commentarydottedunderline' >
                        <td></td>
                        <td colspan=2>

                        </td>
                    </tr>
                    <!-- /AVATAR AND MESSAGE -->

                    <!-- ANSWER VOTES BUTTONS-->
                    <tr>
                        <td colspan=2>
                            <div class="btn-group votediv">
                                <a class='btn articlevotemarker articlevotesummarker' href="#"> <?= $sumanswervotes ?> </a>
                                <a class='btn btn-default articlevotemarker' href="<?= url('commentary/voteanswerprocess/'.$article['article']->id.'?vote=up&answerid='.$answer->id.'&authorid='.$answer->user) ?>" <?= $disabledanswervotebuttons ?>>
                                    <span class="glyphicon glyphicon-menu-up" aria-hidden="true">
                                </a>
                                <a class='btn btn-default articlevotemarker' href="<?= url('commentary/voteanswerprocess/'.$article['article']->id.'?vote=down&answerid='.$answer->id.'&authorid='.$answer->user) ?>" <?= $disabledanswervotebuttons ?>>
                                    <span class="glyphicon glyphicon-menu-down" aria-hidden="true">
                                </a>
                            </div>

                            <div class='numbvotediv'>
                                <span class='small'>Antal röster: <?= $totnumbanswervotes ?> st <?= $cancelanswervote ?></span>
                            </div>
                        </td>
                        <td></td>
                    </tr>
                    <!-- /ANSWERVOTES -->



                    <tr>
                        <td class='commentaryunderline'></td>
                        <td colspan=2 class='text-muted commentaryunderline'></td>
                    </tr>


                    <!-- SVARSKOMMENTARKOMMENTAR -->
                    <?php foreach ($answercomments as $answercomment) : ?>
                        <?php if ($answercomment->commentto == $answer->id) : ?>
                            <?php
                            $answercommentauthor = new User();
                            $answercommentauthor->setDb($db);
                            $answercommentauthor->find('id', $answercomment->user);

                            $filteredanswercomment = $this->di->get("textfilter")->markdown($answercomment->data);
                            ?>

                            <tr class='answercommenttr'>
                                <td align='left' class='answercomment' colspan=2><?= $filteredanswercomment ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
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
