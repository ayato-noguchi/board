<?php
require_once(__DIR__ .'/header.php');
require_once(__DIR__ .'/../Model/Thread.php');
require_once(__DIR__ .'/../Controller/Thread.php');
// $threadModel = new Board\Model\Thread();
// $threads = $threadModel->getThreadAll();
// var_dump($_SESSION['me'])
$app = new Board\Controller\Thread();
$app->run();
$threads = isset($_SESSION['threads']) ? $_SESSION['threads'] : [];
$totalPages = isset($_SESSION['total_pages']) ? $_SESSION['total_pages'] : 1;
$current_page = isset($_SESSION['current_page']) ? $_SESSION['current_page'] : 1;


?>
<h1 class="page__ttl">スレッド一覧</h1>
<ul class="thread">
  <?php foreach($threads as $thread): ?>
    <li class="thread__item">
      <div class="thread__head">
        <h2 class="thread__ttl">
          <?= h($thread->title); ?>
        </h2>
      </div>
      <ul class="thread__body">
        <li class="comment__item">
            <span class="comment__item__content"><?= h($thread->comment); ?></span>
        </li>
        <?php if(isset($thread->image)): ?>
        <li class="comment__item">
          <img src="uploads/<?= ($thread->image); ?>" width="200" height="200">
        </li>
        <?php endif; ?>
      </ul>
      <div class="operation">
        <?php  if(isset($_SESSION['me']['id']) && $_SESSION['me']['id'] === $thread->user_id) {?>
        <a href="thread_update.php?id=<?= urlencode($thread->id); ?>">投稿編集</a>
        <a href="thread_delete.php?id=<?= urlencode($thread->id); ?>">投稿削除</a>
        <?php } else { ?>

        <?php }?>
        <?php
        $date = new DateTime($thread->created_at);
        $formatteDate = $date->format('Y年m月d日 H:i:s');
        ?>
        <p class="thread__date">スレッド作成日  <?= h($formatteDate); ?></p>
      </div>
    </li>
  <?php endforeach?>
</ul>
<div class="pagination">
  <?php if ($current_page > 1): ?>
    <a href="?action=thread_all&page=<?= $current_page - 1; ?>">前のページ</a>
  <?php endif; ?>

  <?php for ($i = 1; $i <= $totalPages; $i++): ?>
    <a href="?action=thread_all&page=<?= $i; ?>" class="<?= $i === $current_page ? 'current' : ''; ?>">
      <?= $i; ?>
    </a>
  <?php endfor; ?>

  <?php if ($current_page < $totalPages): ?>
    <a href="?action=thread_all&page=<?= $current_page + 1; ?>">次のページ</a>
  <?php endif; ?>
</div>