<?php 
namespace Board\Model;

use Exception;

require_once(__DIR__ .'/../Model/Model.php');


class User extends \Board\Model
{
  public function createUser($values)
  {
    try {

      $this->db->beginTransaction();

      // パスワードのハッシュ化
      $hashedPassword = password_hash($values['password'], PASSWORD_DEFAULT);
   
       // メールアドレスが既に存在するかチェック
       if ($this->emailExists($values['email'])) {
        throw new Exception('このメールアドレスはすでに登録されています。');
       }

      $sql = "INSERT INTO users (name,email,password)VALUES (:name,:email,:password)";
      $stmt = $this->db->prepare($sql);
      //名前付けされたプレースホルダを用いてプリペアドステートメントを実行
      $stmt->bindValue(':name', $values['name']);
      $stmt->bindValue(':email', $values['email']);
      $stmt->bindValue(':password', $hashedPassword);
      $stmt->execute();

      $this->db->commit();
    } catch(Exception $e){
      echo $e->getMessage();
      $this->db->rollBack();
    }

  }

  //メールアドレスが存在するか確認メソッド
  private function emailExists($email)
  {
      $sql = "SELECT COUNT(*) FROM users WHERE email = :email";
      $stmt = $this->db->prepare($sql);
      $stmt->bindValue(':email', $email);
      $stmt->execute();

      return $stmt->fetchColumn() > 0;
  }
}

?>