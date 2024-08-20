<?php
require_once(__DIR__ .'/header.php');
require_once(__DIR__ .'/../Controller/Thread.php');
$app = new Board\Controller\Thread();

$searchResults = isset($_SESSION['search_result']) ? $_SESSION['search_result'] : [];
//var_dump($searchResults);
?>
<h1 class="page__ttl">検索結果</h1>
<ul class="thread">
 <?php if(!empty($searchResults)): ?> 
  <?php foreach($searchResults as $result): ?>
    <li class="thread__item">
      <div class="thread__head">
        <h2 class="thread__ttl">
          <?= h($result->title); ?>
        </h2>
      </div>
      <ul class="thread__body">
        <li class="comment__item">
            <span class="comment__item__content"><?= h($result->comment); ?></span>
        </li>
      </ul>
      <div class="operation">
        <a href="thread_update.php?id=<?= urldecode($result->id); ?>">投稿編集</a>
        <a href="thread_delete.php?id=<?= urldecode($result->id); ?>">投稿削除</a>
        <?php
        $date = new DateTime($result->created_at);
        $formatteDate = $date->format('Y年m月d日 H:i:s');
        ?>
        <p class="thread__date">スレッド作成日  <?= h($formatteDate); ?></p> 
    </li>
  <?php endforeach; ?>
  <?php else: ?>
    <p>検索結果はありません</p>
  <?php endif; ?>
</ul>

<a href="thread_search.php" class="btn btn-primary">戻る</a>
