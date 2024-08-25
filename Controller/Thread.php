<?php 
namespace Board\Controller;


require_once(__DIR__ .'/../Model/Thread.php');
require_once(__DIR__ . '/../Controller/Controller.php');

class Thread  extends \Board\Controller
{
  public function run()
  {
    //var_dump($_SESSION['token']);
    if($_SERVER['REQUEST_METHOD'] === 'POST')
    {
      if($_POST['type'] === 'createthread')
      {
        $this->createThread();
      } 
      
      if ($_POST['type'] === 'update_thread')
      {
        $this->updateThread();
      } 

      if($_POST['type'] === 'delete_thread')
      {
        $this->deleteThread();
      }

      if($_POST['type'] === 'search_thread')
      {
        $this->searchThread();
      }
    }
  }


  protected function createThread()
  {
    $this->validateToken();

    $threadModel = new \Board\Model\Thread();
// var_dump($_SESSION['me']);
// exit;
    $threadModel->createThread([
      'title' => $_POST['title'],
      'comment' => $_POST['comment'],
      'user_id' => $_SESSION['me']['id']
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
    // var_dump($_POST['id']);
    $threadModel->deleteThread($_POST['id']);
    
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

?>