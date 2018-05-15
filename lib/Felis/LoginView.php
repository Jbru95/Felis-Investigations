<?php
/**
 * Created by PhpStorm.
 * User: Jayson
 * Date: 3/19/2018
 * Time: 6:43 PM
 */

namespace Felis;


class LoginView extends View {

    private $login_failed = false;

    public function __construct($session, $get){

        $this->setTitle('Felis Investigations');

        if (isset($get['e'])){
            $this->login_failed = true;
        }
    }


    public function presentForm() {

        if($this->login_failed == false) {
            $html = "";
        } else{
            $html =  '<p class="msg">Invalid login credentials</p>';
        }

            $html .= <<<HTML
<form method="post" action="post/login.php">
    <fieldset>
        <legend>Login</legend>
        <p>
            <label for="email">Email</label><br>
            <input type="email" id="email" name="email" placeholder="Email">
        </p>
        <p>
            <label for="password">Password</label><br>
            <input type="password" id="password" name="password" placeholder="Password">
        </p>
        <p>
            <input type="submit" value="Log in"> <a href="">Lost Password</a>
        </p>
        <p><a href="./">Felis Agency Home</a></p>

    </fieldset>
</form>
HTML;

        return $html;
    }
}