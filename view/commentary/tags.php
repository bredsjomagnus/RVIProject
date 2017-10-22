<?php

namespace Anax\View;

?>
<div class="container">
    <!-- <?= var_dump($alltags) ?> -->
    <div class="row">
        <div class="col-md-12">
            <?= $tagbar ?>
            <br>
            <br>
            <a href='<?= url('commentary/articles/alla')?>'>Tillbaka</a>
            <h3>Etiketter</h3>
            <div class="col-md-9">
                <table class='table'>
                    <thead>
                        <tr>
                            <th>Etikett</th>
                            <th>Antal</th>
                            <th>Skapad</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($alltags as $tag) : ?>
                        <tr>
                            <td>
                                <a href='<?= url('commentary/articles/'.$tag->tagpath) ?>'><?= $tag->tag ?></a>
                            </td>
                            <td><?= $tag->tagcount ?></td>
                            <td><?= $tag->created ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-3">

                <div class="tagclouddiv">
                    <h4>Etikettmoln</h4>
                    <?=  $tagcloud ?>
                </div>
            </div>
        </div>
    </div>
</div>
