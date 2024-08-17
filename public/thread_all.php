<?php
require_once(__DIR__ .'/header.php');
require_once(__DIR__ .'/../Model/Thread.php');
$threadModel = new Board\Model\Thread();
$threads = $threadModel->getThreadAll();
//var_dump($threads);
?>
<h1 class="page__ttl">スレッド一覧</h1>
<ul class="thread">
  <?php foreach($threads as $thread): ?>
    <li class="thread__item">
      <div class="thread__head">
        <h2 class="thread__ttl">
          <?= h($thread->title); ?>
        </h2>
        <div><i class="fas fa-star"></i></div>
      </div>
      <ul class="thread__body">
        <li class="comment__item">
          <div class="comment__item__head">
          
            <span class="comment__item__name"><?= h($thread->user_name); ?></span>
            <span class="comment__item__num"><?= h($thread->comment); ?></span>
          </div>

        </li>
      </ul>
      <div class="operation">
        <a href="thread_update.php?id=<?= urldecode($thread->id); ?>">投稿編集</a>
        <a href="thread_delete.php?id=<?= urldecode($thread->id); ?>">投稿削除</a>
        <?php
        $date = new DateTime($thread->created_at);
        $formatteDate = $date->format('Y年m月d日 H:i:s');
        ?>
        <p class="thread__date">スレッド作成日  <?= h($formatteDate); ?></p>
        
    </li>
  <?php endforeach?>
</ul>
