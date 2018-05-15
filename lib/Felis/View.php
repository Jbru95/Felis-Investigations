<?php
/**
 * Created by PhpStorm.
 * User: Jayson
 * Date: 3/13/2018
 * Time: 3:30 PM
 */

namespace Felis;


class View{

    protected $title = "";
    protected $links = array(); ///< Links to add to the nav bar
    private $protectRedirect = null; /// Page protection redirect

    /**
     * Protect a page for staff only access
     *
     * If access is denied, call getProtectRedirect
     * for the redirect page
     * @param $site The Site object
     * @param $user The current User object
     * @return bool true if page is accessible
     */
    public function protect($site, $user) {
        if($user->isStaff()) {
            return true;
        }

        $this->protectRedirect = $site->getRoot() . "/";
        return false;
    }

    /**
     * Get any redirect page
     */
    public function getProtectRedirect() {
        return $this->protectRedirect;
    }



    public function footer(){

        return <<<HTML
<footer><p>Copyright © 2017 Felis Investigations, Inc. All rights reserved.</p></footer>
HTML;
    }


    public function setTitle($title) {
        $this->title = $title;
    }


    public function head(){
        return <<<HTML
<meta charset="utf-8">
<title>$this->title</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="lib/css/felis.css">
HTML;
    }

    public function header() {
        $html = <<<HTML
<nav>
    <ul class="left">
        <li><a href="./">The Felis Agency</a></li>
    </ul>
HTML;

        if(count($this->links) > 0) {
            $html .= '<ul class="right">';
            foreach($this->links as $link) {
                $html .= '<li><a href="' .
                    $link['href'] . '">' .
                    $link['text'] . '</a></li>';
            }
            $html .= '</ul>';
        }

        $additional = $this->headerAdditional();

        $html .= <<<HTML
</nav>
<header class="main">
    <h1><img src="images/comfortable.png" alt="Felis Mascot"> $this->title
    <img src="images/comfortable.png" alt="Felis Mascot"></h1>
    $additional
</header>
HTML;
        return $html;
    }


    public function addLink($href, $text){
        $this->links[] = array("href" => $href, "text" => $text);
    }

    protected function headerAdditional(){//default virtual function, extended in child classes

        return '';
    }


}