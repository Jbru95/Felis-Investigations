<?php
/**
 * Created by PhpStorm.
 * User: Jayson
 * Date: 3/19/2018
 * Time: 6:02 PM
 */

$open = true;
require '../lib/site.inc.php';

$controller = new Felis\LoginController($site, $_SESSION, $_POST);
header("location: " . $controller->getRedirect());