<?php
if (!$app->session->has('user') || $app->session->get('role') != 'admin') {
    $app->response->redirect('login');
}
?>

<div class="page">
    <?= $comments ?>
</div>
