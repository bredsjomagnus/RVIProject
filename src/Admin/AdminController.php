<?php

namespace Maaa16\Admin;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;

/**
 * A controller for the Commentary.
 *
 * @SuppressWarnings(PHPMD.ExitExpression)
 */
class AdminController implements InjectionAwareInterface
{
    use InjectionAwareTrait;

    /**
     * Adminpage.
     *
     * @return void
     */
    public function adminPage()
    {
        // $path = $this->di->get("request")->getRoute();
        $file = ANAX_INSTALL_PATH . "/content/admin/index.md";

        // Check that file is really in the right place
        $real = realpath($file);
        $base = realpath(ANAX_INSTALL_PATH . "/content/");
        if (strncmp($base, $real, strlen($base))) {
            return;
        }

        // Get content from markdown file
        $content = file_get_contents($file);
        $content = $this->di->get("textfilter")->parse($content, ["yamlfrontmatter", "shortcode", "markdown", "titlefromheader"]);

        // Render a standard page using layout
        $this->di->get("view")->add("default1/article", [
            "content" => $content->text
        ]);

        // Hämta comments från databasen och montera ihop tabell som skickas vidare till vyn.
        // $comments = $this->app->comm->getComment($this->app);
        // $comments = $this->app->commAssembler->assemble($this->app, $comments);

        $this->di->get("view")->add("admin/adminpage");
        $title = "Admin | Maaa16";
        $this->di->get("pageRender")->renderAdminPage(["title" => $title], 'admin');
    }

    /**
     * Adminpage.
     *
     * @return void
     */
    public function adminComments()
    {
        $file = ANAX_INSTALL_PATH . "/content/admin/comments.md";

        // Check that file is really in the right place
        $real = realpath($file);
        $base = realpath(ANAX_INSTALL_PATH . "/content/");
        if (strncmp($base, $real, strlen($base))) {
            return;
        }

        // Get content from markdown file
        $content = file_get_contents($file);
        $content = $this->di->get("textfilter")->parse($content, ["yamlfrontmatter", "shortcode", "markdown", "titlefromheader"]);

        // Render a standard page using layout
        $this->di->get("view")->add("default1/article", [
            "content" => $content->text
        ]);
        $title = "Admin | Maaa16";
        // Hämta comments från databasen och montera ihop tabell som skickas vidare till vyn.
        $comments = $this->di->get("comm")->getComment();
        $comments = $this->di->get("adminAssembler")->getComments($comments);
        $this->di->get("view")->add("admin/admincomments", ["comments" => $comments]);

        $this->di->get("pageRender")->renderAdminPage(["title" => $title], 'admin');
    }

    /**
    * Admin accounts.
    *
    * @return void
    */
    public function adminAccounts()
    {
        if ($this->checkAdminRole()) {
            $title = "Admin | Konton";
            $accounts = $this->di->get("admin")->getAccounts();
            $accountstable = $this->di->get("adminAssembler")->getAccountsTable($accounts);
            $this->di->get("view")->add("admin/adminaccounts", ["accountstable" => $accountstable]);
            $this->di->get("pageRender")->renderAdminPage(["title" => $title], 'admin');
        } else {
            $this->di->get("response")->redirect("login");
        }
    }

    /**
    * Edit accounts
    *
    * @return void
    */
    public function adminEditAccount()
    {
        if ($this->checkAdminRole()) {
            $reset = $this->di->get("admin")->getSingleAccount($this->di->get("request")->getGet('reset'));
            if ($reset == "yes") {
                $this->di->get("session")->set("resetpasswordmsg", "");
            }
            $title = "Admin | Redigera konton";
            $singleaccount = $this->di->get("admin")->getSingleAccount($this->di->get("request")->getGet('id'));
            $editaccountHTML = $this->di->get("adminAssembler")->getEditAccountTable($singleaccount);
            $this->di->get("view")->add("admin/admineditaccount", ["editaccountHTML" => $editaccountHTML]);
            $this->di->get("pageRender")->renderAdminPage(["title" => $title], 'admin');
        } else {
            $this->di->get("response")->redirect("login");
        }
    }

    public function adminEditAccountProcess()
    {
        if ($this->checkAdminRole()) {
            if ($this->di->get('request')->getPost('editaccountbtn') != null) {
                $userdata = [
                                "role" => htmlentities($this->di->get("request")->getPost('role')),
                                "active" => htmlentities($this->di->get("request")->getPost('active')),
                                "firstname" => htmlentities($this->di->get("request")->getPost('firstname')),
                                "surname" => htmlentities($this->di->get("request")->getPost('surname')),
                                // "username" => htmlentities($this->di->get("request")->getPost('username')),
                                // "email" => htmlentities($this->di->get("request")->getPost('email')),
                                "address" => htmlentities($this->di->get("request")->getPost('address')),
                                "postnumber" => htmlentities($this->di->get("request")->getPost('postnumber')),
                                "city" => htmlentities($this->di->get("request")->getPost('city')),
                                "phone" => htmlentities($this->di->get("request")->getPost('phone')),
                                "mobile" => htmlentities($this->di->get("request")->getPost('mobile')),
                                "notes" => htmlentities($this->di->get("request")->getPost('notes'))
                            ];
                $id = htmlentities($this->di->get("request")->getPost('id'));
                $this->di->get("admin")->editAccount($id, $userdata);
                $this->adminAccounts();
            } else if ($this->di->get('request')->getPost('deleteaccountbtn') != null) {
                $id = htmlentities($this->di->get("request")->getPost('id'));
                $this->di->get("admin")->deleteAccount($id);
                $this->adminAccounts();
            } else if ($this->di->get('request')->getPost('editpasswordaccountbtn') != null) {
                $id = htmlentities($this->di->get("request")->getPost('id'));
                $this->adminResetPassword($id);
            }
        }
    }

    public function adminResetPassword($id)
    {
        if ($this->checkAdminRole()) {
            $title = "Admin | Återställ lösenord";
            $resetpasswordHTML = $this->di->get("adminAssembler")->resetPasswordHTML($id);
            $this->di->get("view")->add("admin/adminresetpassword", ["resetpasswordHTML" => $resetpasswordHTML]);
            $this->di->get("pageRender")->renderAdminPage(["title" => $title], 'admin');
        } else {
            $this->di->get("response")->redirect("login");
        }
    }

    public function adminResetPasswordProcess()
    {
        if ($this->checkAdminRole()) {
            $id = htmlentities($this->di->get("request")->getPost('id'));
            $passone = htmlentities($this->di->get("request")->getPost('passone'));
            $passtwo = htmlentities($this->di->get("request")->getPost('passtwo'));
            if ($passone == $passtwo) {
                $this->di->get("admin")->resetPassword($id, $passone);
                $this->di->get("session")->set("resetpasswordmsg", "Lösenordet ändrat.");
                $this->di->get("response")->redirect("admineditaccount?id=".$id."&reset=no");
            } else {
                $this->di->get("session")->set("resetpasswordmsg", "Lösenorden inte återställt. Lösenorden stämde inte överens.");
                $this->di->get("response")->redirect("admineditaccount?id=".$id."&reset=no");
            }
        } else {
            $this->di->get("response")->redirect("login");
        }
    }
    public function adminContent()
    {
        if ($this->checkAdminRole()) {
            $title = "Admin | Innehåll";
            $contents = $this->di->get("admin")->getContent();
            $this->di->get("view")->add("admin/admincontent", ["contents" => $contents]);
            $this->di->get("pageRender")->renderAdminPage(["title" => $title], 'admin');
        } else {
            $this->di->get("response")->redirect("login");
        }
    }
    public function checkAdminRole()
    {
        return ($this->di->get("session")->get("role") == "admin") ? true : false;
    }
}
