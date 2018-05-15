<?php
require '../lib/site.inc.php';

$controller = new Felis\UserController($site, $user, $_POST);
header("location: " . $controller->getRedirect());