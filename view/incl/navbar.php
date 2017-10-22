<?php $app->navbar->setDefaultsFromConfiguration($navbar); ?>


<!-- <img class='banner' src="img/banner-top-smaller.png" alt=""> -->

<nav class="navbar navbar-default navbar-fixed-top">
<!-- class="navbar navbar-default navbar-fixed-top" -->


    <!-- <a class="navbar-brand" href=<?= $app->url->create("commentary/overview") ?>><img class='brandimg' src='<?= $this->asset($brandimage) ?>' alt="allt om jakt"></a> -->
    <a class="navbar-brand brandtext" href=<?= $app->url->create("commentary/overview") ?>>Allt om Jakt</a>
    <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <!-- <a name="top"></a> -->
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <?= $app->navbar->generateNavbar($active); ?>
        </div>
    </div>
</nav>
