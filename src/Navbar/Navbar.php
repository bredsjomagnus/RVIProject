<?php
namespace Maaa16\Navbar;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;
use \Anax\Configure\ConfigureInterface;
use \Anax\Configure\ConfigureTrait;

class Navbar implements ConfigureInterface, InjectionAwareInterface
{
    use ConfigureTrait;
    use InjectionAwareTrait;

    /**
     * Set the app object to inject into view rendering phase.
     *
     * @param object $app with framework resources.
     *
     * @return $this
     */
    // public function setApp($di)
    // {
    //     $this->app = $app;
    //     return $this;
    // }

    /**
     * Set default values from configuration.
     *
     * @return this.
     */
    public function setDefaultsFromConfiguration($choice)
    {
        $this->navbar = $this->config[$choice];
        return $this;
    }

    /**
     * Genereate links in navbar
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     *
     * @param string $itemkey from item in configfile
     * @param string $navhtml the generated navbar, so far.
     * @param array $link with route and text for the links
     * @param string $class info about the class for the links
     * @return string $navhtml generated now with items (links).
     */
    public function generateLinks($itemkey, $navhtml, $link, $class)
    {
        if ($itemkey != 'login' && $itemkey != 'logout') {
            // Med undantag för login och logout
            $navhtml .= "<li><a class='{$class}' href='". $this->di->get("url")->create($link['route'])."'>".$link['text']."</a></li>";
        } else {
            if ($itemkey == 'login' && !$this->di->get("session")->has('user')) {
                // Om man kommer till login och man inte är inloggad redan så visa den länken
                $navhtml .= "<li style='float: right'><a class='{$class}' href='". $this->di->get("url")->create($link['route']) ."#top'>".$link['text']."</a></li>";
            } else if ($itemkey == 'logout' && $this->di->get("session")->has('user')) {
                // Om man kommer till logout och man är inloggad så visa den knappen
                $navhtml .= "<li style='float: right'><a class='{$class}' href='". $this->di->get("url")->create($link['route']) ."#top'>".$link['text']."</a></li>";

                // $path_parts = pathinfo('/www/htdocs/inc/lib.inc.php');
                // $path_parts['dirname']
                $pathinfoarray = explode("/", $_SERVER['PATH_INFO']);
                if (count($pathinfoarray) > 2) {
                    $pathinfo = $pathinfoarray[2];
                } else {
                    $pathinfo = $pathinfoarray[1];
                }
                // För att se om accountinfo är aktiv eller inte kontrolleras route via PATH_INFO¨.
                $accountclass = ((isset($_SERVER['PATH_INFO'])) && ($pathinfo == "userinfo" || $pathinfo == "accountinfo")) ? "navactive" : "notnavacitve";
                $navhtml .= "<li style='float: right'><a class='{$accountclass}' href='". $this->di->get("url")->create('commentary/userinfo/'.$this->di->get("session")->get("userid")) ."#top'>". $this->di->get("cookie")->get('firstname', "") ."</a></li>";
            }
        }
        return $navhtml;
    }

    /**
    *
    */
    private function buildDropdown($navhtml, $value, $active)
    {
        foreach ($value as $dropkey => $link) {
            if ($dropkey == "namn") {   //sätter ut namnet på dropdownmenyn
                // echo $link;
                $class = ($active == "article/mvc") ? "dropdown-toggle navactive" : "dropdown-toggle notnavacitve";
                $navhtml .= "<a href='#' class='{$class}' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>". $link ." <span class='caret'></span></a>";
                $navhtml .= "<ul class='dropdown-menu'>";
            } else if ($dropkey == "items") {    //sätter ut länkarna i dropdownmenyn
                foreach ($link as $droplink) {
                    $navhtml .= "<li><a class='dropdownlink' href='". $this->di->get("url")->create($droplink['route']) ."' style='color: white;'>".$droplink['text']."</a></li>";
                }
            }
        }
        return $navhtml;
    }

    /**
     * Genereate dropdown in navbar
     *
     * @param string $navhtml the generated navbar, so far.
     * @param string $active what link is active.
     * @return string $navhtml generated now with dropdownmenu.
     */
    public function generateDropdown($navhtml, $active)
    {
        foreach ($this->navbar as $key => $value) {
            if ($key == "dropdown") {
                $navhtml .= "<li class='dropdown'>";
                /*
                * Är det är en dropdown kollar man först efter $dropkey == namn för att sätta namn på dropdownmenyn
                * därefter $dropkey == items för att sätta ut länkarna i menyn.
                */
                $navhtml = $this->buildDropdown($navhtml, $value, $active);
            }
        }
        $navhtml .= "</ul>";
        $navhtml .= "</li>";

        return $navhtml;
    }

    /**
    *
    */
    private function generateItems($navhtml, $value, $active)
    {
        foreach ($value as $itemkey => $link) {
            // echo "[" . $itemkey . " => " . $link . "]";
            $itemkey;
            $class = ($active == $link['route']) ? "navactive" : "notnavactive";
            $class = $class . " " . $link['class'];
            $navhtml = $this->generateLinks($itemkey, $navhtml, $link, $class);
        }
        return $navhtml;
    }
    /**
     * Get HTML for the navbar.
     *
     * @param string $active what link is active
     * @return string as HTML with the navbar.
     */
    public function generateNavbar($active)
    {
        foreach ($this->navbar as $key => $value) {
            // echo $key;
            if ($key == "config") {
                foreach ($value as $class) {
                    $navhtml = "<ul class='". $class ."'>";
                }
            } else if ($key == "items") {
                $navhtml = $this->generateItems($navhtml, $value, $active);
            } else if ($key == "dropdown") {
                $navhtml = $this->generateDropdown($navhtml, $active);
            }
        }

        return $navhtml;
    }

    /**
     * Get number of items in cart.
     *
     * @return integer $nrincart number of items in cart.
     */
    public function getNrInCart()
    {
        $this->di->get("database")->connect();
        $sql = "SELECT items FROM WSCartView WHERE cart = ?";
        $param = [$this->di->get("session")->get('userid', 0)];
        $res = $this->di->get("database")->execute($sql, $param);
        $nrincart = 0;
        foreach ($res as $row) {
            $nrincart = $nrincart + intval($row->items);
        }
        return $nrincart;
    }
}
