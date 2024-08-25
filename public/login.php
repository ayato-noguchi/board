<?php
require_once(__DIR__ . '/header.php');
require_once(__DIR__ .'/../Controller/Login.php');
$app = new Board\Controller\Login();
$app->run();
?>
<div class="container">
<h1 class="page__ttl">ログイン</h1>
  <form action="" method="post" id="login" class="form">
    <div class="form-group">
      <label>メールアドレス</label>
      <input type="text" name="email" class="form-control">
    </div>
    <div class="form-group">
      <label>パスワード</label>
      <input type="password" name="password" class="form-control">
    </div>
    <button class="btn btn-primary" onclick="document.getElementById('login').submit();">ログイン</button>
    <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
  </form>
  <p class="fs12"><a href="signup.php">ユーザー登録</a></p>
</div>