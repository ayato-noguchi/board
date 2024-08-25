<?php 
namespace Board\Controller;

use Exception;

require_once(__DIR__ .'/../Model/User.php');
require_once(__DIR__ . '/../Controller/Controller.php');

class Login  extends \Board\Controller
{
  public function run()
  {
    //ログインしていたら
    if($this->isLoggedIn()){
      header('Location: signup.php' );
      exit();
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      $this->login();
    }
  }

  protected function login()
  {

    if($this->validate()){
  
      $userModel = new \Board\Model\User();
      
      try{
        $user = $userModel->login([
          'email' => $_POST['email'],
          'password' => $_POST['password']
        ]);

          session_regenerate_id(true);

          // シリアライズ可能なデータだけをセッションに保存
          $_SESSION['me'] = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email
        ];

          header('Location: thread_all.php');
          exit();
        
      } catch (Exception $e){
        echo 'ログインエラー: ' . $e->getMessage();
      }
    }
  }



  private function validate()
  {
    // var_dump($_POST['token']);
    // var_dump($_SESSION['token']);
    // exit();
      if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
        echo "不正なトークンです!";
        return false;
      }
   
      if (!isset($_POST['email'])  || !isset($_POST['password'])) {
        echo "不正なフォームから登録されています!";
        return false;
      }

      if ($_POST['email'] === '' || $_POST['password'] === '') {
        echo "メールアドレスとパスワードを入力してください!";
        return false;
      }

      return true;
    }
}

?>