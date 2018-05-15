<?php


require '../lib/site.inc.php';

$controller = new Felis\DeleteCaseController($site, $_POST);
header("location: " . $controller->getRedirect());