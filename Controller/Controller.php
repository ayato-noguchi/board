<?php 
namespace Board;
require_once(__DIR__ .'/../Config/config.php');


class Controller 
{
  public function __construct()
  {
    if(!isset($_SESSION['token']))
    {
      $_SESSION['token'] = bin2hex(random_bytes(16));
    }
  }

  protected function  validateToken()
  {
    if(!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']){
      throw new \Exception('無効なトークンです。');
    }
  }
}

?>
