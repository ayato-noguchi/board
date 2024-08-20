<?php
require_once(__DIR__ . '/header.php');
require_once(__DIR__ .'/../Controller/Signup.php');
$app = new Board\Controller\Signup();
$app->run();
?>
<div class="container">
<h1 class="page__ttl">ユーザー登録</h1>
  <form action="" method="post" id="signup" class="form">
  <div class="form-group">
      <label>ユーザー名</label>
      <input type="text" name="username" value="" class="form-control">
      <p class="err"></p>
    </div>
    <div class="form-group">
      <label>メールアドレス</label>
      <input type="text" name="email" value="" class="form-control">
      <p class="err"></p>
    </div>
    <div class="form-group">
      <label>パスワード</label>
      <input type="password" name="password" class="form-control">
      <p class="err"></p>
    </div>
    <button class="btn btn-primary" onclick="document.getElementById('signup').submit();">登録</button>
    <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
  </form>
  <p class="fs12"><a href="<?= SITE_URL; ?>/login.php">ログイン</a></p>
</div>
