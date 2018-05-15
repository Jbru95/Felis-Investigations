<?php

//echo "<pre>";//for variable testing
//print_r($_POST);
//echo "</pre>";

require '../lib/site.inc.php';

$controller = new Felis\CaseController($site, $_POST, $_GET);
header("location: " . $controller->getRedirect());