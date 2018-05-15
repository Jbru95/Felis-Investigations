<?php
/**
 * Created by PhpStorm.
 * User: Jayson
 * Date: 3/21/2018
 * Time: 11:59 AM
 */

require '../lib/site.inc.php';

$controller = new Felis\CasesController($site, $_POST);
header("location: " . $controller->getRedirect());