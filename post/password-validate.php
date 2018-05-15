<?php

$open = true;
require '../lib/site.inc.php';

$controller = new Felis\PasswordValidateController($site, $_POST);
header("location: " . $controller->getRedirect());