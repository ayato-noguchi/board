<?php 
namespace Board\Controller;

use Exception;

require_once(__DIR__ .'/../Model/User.php');
require_once(__DIR__ . '/../Controller/Controller.php');

class Signup  extends \Board\Controller
{
  public function run()
  {
    if($this->isLoggedIn()){
      header('Location: signup.php' );
      exit();
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      $this->signup();
    }
  }

  protected function signup()
  {
    if($this->validate()){
      $userModel = new \Board\Model\User();
      try{
        $user = $userModel->createUser([
          'email' => $_POST['email'],
          'name' => $_POST['username'],
          'password' => $_POST['password']
        ]);
        // ユーザー作成後にログイン
          session_regenerate_id(true);
          $_SESSION['me'] = $user;
          header('Location: thread_all.php');
          exit();
        
      } catch (Exception $e){
        echo $e->getMessage();
      }
    }
  }



  private function validate()
  {
      if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
        echo "不正なトークンです!";
        return false;
      }

      if (!isset($_POST['email']) || !isset($_POST['username']) || !isset($_POST['password'])) {
        echo "不正なフォームから登録されています!";
        return false;
      }

      if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        echo "メールアドレスが不正です!";
        return false;
      }

      if ($_POST['username'] === '') {
        echo "ユーザー名が入力されていません!";
        return false;
      }

      if (!preg_match('/\A[a-zA-Z0-9]+\z/', $_POST['password'])) {
        echo "パスワードが不正です!";
        return false;
      }

      return true;
    }
}

?>