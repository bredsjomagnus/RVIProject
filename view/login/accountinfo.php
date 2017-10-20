<?php

namespace Anax\View;

$random = mt_rand(10000000, 99999999);
$adminurl   = url("admin");
$adminlink  = $isAdmin ? "| <a href='".url("admin")."'>Admin</a>" : "";
$adminrow   = $isAdmin ? "<tr><td><b>Roll</b></td><td><a href='$adminurl'>Administratör</a></td></tr>": "";
$session    = $this->di->get("session");
?>

<div class="container">
    <p>Dagens datum: <?= date("Y-m-d") ?></p>
    <br />
    <div class="row">
        <div class="col-md-12">
            <!-- <?= var_dump($_SESSION); ?> -->
        </div>
    </div>
    <h1>KONTO<small> - <?= $account->username  ?></small></h1>
    <div class="row">
        <div class="col-md-3">
        <!-- BILD -->
        <br />

        </div>
    </div>

    <table class="table accounttable">
        <?= $adminrow ?>
        <tr>
            <td><b>Användarnamn</b></td><td><?= $account->username ?></td>
        </tr>
        <tr>
            <td><b>Förnamn</b></td><td><?= $account->firstname ?></td>
        </tr>
        <tr>
            <td><b>Efternamn</b></td><td><?= $account->surname ?></td>
        </tr>
        <tr>
            <td><b>Email</b></td><td><?= ($account->email) ? $account->email : "" ?></td>
        </tr>
        <tr>
            <td><b>Adress</b></td><td><?= ($account->address) ? $account->address : "" ?></td>
        </tr>
        <tr>
            <td><b>Postnummer</b></td><td><?= ($account->postnumber) ? $account->postnumber : "" ?></td>
        </tr>
        <tr>
            <td><b>Ort</b></td><td><?= ($account->city) ? $account->city : "" ?></td>
        </tr>
        <tr>
            <td><b>Telefon</b></td><td><?= ($account->phone) ? $account->phone : "" ?></td>
        </tr>
        <tr>
            <td><b>Mobil</b></td><td><?= ($account->mobile) ? $account->mobile : "" ?></td>
        </tr>
    </table>
    <div class="row">

        <div class="col-md-12">
            <?= $this->di->get("session")->get("usereditinfomsg", "") ?><br />
            <?= $this->di->get("session")->get("usereditpassmsg", "") ?>
            <br />
            <div class="collapse" id="editprofileinfocollapse">
                <div class="pillow-20">

                </div>
                <div class="well">
                    <p class='info'>Fyll i kontoinformation i fälten nedan.</p>
                    <form action="<?= url("usereditaccountprocess/".$account->id) ?>" method="POST">
                        <div class="form-group">
                            <label for="firstname">Förnamn</label>
                            <input class="form-control" type="text" name="firstname" value='<?= $account->firstname ?>' placeholder="Förnamn">
                        </div>
                        <div class="form-group">
                            <label for="surname">Efternamn</label>
                            <input class="form-control" type="text" name="surname" value='<?= $account->surname ?>' placeholder="Efternamn">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input class="form-control" type="email" name="email" value='<?= ($account->email) ? $account->email : "" ?>' placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label for="address">Adress</label>
                            <input class="form-control" type="text" name="address" value='<?= ($account->address) ? $account->address : "" ?>' placeholder="Adress">
                        </div>
                        <div class="form-group">
                            <label for="postnumber">Postnummer</label>
                            <input class="form-control" type="text" name="postnumber" value='<?= ($account->postnumber) ? $account->postnumber : "" ?>' placeholder="Postnummer">
                        </div>
                        <div class="form-group">
                            <label for="city">Ort</label>
                            <input class="form-control" type="text" name="city" value='<?= ($account->city) ? $account->city : "" ?>' placeholder="Ort">
                        </div>
                        <div class="form-group">
                            <label for="phone">Telefon</label>
                            <input class="form-control" type="text" name="phone" value='<?= ($account->phone) ? $account->phone : "" ?>' placeholder="Telefon">
                        </div>
                        <div class="form-group">
                            <label for="mobile">Mobil</label>
                            <input class="form-control" type="text" name="mobile" value='<?= ($account->mobile) ? $account->mobile : "" ?>' placeholder="Mobil">
                        </div>

                        <input type="hidden" name="role" value='<?= $account->role ?>'>
                        <input type="hidden" name="active" value='<?= $account->active ?>'>
                        <input type="hidden" name="notes" value='<?= $account->notes ?>'>
                        <input class="btn btn-primary" type="submit" name="editaccount" value="Ändra kontoinformation">
                        <!-- <input class="btn btn-danger right" type="submit" name="deleteaccount" value="Radera konto"> -->
                    </form>
                </div>
                <!-- /well -->
            </div>
            <!-- /collapse -->
        </div>
        <!-- col-md-12 -->

        <div class="col-md-12">
            <div class="collapse" id="editpasswordcollapse">
                <div class="pillow-20">

                </div>
                <div class="well">
                    <p class='info'>Skriv in ditt nuvarande lösenord följt av det nya lösenordet två gånger.</p>
                    <form action="<?= url("usereditpasswordprocess/".$account->id) ?>" method="POST">
                        <div class="form-group">
                            <label for="oldpass">Nuvarande lösenord</label>
                            <input class="form-control" type="password" name="oldpass" value="" placeholder="Nuvarande lösenord">
                        </div>
                        <div class="form-group">
                            <label for="newpassone">Nytt lösenord</label>
                            <input class="form-control" type="password" name="newpassone" value="" placeholder="Nytt lösenord">
                        </div>
                        <div class="form-group">
                            <label for="newpasstwo">Nytt lösenord igen</label>
                            <input class="form-control" type="password" name="newpasstwo" value="" placeholder="Nytt lösenord igen">
                        </div>

                        <input class="btn btn-primary" type="submit" name="editpassword" value="Ändra lösenordet">
                    </form>
                </div>
                <!-- /well -->
            </div>
            <!-- /collapse -->
        </div>
        <!-- col-md-12 -->

        <div class="col-md-12">
            <div class="btn-group">
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#editprofileinfocollapse" aria-expanded="false" aria-controls="editprofileinfocollapse">
                Redigera
                </button>

                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#editpasswordcollapse" aria-expanded="false" aria-controls="editpasswordcollapse">
                Ändra lösenord
                </button>
            </div>
            <!-- btn-group -->
            <br><br>
        </div>
        <!-- /col-md-12 -->

    </div>
    <!-- /row -->
</div>
<!-- /container -->
