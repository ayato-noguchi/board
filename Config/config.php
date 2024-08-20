<?php
ini_set('display_errors', 1);
define('DSN', 'mysql:host=localhost;charset=utf8;dbname=board'); //データベース接続
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/BOARD/public');
require_once(__DIR__ . '/../Controller/functions.php');//サニタイズ機能を読み込む
session_start();
