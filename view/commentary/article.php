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

$editarticle = ($article['article']->updated != null) ? "Redigerad ". $article['article']->updated : "";


?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?= $tagbar ?>
            <br>
            <br>
            <a href='<?= url('commentary/articles/alla')?>'>Tillbaka</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-9">
            <h2><?= $article['article']->title ?></h2>
            <?= $article['articledata']->text ?>
            <br>
            <span class='small text-muted'><?= $editarticle ?></span>
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

                    // Redigeringslänk för den som skrivit kommentaren.
                    $editarticlecomment = "";
                    if ($articlecomment->user == $session->get('userid')) {
                        $editarticlecomment = "<a href='".url('commentary/updatearticlecomment/'.$article['article']->id."?articlecommentid=".$articlecomment->id)."'>Ändra</a>";
                    }

                    // Notis som läggs till om man redigerat en artikelkommentar
                    $editedarticlecomment = ($articlecomment->updated != null) ? "<br />Redigerad ". $articlecomment->updated : "";
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
                        <td class='articlecomment'>
                            <?= $filteredarticlecomment ?>&nbsp;&nbsp;&nbsp;&nbsp;
                            <span class='small text-muted'><?= $editedarticlecomment ?></span>
                        </td>
                        <td class='articlecommentauthor articlecomment' valign='top' align='right'>
                            <?= $articlecomment->created ?><br /><a href='<?= url('commentary/userinfo/'.$articlecommentauthor->id) ?>'><?= $articlecommentauthor->username ?></a>
                            <br /><span class='small'><?= $cancelarticlecommentvote ?></span><span class='small'><?= $editarticlecomment ?></span>
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
        <span class='small'>
            Sortera efter rank: &nbsp;
            <a href='<?= url('commentary/article/'.$article['article']->id.'?orderby=score&orderas=asc') ?>'>
                <span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
            </a>
            <a href='<?= url('commentary/article/'.$article['article']->id.'?orderby=score&orderas=desc') ?>'>
                <span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span>
            </a>
            &nbsp; | &nbsp;&nbsp;
            Sortera efter datum: &nbsp;
            <a href='<?= url('commentary/article/'.$article['article']->id.'?orderby=created&orderas=asc') ?>'>
                <span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
            </a>
            <a href='<?= url('commentary/article/'.$article['article']->id.'?orderby=created&orderas=desc') ?>'>
                <span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span>
            </a>
        </span>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="col-md-8">
            <table class='answertable'>
                <thead>
                    <tr>
                        <th class='avatarfirstcolumn'></th>
                        <th class='answersecondcolumn'></th>
                        <th class='answerthirdcolumn'></th>
                        <th class='answerfourthcolumn'></th>
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

                    $editanswer = "";
                    if ($answer->user == $session->get('userid')) {
                        $editanswer = "<a href='".url('commentary/updateanswer/'.$article['article']->id."?answerid=".$answer->id)."'>Ändra</a>";
                    }

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

                    $editedanswer = ($answer->updated != null) ? "Redigerad ". $answer->updated : "";

                    $acceptanswerbtn = ($ownarticle && $article['article']->user != $answer->user) ?
                                            "<a class='btn btn-default btn-xs' href='".url('commentary/acceptanswer/'.$article['article']->id)."?answerid=".$answer->id."'>
                                                <span style='color: green;' class='glyphicon glyphicon-ok' aria-hidden='true'></span>
                                                &nbsp; Acceptera svar
                                            </a>" :
                                            "";


                    $acceptedclass = "";
                    if ($articlehaveacceptedanswer) {
                        $acceptedclass = ($acceptedanswer[0]->id == $answer->id) ? "acceptedanserrow" : "";

                        $acceptanswerbtn = ($ownarticle && $acceptedanswer[0]->id == $answer->id) ?
                                                    "<a class='btn btn-default btn-xs' href='".url('commentary/cancelacceptanswer/'.$article['article']->id)."?answerid=".$answer->id."'>
                                                        <span style='color: red;' class='glyphicon glyphicon-remove' aria-hidden='true'></span>
                                                        &nbsp; Ångra acceptera svar
                                                    </a>" :
                                                    "";
                    }
                    ?>
                    <!-- AVATAR AND MESSAGE -->
                    <tr class='<?= $acceptedclass ?>'>
                        <td valign=top align='center' colspan=2>
                            <?=$gravatar->toHTML()?>
                            <br />
                            <span class='answeruserinfo'>
                                <a href='<?= url('commentary/userinfo/'.$answeruser->id) ?>'><?=$answeruser->username?></a>
                                <br />
                                <?= substr($answer->created, 0, 10) ?>
                                <br>
                                <span><?= $editanswer ?></span>
                            </span>
                        </td>
                        <td colspan=2>
                            <div data-provide="markdown-editable" data-savable='true'>
                                <?=$filteredanswer?>
                            </div>
                            <br />
                            <span class='small text-muted'><?= $editedanswer ?></span>
                        </td>
                    </tr>
                    <tr class='commentarydottedunderline' >
                        <td></td>
                        <td colspan=3>

                        </td>
                    </tr>
                    <!-- /AVATAR AND MESSAGE -->

                    <!-- ANSWER VOTES BUTTONS-->
                    <tr>
                        <td colspan=3>
                            <div class="btn-group votediv">
                                <a class='btn articlevotemarker articlevotesummarker' href="#"> <?= $sumanswervotes ?> </a>
                                <a class='btn btn-default articlevotemarker' href="<?= url('commentary/voteanswerprocess/'.$article['article']->id.'?vote=up&answerid='.$answer->id.'&authorid='.$answer->user) ?>" <?= $disabledanswervotebuttons ?>>
                                    <span class="glyphicon glyphicon-menu-up" aria-hidden="true">
                                </a>
                                <a class='btn btn-default articlevotemarker' href="<?= url('commentary/voteanswerprocess/'.$article['article']->id.'?vote=down&answerid='.$answer->id.'&authorid='.$answer->user) ?>" <?= $disabledanswervotebuttons ?>>
                                    <span class="glyphicon glyphicon-menu-down" aria-hidden="true">
                                </a>
                            </div>
                            <?= $acceptanswerbtn ?>
                            <div class='numbvotediv'>
                                <span class='small'>Antal röster: <?= $totnumbanswervotes ?> st <?= $cancelanswervote ?></span>
                            </div>
                        </td>
                        <td></td>
                    </tr>
                    <!-- /ANSWERVOTES -->



                    <tr>
                        <td class='commentaryunderline'></td>
                        <td colspan=3 class='text-muted commentaryunderline'></td>
                    </tr>


                    <!-- SVARSKOMMENTARKOMMENTAR -->
                    <?php foreach ($answercomments as $answercomment) : ?>
                        <?php if ($answercomment->commentto == $answer->id) : ?>
                            <?php
                            $answercommentauthor = new User();
                            $answercommentauthor->setDb($db);
                            $answercommentauthor->find('id', $answercomment->user);

                            $filteredanswercomment = $this->di->get("textfilter")->markdown($answercomment->data);


                            $hasvotedonanswercomment   = $comm->userHasVotedOnAnswerComment($answercomment->id);
                            $ownanswercomment          = $comm->ownAnswerComment($answercomment->id);

                            $answercommentvotesum      = $comm->getAnswerCommentVoteSum($answercomment->id);
                            if ($answercommentvotesum == 0) {
                                $answercommentvotesumhtml = '0';
                            } else {
                                $answercommentvotesumhtml = $answercommentvotesum;
                            }

                            // Kan användaren rösta på svaret?
                            $disabledanswercommentvotebuttons = ($hasvotedonanswercomment || $ownanswercomment || !$session->has("user")) ? "disabledvotelink" : "";

                            // Man kan välja att ångra rösten om man redan röstat på artikeln.
                            $cancelanswercommentvote   = $hasvotedonanswercomment ? "&nbsp;&nbsp;&nbsp;<a class='cancelarticlevote small' href='".url('commentary/cancelanswercommentvote/'.$article['article']->id."?answercommentid=".$answercomment->id)."'>Ångra röst</a>" : "" ;

                            // Är man själv ägare till artikeln kan man inte ångra någon röst. Annars blir det som $cancelvote ovan.
                            $cancelanswercommentvote   = $ownanswercomment ? "": $cancelanswercommentvote;

                            // Redigeringslänk för den som skrivit kommentaren.
                            $editanswercomment = "";
                            if ($answercomment->user == $session->get('userid')) {
                                $editanswercomment = "<a href='".url('commentary/updateanswercomment/'.$article['article']->id."?answercommentid=".$answercomment->id)."'>Ändra</a>";
                            }

                            $editedanswercomment = ($answercomment->updated != null) ? "<br />Redigerad ". $answercomment->updated : "";
                            ?>

                            <tr class='answercommenttr'>

                                <td valign='top' align='right' class='answercommentvotesum'><?= $answercommentvotesumhtml ?></td>
                                <td valign='top' class='answercommentvotecell'>
                                    <div class="btn-group votediv">
                                        <a class='articlevotemarker <?= $disabledanswercommentvotebuttons ?>' href="<?= url('commentary/voteanswercommentprocess/'.$article['article']->id.'?answercommentid='.$answercomment->id.'&vote=up&answerid='.$answer->id) ?>">
                                            <span class="glyphicon glyphicon-menu-up" aria-hidden="true">
                                        </a>
                                        <br />
                                        <a class='articlevotemarker <?= $disabledanswercommentvotebuttons ?>' href="<?= url('commentary/voteanswercommentprocess/'.$article['article']->id.'?answercommentid='.$answercomment->id.'&vote=down&answerid='.$answer->id) ?>">
                                            <span class="glyphicon glyphicon-menu-down" aria-hidden="true">
                                        </a>
                                    </div>
                                </td>
                                <td align='left' class='answercomment'>
                                    <?= $filteredanswercomment ?>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <span class='small text-muted'><?= $editedanswercomment ?></span>
                                </td>
                                <td class='answercomment' valign='top' align='right'><?= $answercomment->created ?>
                                    <br />
                                    <a href='<?= url('commentary/userinfo/'.$answercommentauthor->id) ?>'><?= $answercommentauthor->username ?></a>
                                    <br />
                                    <span class='small'><?= $cancelanswercommentvote ?></span><span class='small'><?= $editanswercomment ?></span>
                                </td>
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
