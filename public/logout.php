<?php
require_once(__DIR__ . '/header.php');
require_once(__DIR__ .'/../Controller/Logout.php');
$app = new Board\Controller\Logout();
$app->run();
