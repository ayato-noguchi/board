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
        $this->delteThread();
      }
    }
  }


  protected function createThread()
  {
    // var_dump($_POST);
    $threadModel = new \Board\Model\Thread();

    $threadModel->createThread([
      'user_name' => $_POST['user_name'],
      'title' => $_POST['title'],
      'comment' => $_POST['comment'],
    ]);
    header('Location: thread_all.php');
    exit;
  }

  protected function updateThread()
  {
    $threadModel = new \Board\Model\Thread();

    $threadModel->updateThread([
      'user_name' => $_POST['user_name'],
      'title' => $_POST['title'],
      'comment' => $_POST['comment'],
      'id' => $_POST['id'],
    ]);

    header('Location: thread_all.php');
    exit;
  }

 protected function delteThread()
 {
  $this->validateToken();

  $threadModel = new \Board\Model\Thread();
  var_dump($_POST['id']);
  $threadModel->deleteThread($_POST['id']);
  
  header('Location: thread_all.php');
  exit;
}
}

?>