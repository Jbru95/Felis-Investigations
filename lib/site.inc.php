<?php
/**
 * @file
 * A file loaded for all pages on the site.
 */
require __DIR__ . "/../vendor/autoload.php";

$site = new Felis\Site();
$localize = require 'localize.inc.php';
if(is_callable($localize)) {
    $localize($site);
}

//Start the Session system
session_start();
$user = null;
if(isset($_SESSION[Felis\User::SESSION_NAME])){   //if user session is set
    $user = $_SESSION[Felis\User::SESSION_NAME]; //$user equals that user object
}

//redirect if user is not logged in

if(!isset($open) && $user === null){//using $open to indicate that a page can be accessed without logging in(home and login)
    $root = $site->getRoot();
    header("location: $root/");
    exit;
}