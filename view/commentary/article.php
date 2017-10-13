<?php

use \Anax\User\User;

$db = $this->di->get("db");
?>

<div class="container">
    <!-- <h4>TESTGROUND</h4> -->
    <!-- <?= var_dump($article) ?> -->
    <h2><?= $article['article']->title ?></h2>
    <?= $article['articledata']->text ?>
    <?= $form ?>
    <table class='commenttable'>
        <thead>
            <tr>
                <th class='avatarcolumn'>
                </th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($answers as $answer) : ?>
            <?php
            $user = new User();
            $user->setDb($db);
            $user->find("id", $answer->user);

            $default = "http://i.imgur.com/CrOKsOd.png"; // Optional
            $gravatar = new \Maaa16\Gravatar\Gravatar(($user->email !== null) ? $user->email : 'na@na.na', $default);
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
                            <td class='text-muted commentaryunderline'><i><?=$answer->created?>&nbsp&nbsp&nbsp<?=$user->username?>, <?= $user->email ?></i></td>
                        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</div>
