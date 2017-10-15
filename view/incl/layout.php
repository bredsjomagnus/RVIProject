<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= $title ?></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>



    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">


    <!-- <link rel="stylesheet" href=<?= $stylepath ?>> -->
    <?php foreach ($stylesheets as $stylesheet) : ?>
    <link rel="stylesheet" type="text/css" href="<?= $this->asset($stylesheet) ?>">
    <?php endforeach; ?>

</head>
<body>

<?php if ($this->regionHasContent("header")) : ?>
<div class="header-wrap">
    <?php $this->renderRegion("header") ?>
</div>
<?php endif; ?>

<?php if ($this->regionHasContent("navbar")) : ?>
<div class="navbar-wrap">
    <?php $this->renderRegion("navbar") ?>
</div>
<?php endif; ?>

<?php if ($this->regionHasContent("main")) : ?>
<div class="main-wrap">
    <?php $this->renderRegion("main") ?>
</div>
<?php endif; ?>

<?php if ($this->regionHasContent("footer")) : ?>
<div class="footer-wrap">
    <?php $this->renderRegion("footer") ?>
</div>
<?php endif; ?>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<!-- <script src="../../js/external/bootstrap-markdown.js"></script> -->
<?php foreach ($javascripts as $javascript) : ?>
    <script src="<?= $this->asset($javascript) ?>"></script>
<?php endforeach; ?>
</body>
</html>
