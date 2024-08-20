<?php
require_once(__DIR__ .'/header.php');
require_once(__DIR__ .'/../Controller/Thread.php');
$app = new Board\Controller\Thread();
$app->run();

//投稿詳細を表示
$threadModel = new Board\Model\Thread();
$id = $_GET['id'];
$thread = $threadModel->getThreadId($id);
//var_dump($thread);
?>
<h1 class="page__ttl">スレッド編集</h1>

<form action="" method="post" class="form-group thread_form" id="update_thread">
  <input type="hidden" name="id" value="<?= h($thread->id); ?>">
  <div class="form-group">
    <label>タイトル</label>
    <input type="text" name="title" class="form-control" value="<?= isset($_POST['title']) ? h($_POST['title']) : h($thread->title); ?>">
    <p id="err2" class="err"></p>
  </div>
  <div class="form-group">
    <label>コメント</label>
    <textarea type="text" name="comment" class="form-control"><?= isset($_POST['comment']) ? h($_POST['comment']) : h($thread->comment); ?></textarea>
    <input type="hidden" name="token" value="<?= h($_SESSION['token']) ; ?>">
    <input type="hidden" name="type" value="update_thread">
    <p id="err3" class="err"></p>
  </div>
  <button type="submit" class="btn btn-primary">更新</button>
</form>
<script src="./js/validation.js"></script>