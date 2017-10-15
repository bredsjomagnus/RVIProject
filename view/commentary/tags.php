<?php

namespace Anax\View;

?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?= $tagbar ?>
            <br>
            <br>
            <a href='<?= url('commentary/articles/alla')?>'>Tillbaka</a>
            <h4>Taggar</h4>
            <div class="col-md-3">
                <div class="tagclouddiv">
                    <?=  $tagcloud ?>
                </div>
            </div>


        </div>
    </div>
</div>
