<?php
require_once(__DIR__ .'/header.php');
require_once(__DIR__ .'/../Controller/Thread.php');
$app = new Board\Controller\Thread();
$app->run();

?>
<h1 class="page__ttl">新規スレッド</h1>
<form action="" method="post" class="form-group thread_form" id="new_thread" enctype="multipart/form-data">
  <div class="form-group">
    <label>タイトル</label>
    <input type="text" name="title" id="title" class="form-control" value="<?= isset($_POST['title']) ? h($_POST['title']) : ''; ?>">
    <p id="err1" class="err"></p>
  </div>
  <div class="form-group">
    <label>コメント</label>
    <textarea type="text" name="comment" id="comment" class="form-control"><?= isset($_POST['comment']) ? h($_POST['comment']) : ''; ?></textarea>
    <p id="err2" class="err"></p>
  </div>
  <div class="form-group">
    <label>画像</label>
    <input type="file" name="image" id="image" class="form-control">
    <input type="hidden" name="token" value="<?= h($_SESSION['token']) ; ?>">
    <input type="hidden" name="type" value="createthread">
    <p id="err3" class="err"></p>
  </div>
  <p id="errors" class="error"></p>
  <button type="submit" class="btn btn-primary" id="send" >作成</button>
</form>
<script src="./js/validation.js"></script>
<script src="./js/send.js"></script>