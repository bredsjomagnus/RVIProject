<?php

namespace Maaa16\Admin;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;

/**
 * REM Server.
 */
class AdminAssembler implements InjectionAwareInterface
{
    use InjectionAwareTrait;

    public function getComments($res)
    {
        $table = "<table class='commenttable'>";
        $table .=   "<thead>
                        <tr>
                            <th class='avatarcolumn'>
                            </th>
                            <th>
                            </th>
                        </tr>
                    </thead>
                    <tbody>";
        foreach ($res as $comment) {
            $default = "http://i.imgur.com/CrOKsOd.png"; // Optional
            $gravatar = new \Maaa16\Gravatar\Gravatar($comment->email, $default);
            $gravatar->size = 50;
            $gravatar->rating = "G";
            $gravatar->border = "FF0000";
            $filteredcomment = $this->di->get("textfilter")->markdown($comment->comm);

            $editcommenturl = $this->di->get("url")->create("editcomment") ."?id=". $comment->id."&path=admin";
            $title = $this->di->get("contentFactory")->getTitle($comment->comment_on);


            $table .=   "<tr>
                            <td><b>Artikel:</b></td>
                            <td>".$title."</td>
                        </tr>
                        <tr>
                            <td valign=top>".$gravatar->toHTML()."</td>
                            <td><b>".$comment->username."</b><br />".$filteredcomment."</td>
                        </tr>
                        <tr style='border-bottom: 1px solid lightgray;'>
                            <td></td>
                            <td><a href='".$editcommenturl."'>Redigera</a></td>
                        </tr>";
        }
        $table .=   "</tbody>
                    </table>";
        return $table;
    }

    public function getAccountsTable($res)
    {
        $accountHTML = "<div class='panel-group' id='accordion' role='tablist' aria-multiselectable='true'>";
        foreach ($res as $account) {
            $default = "http://i.imgur.com/CrOKsOd.png"; // Optional
            $gravatar = new \Maaa16\Gravatar\Gravatar($account->email, $default);
            $gravatar->size = 50;
            $gravatar->rating = "G";
            $gravatar->border = "FF0000";
            // $filteredcomment = $this->di->get("textfilter")->markdown($comment->comm);

            $notes = ($account->notes == null) ? "" : "<hr /><h5 class='text-muted'>ANTECKNINGAR</h5>".$account->notes;

            $lastloggedin = $this->di->get("admin")->getLastLoggedIn($account->id, "Kontot är oanvänt");
            $phonenumbers = ($account->phone == null) ? $account->mobile : $account->phone.", ".$account->mobile;
            $address = ($account->address == null) ? "" : $account->address."<br />";
            $postcity = ($account->postnumber == null) ? $account->city ."<br />" : $account->postnumber." ".$account->city."<br />";
            // $editcommenturl = $this->di->get("url")->create("editcomment") ."?id=". $comment->id;
            $accountHTML .= "<div class='panel panel-default'>
              <div class='panel-heading' role='tab' id='accountheading-".$account->id."'>
                <h4 class='panel-title'>
                <div class='btn-group' role='group' aria-label='Basic example'>
                <a class='float-right btn' href='".$this->di->get("url")->create("admineditaccount")."?id=".$account->id."&reset=yes'><span class='glyphicon glyphicon-cog' aria-hidden='true'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <button class='btn' role='button' data-toggle='collapse' data-parent=''#accordion' href='#accountcollapse-".$account->id."' aria-expanded='true' aria-controls='accountcollapse-".$account->id."'>
                  <span class='text-muted'>Senast inloggad: ".$lastloggedin."</span><br />
                    ". $account->firstname . " " . $account->surname ."
                  </button>
                </div>
                </h4>
              </div>
              <div id='accountcollapse-".$account->id."' class='panel-collapse collapse' role='tabpanel' aria-labelledby='accountheading-".$account->id."'>
                <div class='panel-body admin-accordian-panel-body'>
                    <b>Användarnamn: </b>".$account->username."<br />
                    <b>Skapat:</b> ".$account->created."<br />
                    <b>roll:</b> ".$account->role.", <b>Aktivt:</b> ".$account->active."<br />
                    ".$address."
                    ".$postcity."
                    ".$phonenumbers."<br />
                    ".$notes."
                </div>
              </div>
            </div>";
        }

        $accountHTML .= "</div>";
        return $accountHTML;
    }

    /**
    *
    * @SuppressWarnings(PHPMD)
    */
    public function getEditAccountTable($res)
    {
        $activeselected_yes = ($res[0]->active == 'yes') ? 'selected' : '';
        $activeselected_no = ($res[0]->active == 'no') ? 'selected' : '';

        $adminselected = ($res[0]->role == 'admin') ? 'selected' : '';
        $userselected = ($res[0]->role == 'user') ? 'selected' : '';
        $guestselected = ($res[0]->role == 'guest') ? 'selected' : '';

        $editaccountHTML =
                            "<form action='admineditaccountprocess' method='POST'>
                                <table class='admintablewidth'>
                                    <tr>
                                        <td>
                                            <div class='form-group'>
                                                <label for='role'>ROLL</label>
                                                <select class='form-controll' name='role'>
                                                    <option value='admin' ".$adminselected.">admin</option>
                                                    <option value='user' ".$userselected.">user</option>
                                                    <option value='guest' ".$guestselected.">guest</option>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class='form-group'>
                                                <label for='active'>AKTIV</label>
                                                <select class='form-controll' name='active'>
                                                    <option value='yes' ".$activeselected_yes.">yes</option>
                                                    <option value='no' ".$activeselected_no.">no</option>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class='form-group'>
                                                <label for='firstname'>FÖRNAMN</label>
                                                <input class='form-control' type='text' name='firstname' value='".$res[0]->firstname."' >
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class='form-group'>
                                            <label for='surname'>EFTERNAMN</label>
                                            <input class='form-control' type='text' name='surname' value='".$res[0]->surname."' >
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class='form-group'>
                                            <label for='email'>EMAIL</label>
                                            <input class='form-control' type='text' name='email' value='".$res[0]->email."' readonly >
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class='form-group'>
                                            <label for='address'>ADRESS</label>
                                            <input class='form-control' type='text' name='address' value='".$res[0]->address."' >
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class='form-group'>
                                            <label for='postnumber'>POSTNUMMER</label>
                                            <input class='form-control' type='text' name='postnumber' value='".$res[0]->postnumber."' >
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class='form-group'>
                                            <label for='city'>ORT</label>
                                            <input class='form-control' type='text' name='city' value='".$res[0]->city."' >
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class='form-group'>
                                            <label for='phone'>TELEFON</label>
                                            <input class='form-control' type='text' name='phone' value='".$res[0]->phone."' >
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class='form-group'>
                                            <label for='mobil'>MOBIL</label>
                                            <input class='form-control' type='text' name='mobile' value='".$res[0]->mobile."' >
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class='form-group'>
                                            <label for='notes'>FRITEXT (Enbart synlig för administratör)</label>
                                            <textarea rows='10' class='form-control' name='notes'>".$res[0]->notes."</textarea>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <input type='hidden' name='id' value='".$res[0]->id."'  />
                                <input class='float-left btn btn-danger' type='submit' name='deleteaccountbtn' value='Ta bort' />
                                <input class='float-right btn btn-primary' type='submit' name='editaccountbtn' value='Spara' />
                                <input class='float-right btn btn-primary' type='submit' name='editpasswordaccountbtn' value='Återställa lösenord' />
                                <a href='".$this->di->get("url")->create("adminaccounts")."' class='float-right btn btn-default'>Ångra</a>
                            </form><br /><br />";
        return $editaccountHTML;
    }

    public function resetPasswordHTML($id)
    {
        $resetpasswordHTML =    "<form action='adminresetpasswordprocess' method='POST'>
                                    <input class='form-control' type='password' name='passone' placeholder='Nytt lösenord' />
                                    <input class='form-control' type='password' name='passtwo' placeholder='Nytt lösenord igen' />
                                    <input type='hidden' name='id' value='".$id."' />
                                    <input class='btn btn-primary' type='submit' name='resetpasswordbtn' value='Återställ lösenord' />
                                </form>";
        return $resetpasswordHTML;
    }
}
