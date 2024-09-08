<?php
namespace Board\Controller;

use Exception;

require_once(__DIR__ . '/../Model/Thread.php');
require_once(__DIR__ . '/../Controller/Controller.php');

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
    $this->validateToken();
   } catch(Exception $e) {
    $e->getMessage();
   }
    
    $temp_file = null; 
    $image = null; 
    if(isset($_FILES)) {
      $temp_file = $_FILES['image']['tmp_name'];
      $dir = __DIR__ . '/../public/uploads/';
    } 
 
    if(file_exists($temp_file)) { //画像が存在するかチェック
      $image = uniqid(mt_rand(), false); //ファイル名をユニーク化
      switch(@exif_imagetype($temp_file)) { //画像ファイルかチェック
        case IMAGETYPE_GIF:
          $image .= '.gif';
          break;
        case IMAGETYPE_JPEG:
          $image .= '.jpg';
          break;
         case IMAGETYPE_PNG:
          $image .= '.png';
          break;
          default:
           echo '拡張子を変更してください。';   
           return;
      }
          // アップロードされたファイルを保存
          if (!move_uploaded_file($temp_file, $dir . $image)) {
            echo "ファイルのアップロードに失敗しました。";
            return;
        }
    }

    $threadModel = new \Board\Model\Thread();

    $threadModel->createThread([
      'title' => $_POST['title'],
      'comment' => $_POST['comment'],
      'user_id' => $_SESSION['me']['id'],
      'image' => $image
    ]);

    // $response = array(
    //   "status" => "success",
    //   "message" => "スレッドが作成されました"
    // );

    // header("Content-type: application/json; charset=UTF-8");

    // echo json_encode($response);
    header('Location: thread_all.php');
    exit;
  }

  protected function updateThread()
  {
    $this->validateToken();

    $threadModel = new \Board\Model\Thread();

    $threadModel->updateThread([
      'title' => $_POST['title'],
      'comment' => $_POST['comment'],
      'id' => $_POST['id'],
      'user_id' => $_SESSION['me']['id']
    ]);

    header('Location: thread_all.php');
    exit;
  }

  protected function deleteThread()
  {
    $this->validateToken();

    $threadModel = new \Board\Model\Thread();
   
    $threadModel->deleteThread($_POST['id']);

    header('Location: thread_all.php');
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
    // var_dump($_SESSION);
    // exit;
    header('Location: thread_all.php');

    exit;
  }

  protected function searchThread()
  {

    $threadModel = new \Board\Model\Thread();

    $searchResult = $threadModel->searchThread($_POST['search']);
    //var_dump($searchResult);
    $_SESSION['search_result'] = $searchResult;

    header('Location: thread_result.php');

    exit;
  }
}
