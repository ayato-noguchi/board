<?php
namespace Board\Controller;

use Exception;

require_once(__DIR__ . '/../Model/Thread.php');
require_once(__DIR__ . '/../Controller/Controller.php');
require_once(__DIR__ . '/../Controller/Image_upload.php');
require_once(__DIR__ . '/../Controller/ThreadService.php');

class Thread  extends \Board\Controller
{
  private $thread_service;

  public function __construct()
  {
    parent::__construct();
    $this->thread_service = new ThreadService();
  }

  public function run()
  {
    var_dump($_SERVER['REQUEST_METHOD']);
    var_dump($_GET);
    if (! $this->isLoggedIn()) {
      header('Location: signup.php');
      exit();
    }
    try {
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $this->validateToken();
        $this->request_post();
      } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $this->request_get();
      }
    } catch (Exception $e) {
      echo "エラーです". $e->getMessage();
      exit;
    }
  }
  private function request_post() {
    switch ($_POST['type']) {
      case 'createthread':
        $this->thread_service->create_thread();
        break;
      case 'update_thread':
        $this->thread_service->update_thread();
        break;
      case 'delete_thread':
        $this->thread_service->delete_thread();
        break;
      case 'search_thread':
        $this->thread_service->search_thread();
        break;
      default:
        throw new \Exception('無効なリクエストです。');
    }
  }
  private function request_get()
  {
    if (isset($_GET['action']) && $_GET['action'] === 'thread_all') {
      $this->thread_service->thread_all();
    } else {
      throw new \Exception('無効なリクエストです。');
    }
  }
}
