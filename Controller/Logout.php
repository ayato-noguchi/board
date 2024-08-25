<?php 
namespace Board\Controller;

require_once(__DIR__ . '/../Controller/Controller.php');

class Logout  extends \Board\Controller{
  public function run()
  {
 
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
        echo "不正なトークンです!";
        exit();
      }

      //SESSION空にする。ユーザー情報が保持されるのを防ぐ
      $_SESSION = [];

      //セッションクッキー削除
      if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 86400, '/');
      }
      // セッションの破棄
      session_destroy();
    }
    // トップページへリダイレクト
    header('Location: signup.php' );
  }
}