<?php
require_once(__DIR__ .'/header.php');
require_once(__DIR__ .'/../Controller/Thread.php');
$app = new Board\Controller\Thread();
$app->run();

?>
<h1 class="page__ttl">スレッド検索</h1>
<form action="" method="post" class="form-group thread_form" >
  <div class="form-group">
    <input type="text" name="search" class="form-control">
    <input type="hidden" name="token" value="<?= h($_SESSION['token']) ; ?>">
    <input type="hidden" name="type" value="search_thread">
    <?php if(isset($_SESSION['error_message'])): ?>
    <p id="err1" class="err"><?= h($_SESSION['error_message']); ?></p>
    <?php endif;?>
  </div>
  <button type="submit" class="btn btn-primary">検索する</button>
</form>
