<?php
require_once(__DIR__ .'/header.php');
require_once(__DIR__ .'/../Controller/Thread.php');
$app = new Board\Controller\Thread();
$app->run();

?>
<h1 class="page__ttl">新規スレッド</h1>
<form action="" method="post" class="form-group new_thread" id="new_thread">
  <div class="form-group">
    <label>名前</label>
    <input type="text" name="user_name" class="form-control" value="<?= isset($_POST['user_name']) ? h($_POST['user_name']) : ''; ?>">
  </div>
  <div class="form-group">
    <label>タイトル</label>
    <input type="text" name="title" class="form-control" value="<?= isset($_POST['title']) ? h($_POST['title']) : ''; ?>">
  </div>
  <div class="form-group">
    <label>コメント</label>
    <textarea type="text" name="comment" class="form-control"><?= isset($_POST['comment']) ? h($_POST['comment']) : ''; ?></textarea>
    <input type="hidden" name="token" value="<?= h($_SESSION['token']) ; ?>">
    <input type="hidden" name="type" value="createthread">
    <p class="err"></p>
  </div>
  <div class="form-group btn btn-primary" onclick="document.getElementById('new_thread').submit();">作成</div>
</form>
