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
    <input type="hidden" name="type" value="search_thread">
    <p id="err1" class="err"></p>
  </div>
  <button type="submit" class="btn btn-primary">検索する</button>
</form>
