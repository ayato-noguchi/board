<?php
namespace Board\Controller;

use Exception;

require_once(__DIR__ . '/../Model/Thread.php');
require_once(__DIR__ . '/../Controller/Controller.php');
require_once(__DIR__ . '/../Controller/Image_upload.php');

class Thread  extends \Board\Controller
{
  public function run()
  {
    if ($this->isLoggedIn()) {
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if ($_POST['type'] === 'createthread') {
          $this->createThread();
        }

        if ($_POST['type'] === 'update_thread') {
          $this->updateThread();
        }

        if ($_POST['type'] === 'delete_thread') {
          $this->deleteThread();
        }

        if ($_POST['type'] === 'search_thread') {
          $this->searchThread();
        }
      }

      if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET['action']) && $_GET['action'] === 'thread_all') {
          $this->threadAll();
        }
      }
    } else {
      header('Location: signup.php');
      exit();
    }
  }


  protected function createThread()
  {
    try{
      if(empty($_POST)){
       throw new Exception('フォームが送信されていません。');
      }
      $this->validateToken();
     } catch (Exception $e) {
      $e->getMessage();
      return;
     }
   
    if(isset($_FILES['image']) && !empty($_FILES['image']['name'])){
      $image = Image_uploade::upload($_FILES['image']);
    } else {
      $image = null;
    }

    $threadModel = new \Board\Model\Thread();

    $threadModel->createThread([
      'title' => $_POST['title'],
      'comment' => $_POST['comment'],
      'user_id' => $_SESSION['me']['id'],
      'image' => $image
    ]);

    $response = array(
      "status" => "success",
      "message" => "スレッドが作成されました"
    );

    header("Content-type: application/json; charset=UTF-8");

    echo json_encode($response);
    header('Location: thread_all.php');
    exit;
  }

  protected function updateThread()
  {
    
    try{
      if(empty($_POST)){
       throw new Exception('フォームが送信されていません。');
      }
      $this->validateToken();
     } catch (Exception $e) {
      $e->getMessage();
      return;
     }
     
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

  protected function deleteThread()
  {
    try{
      $this->validateToken();
    } catch(Exception $e){
      $e->getMessage();
    }
    $threadModel = new \Board\Model\Thread();
   
    $threadModel->deleteThread($_POST['id']);

    header('Location: /BOARD/public/thread_all.php?action=thread_all');
    exit;
  }

  protected function threadAll()
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
 
    header('Location: thread_all.php');

    exit;
  }

  protected function searchThread()
  {

    $threadModel = new \Board\Model\Thread();

    $searchResult = $threadModel->searchThread($_POST['search']);
    
    $_SESSION['search_result'] = $searchResult;

    header('Location: thread_result.php');

    exit;
  }
}
