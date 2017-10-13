<div class="container">
    <a href="<?= $this->di->get("url")->create("adminaccounts") ?>">tillbaka till konton</a><br><br>
    <?= $this->di->get("session")->get("resetpasswordmsg", ""); ?>
    <h3>Redigera konto</h3>
    <?= $editaccountHTML ?>
</div>
