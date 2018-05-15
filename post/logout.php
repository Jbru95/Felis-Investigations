<?php
/**
 * Created by PhpStorm.
 * User: Jayson
 * Date: 3/19/2018
 * Time: 6:20 PM
 */

require '../lib/site.inc.php';



if(isset($_SESSION[Felis\User::SESSION_NAME])) {
    unset($_SESSION[Felis\User::SESSION_NAME]);
}

$root = $site->getRoot();

header("location: $root");