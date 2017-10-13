<div class="page">
    <div class="container">
        <div class="pillow-100">
        </div>
        <div class="col-md-offset-4 col-md-4">
            <form action="<?= $this->di->get("url")->create("loginprocess") ?>" method="POST">
                <legend>LOGGA IN</legend>
                <div class="form-group">
                    <label for="user">Användarnamn </label><span class="formerror"><?= $this->di->get("session")->get("usermsg", "") ?></span>
                    <input class="form-control" type="text" name="user" value="<?= $this->di->get("cookie")->get("user", "")?>" placeholder="Användarnamn">
                </div>
                <div class="form-group">
                    <label for="pass">Lösenord: </label><span class="formerror"><?= $this->di->get("session")->get("passmsg", "") ?></span>
                    <input class="form-control" type="password" name="pass" value="" placeholder="Lösenord">
                </div>
                <span>
                    <input class='btn btn-primary' type='submit' name='loginsubmit' value='Logga in'>
                    <!-- <span>&nbsp;&nbsp;&nbsp;<input type="checkbox" name="remember" value="">&nbsp;&nbsp;&nbsp;Kom ihåg mig på denna datorn</span> -->
                </span>
                <br />
                <div class="pillow-20">

                </div>
                <button class="btn btn-success" type="button" data-toggle="modal" data-target="#addemployeemodal" aria-expanded="false" aria-controls="addemployeemodal">Skapa konto</button>
                <br />
                <?= $this->di->get("session")->get("loginmsg", "") ?><br />
                <?= $this->di->get("session")->get("createusererrormsg", "") ?><br />

            </form>
            <br />
        </div>

        <!-- modal -->
        <div class="modal fade" id="addemployeemodal" tabindex="-1" role="dialog" aria-labelledby="addemployeemodalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="addemployeemodalLabel">SKAPA KONTO</h4>
                    </div>
                    <form role="form" method="POST" action="<?= $this->di->get("url")->create("createaccount") ?>">
                        <div class="modal-body">
                            <i>Alla fält måste fyllas i.</i>
                            <div class="modal-subheader">
                                <h4>PERSONUPPGIFTER</h4>
                            </div>
                            <div class="form-group">
                                <label class="modal-label" for="firstname">Förnamn </label>
                                <input type="text" name="firstname" class="form-control" placeholder="Förnamn"/>
                            </div>

                            <div class="form-group">
                                <label class="modal-label" for="surname">Efternamn </label>
                                <input type="text" name="surname" class="form-control" placeholder="Efternamn"/>
                            </div>

                            <div class="form-group">
                                <label class="modal-label" for="email">Email </label>
                                <input type="email" name="email" class="form-control" placeholder="Email"/>
                            </div>

                            <div class="modal-subheader">
                                <h4>KONTOUPPGIFTER</h4>
                            </div>

                            <div class="form-group">
                                <label class="modal-label" for="username">Användarnamn </label>
                                <input type="text" name="username" class="form-control" placeholder="Användarnamn"/>
                            </div>

                            <div class="form-group">
                                <label class="modal-label" for="passone">Lösenord </label>
                                <input type="password" name="passone" class="form-control" placeholder="Lösenord"/>
                            </div>

                            <div class="form-group">
                                <label class="modal-label" for="passtwo">Upprepa lösenordet </label>
                                <input type="password" name="passtwo" class="form-control" placeholder="Upprepa lösenord"/>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Ångra</button>
                            <button type="submit" name='createuserbtn' class="btn btn-primary">Skapa konto</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /modal -->

    </div>
</div>
<!--  ||  -->
