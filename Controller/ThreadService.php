<?php 

namespace Board\Controller;

use Exception;

require_once(__DIR__ .'/../Model/User.php');

class ThreadService extends \Board\Controller
{
  private $thread;

  public function get_create_thread() 
  {
    if (! isset($_GET['action']) || $_GET['action'] !== 'create') {
      header('Location: thread_create.php?action=create');
      exit();
    }
  }
  
  public function create_thread()
  {
    $threadModel = new \Board\Model\Thread();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      if ( isset($_FILES['image']) && ! empty($_FILES['image']['name'])) {
        $image = Image_uploade::upload($_FILES['image']);
      } else {
        $image = null;
      }
      $threadModel->createThread([
        'title' => $_POST['title'],
        'comment' => $_POST['comment'],
        'user_id' => $_SESSION['me']['id'],
        'image' => $image
      ]);
    }
    $response = array(
      "status" => "success",
      "message" => "スレッドが作成されました"
    );
    header("Content-type: application/json; charset=UTF-8");
    echo json_encode($response);
  }

  public function update_thread()
  {
    $threadModel = new \Board\Model\Thread();

    $current_image = $threadModel->getThreadId($_POST['id']);
    $dir = __DIR__ . '/../public/uploads/'; 

    // 既存の画像がある場合、削除する
    if (!empty($current_image->image) && file_exists($dir . $current_image->image)) {
        unlink($dir . $current_image->image); // 既存ファイルを削除
      }
      
    // 新しい画像をアップロード
    $image = Image_uploade::upload($_FILES['image']);
      
    $threadModel->updateThread([
      'title' => $_POST['title'],
      'comment' => $_POST['comment'],
      'id' => $_POST['id'],
      'user_id' => $_SESSION['me']['id'],
      'image' => $image
    ]);

    header('Location: thread_all.php');
    exit;
  }
  public function delete_thread()
  {
    try{
      $this->validateToken();
    } catch(Exception $e){
      $e->getMessage();
    }

    $thread_id = $_POST['id'];
    $threadModel = new \Board\Model\Thread();
    $thread = $threadModel->getThreadId($thread_id);

    if($_SESSION['me']['id'] === $thread->user_id){
      $threadModel->deleteThread($thread_id);
    }
    header('Location: /BOARD/public/thread_all.php?action=thread_all');
    exit;
  }

  public function search_thread()
  {
    try{
      if(empty($_POST['search'])) {
        $_SESSION['error_message'] = ('検索が入力されていません。');
        header('Location: thread_search.php'); 
        exit;
      }
      $this->validateToken();
    } catch (Exception $e){
      $e->getMessage();
    }

    if (strlen($_POST['search']) > 255) {
      throw new Exception('検索クエリが長すぎます。');
   }
  
    $threadModel = new \Board\Model\Thread();
    $searchResult = $threadModel->searchThread($_POST['search']);  
    $_SESSION['search_result'] = $searchResult;

    header('Location: thread_result.php');
    exit;
  }

  public function thread_all()
  {
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $perPage = 5;
    // ページ番号に基づいてデータの開始位置を計算
    $offset = ($page - 1) * $perPage;

    $threadModel = new \Board\Model\Thread();

    // オフセットとページ当たりのアイテム数を指定して取得
    $threads = $threadModel->getThreadAll($offset, $perPage);

    // 投稿の総数
    $totalThreads = $threadModel->getThreadCount();

    // 総ページを計算
    $totalPages = ceil($totalThreads / $perPage);

    $_SESSION['threads'] = $threads;
    $_SESSION['total_pages'] = $totalPages;
    $_SESSION['current_page'] = $page;
  }
}