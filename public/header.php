<?php
require_once(__DIR__ . '/../config/config.php');
require_once(__DIR__ .'/../Controller/Login.php');
?>
<!DOCTYPE html>
<html lang="ja">

<head>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <link rel="stylesheet" href="css/styles.css">
  <title>掲示板</title>
</head>

<body>

  <header class="sticky-top header">
    <div class="header__inner">
      <nav>
        <ul>
          <li><a href="">ホーム</a></li>
          <?php if (isset($_SESSION['me'])) { ?>
            <li><a href="<?= SITE_URL; ?>/thread_all.php?action=thread_all">一覧</a></li>
            <li><a href="<?= SITE_URL; ?>/thread_create.php">新規投稿</a></li>
            <li><a href="<?= SITE_URL; ?>/thread_search.php">検索</a></li>
          <?php } else { ?>
            <li class="user-btn"><a href="<?= SITE_URL; ?>/login.php">ログイン</a></li>
            <li><a href="<?= SITE_URL; ?>/signup.php">ユーザー登録</a></li>
          <?php } ?>
        </ul>
      </nav>
      <div class="header-r">
        <?php

        if (isset($_SESSION['me'])) {
        ?>
          <form action="logout.php" method="post" id="logout" class="user-btn">
            <input type="submit" value="ログアウト">
            <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
          </form>
        <?php  } ?>
      </div>
    </div>
  </header>
  <div class="wrapper">