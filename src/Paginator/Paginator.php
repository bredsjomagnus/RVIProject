<?php

namespace Maaa16\Paginator;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;

/**
 * A controller for the Commentary.
 *
 * @SuppressWarnings(PHPMD.ExitExpression)
 */
class Paginator implements InjectionAwareInterface
{
    use InjectionAwareTrait;

    public function getLinkMenu()
    {
        $url        = $this->di->get("url");

        //-----------------------------------------------

        $linkmenu   = "<a href='".$url->create("data")."'>Data - index</a> | ";
        $linkmenu  .= "<a href='".$url->create("data/reports")."'>Rapporter</a> | ";
        $linkmenu  .= "<a href='".$url->create("data/animals")."'>Djur</a>";

        //-----------------------------------------------

        return $linkmenu;
    }

    /**
    * Bygger upp sökfälts- och filtreringskontorllen
    *
    */
    public function sortCtrl($searchcolumn)
    {
        $titlechecked   = ($searchcolumn == 'title') ? "checked" : "";
        $tagschecked    = ($searchcolumn == 'tags') ? "checked" : "";
        // $userchecked    = ($searchcolumn == 'user') ? "checked" : "";

        $sortCtrl = "<form action='#' method='GET'>
                        <div class='input-group'>
                            <span class='input-group-addon'>
                                <label>Titel</label>
                                <input type='radio' name='searchcolumn' value='title' aria-label='...' ".$titlechecked.">
                            </span>
                            <span class='input-group-addon'>
                                <label>Etikett</label>
                                <input type='radio' name='searchcolumn' value='tags' aria-label='...' ".$tagschecked.">
                            </span>
                            <input type='text' class='form-control' name='search' placeholder='Använd % som wildcards...'>
                            <span class='input-group-btn'>
                                <button class='btn btn-default' type='submit'><span class='glyphicon glyphicon-search'></span></button>
                            </span>
                        </div>
                    </form>";
        return $sortCtrl;
    }

    /**
    * Ser till att sidnumret enbart är mellan 1 och sista sidan
    *
    * @param int $pagenum, nuvarande sidnummer
    * @param int $lastpage, sista sidan/antalet sidor.
    *
    * @return $pagenum, kontrollerat sidnummer
    */
    public function validIntervall($pagenum, $lastpage)
    {
        if ($pagenum < 1) {
            $pagenum = 1;
        } else if ($pagenum > $lastpage) {
            $pagenum = $lastpage;
        }
        return $pagenum;
    }

    /**
    * Ser till att sista sidan inte kan vara negativ
    *
    * @param int $lastpage, sista sidan/antalet sidor.
    *
    * @return $lastpage, kontrollera sista sida/antalet sidor
    */
    public function validLastPage($lastpage)
    {
        if ($lastpage < 1) {
            $lastpage = 1;
        }
        return $lastpage;
    }

    /**
    * Ger information om hur många rader en tabell innehåller
    * @param string $table tabellnamn
    * @param array $tblprop med information om sökning ['searchcolumn' => , 'search' => , 'pages' =>, 'orderby' =>, 'orderas' =>]
    *
    * @return int count($searchres) antalet rader $table innehåller.
    */
    public function getTableCount($table, $tblprop)
    {
        $db         = $this->di->get("db");

        //-----------------------------------------------

        $db->connect();

        $sql = "SELECT * FROM $table WHERE deleted IS NULL AND ? LIKE ?";
        $params = [$tblprop['searchcolumn'], $tblprop['search']];
        $searchres = $db->executeFetchAll($sql, $params);

        //-----------------------------------------------

        return count($searchres);
    }

    /**
    * Sammanbindande metod för framtagande av tabellresulstat med paginator. Resultat skickas tillbaka till kontrollern.
    * @param string $table tabellnamn som söks mot
    * @param array $tblprop med information om sökning ['searchcolumn' => , 'search' => , 'pages' =>, 'orderby' =>, 'orderas' =>]
    * @param int $pagenum nuvarande sida
    *
    * @return array $paginator ['tblres' => html, max => tot antal rader i tabell, current => nuvarande sida av totalt, ctrl => paginatorkontrollern]
    */
    public function paginator($table, $tblprop, $pagenum)
    {

        $session            = $this->di->get("session");

        //Antalet rader i $table för nuvarande $tblprop['search'] i $tblprop['searchcolumn']
        $searchcount        = $this->getTableCount($table, $tblprop);
        // Antalet sidor för tabellen med nuvarande sökning.
        $lastpage           = ceil($searchcount/$tblprop['pages']);
        // Ser till att antalet sidor inte är negativt
        $lastpage           = $this->validLastPage($lastpage);
        // Ser till att sidnumret enbart kan vara mellan 1 och sista sidan.
        $pagenum            = $this->validIntervall($pagenum, $lastpage);

        $pgnprop = [
            "searchcount"   => $searchcount,
            "pagenum"       => $pagenum,
            "lastpage"      => $lastpage,
        ];

        $paginatorsearch    = $this->paginatorSearch($table, $tblprop, $pgnprop);
        $pgnctrl            = $this->paginatorCtrl($pgnprop);

        // array('res' => $res, 'max' =>  $textline1, 'current' => $textline2, 'ctrl' => $pagenationrow);
        $paginator = [
            'tableres'      => $paginatorsearch,
            'max'           => $pgnctrl['max'],
            'current'       => $pgnctrl['current'],
            'pgnctrl'       => $pgnctrl['paginatorctrl'],
        ];

        $session->set("pgnprop", $pgnprop);
        $session->set("paginator", $paginator);


        return $paginator;
    }

    /**
    * Utför sökning som skall ge resultat som visas upp. Tar hänsyn till sökning, sortering och limit pga pages
    *
    * @param string $table tabellen som sökes emot
    * @param array $tblprop information om sökning ['searchcolumn' => , 'search' => , 'pages' =>, 'orderby' =>, 'orderas' =>]
    * @param array $pgnprop paginatorprop ['searchcount' => totala antalet rader i tabell, 'pagenum' => nuvarande sida, 'lastpage' => antalet sidor]
    *
    * @return object $res resultatet av sökningen
    */
    public function paginatorSearch($table, $tblprop, $pgnprop)
    {
        $db         = $this->di->get("db");

        //---------------------------------------------------------

        $search     = "WHERE deleted IS NULL AND ".$tblprop['searchcolumn']." LIKE ? ";
        $order      = 'ORDER BY '.$tblprop['orderby']." ".$tblprop['orderas']." ";
        $limit      = 'LIMIT '.($pgnprop['pagenum'] - 1 ) * $tblprop['pages'].', '.$tblprop['pages'];

        //---------------------------------------------------------

        $sql = "SELECT * FROM $table $search $order $limit";
        $params = [$tblprop['search']];
        $res = $db->executeFetchAll($sql, $params);

        return $res;
    }

    /**
    * Bygger upp en paginators kontroll för att byta sida.
    *
    * @param array $pgnprop paginatorproporties ['searchcount' => totala antalet rader i tabell, 'pagenum' => nuvarande sida, 'lastpage' => antalet sidor]
    *
    * @return string $paginatorctrl, kontrollern för att byta sida i paginerad tabell.
    */
    public function paginatorCtrl($pgnprop)
    {
        $textline1 = "Object (".$pgnprop['searchcount'].")";
        $textline2 = "Sida ".$pgnprop['pagenum']." av ".$pgnprop['lastpage'];

        $paginatorctrl = "<ul class='pagination'>";
        if ($pgnprop['lastpage'] != 1) {
            $paginatorctrl = $this->paginatorLeftCtrl($pgnprop['pagenum'], $paginatorctrl);
            $paginatorctrl .= "<li><a class='paginatoractive'>".$pgnprop['pagenum']."</a></li>";
            $paginatorctrl = $this->paginatorRightCtrl($pgnprop['pagenum'], $pgnprop['lastpage'], $paginatorctrl);
        }
        $paginatorctrl .= "</ul>";

        $pgnctrl = [
            "paginatorctrl"     => $paginatorctrl,
            "max"               => $textline1,
            "current"           => $textline2,
        ];

        return $pgnctrl;
    }

    /**
    * Generate leftside of the paginator for a table
    *
    * @param integer $pagenum page number.
    * @param string $paginatorctrl first part of the paginator
    *
    * @return string $pagenationrow first part of the paginator with added content
    */
    private function paginatorLeftCtrl($pagenum, $paginatorctrl)
    {
        if ($pagenum <= 1) {
            $paginatorctrl .= "<li><a class='deadpaginatorarrow' href='#'>" .htmlspecialchars("<<"). "</a></li>";
        }
        if ($pagenum > 1) {
            $previous = $pagenum - 1;
            $url = $_SERVER['PHP_SELF'].'?pn='.$previous;
            $paginatorctrl .= "<li><a href='$url'>" .htmlspecialchars("<<"). "</a></li>";

            if ($pagenum-4 > 0) {
                $paginatorctrl .= '<li><a>...</a></li>';
            }
            for ($i = $pagenum-3; $i < $pagenum; $i += 1) {
                if ($i > 0) {
                    $url = $_SERVER['PHP_SELF'].'?pn='.$i;
                    $paginatorctrl .= "<li><a href='$url'>".$i."</a></li>";
                }
            }
        }
        return $paginatorctrl;
    }

    /**
    * Generate right side of the paginator for a table
    *
    * @param integer $pagenum page number.
    * @param integer $lastpage lastpage for the paginator
    * @param string $paginatorctrl first part of the paginator containing left side
    * @return string $paginationrow containing left side and now also right side of paginator
    */
    private function paginatorRightCtrl($pagenum, $lastpage, $paginatorctrl)
    {
        for ($i = $pagenum+1; $i <= $lastpage; $i += 1) {
            if ($i < $pagenum+4) {
                $url = $_SERVER['PHP_SELF'].'?pn='.$i;
                $paginatorctrl .= "<li><a href='$url'>".$i."</a></li>";
            } else if ($i == $pagenum+4) {
                $paginatorctrl .= '<li><a>...</a></li>';
            } else if ($i >= $pagenum+4) {
                break;
            }
        }
        if ($pagenum != $lastpage) {
            // var_dump($pagenum);
            $next = $pagenum + 1;
            $paginatorctrl .= '<li><a href="'.$_SERVER['PHP_SELF'].'?pn='.$next.'#objrefpoint"> ' .htmlspecialchars(">>"). ' </a></li>';
        }

        if ($pagenum == $lastpage) {
            $paginatorctrl .= '<li><a class="deadpaginatorarrow" href="#"> ' .htmlspecialchars(">>"). ' </a></li>';
        }
        return $paginatorctrl;
    }
}
