<?php 
namespace Board\Model;

use Exception;

require_once(__DIR__ .'/../Model/Model.php');


class Thread extends \Board\Model
{
  public function createThread($values)
  {

    try {
      $this->db->beginTransaction();
      $sql = "INSERT INTO threads (title,comment,user_id,created_at,modified_at)VALUES (:title,:comment,:user_id,now(),now())";
      $stmt = $this->db->prepare($sql);
      //名前付けされたプレースホルダを用いてプリペアドステートメントを実行
      $stmt->bindValue(':title', $values['title']);
      $stmt->bindValue(':comment', $values['comment']);
      $stmt->bindValue(':user_id', $values['user_id']);
      $stmt->execute();
      $this->db->commit();
    } catch(Exception $e){
      echo $e->getMessage();
      $this->db->rollBack();
    }
  }

  public function getThreadAll()
  {
    try{
      $sql = $this->db->query('SELECT * FROM threads');
      return $sql->fetchAll(\PDO::FETCH_OBJ);
    } catch(Exception $e){
      echo $e->getMessage();
    }
  }

  public function getThreadId($id)
  {
    try{
      $sql = 'SELECT * FROM threads WHERE id = :id';
      $stmt = $this->db->prepare($sql);
      $stmt->bindValue(':id', (int)$id);
      $stmt->execute();
      return $stmt->fetchObject();
    } catch(Exception $e){
      echo $e->getMessage();
    }
  }

  public function updateThread($values)
  {
    try {
      $this->db->beginTransaction();
      $sql = "UPDATE threads SET title = :title, comment = :comment, modified_at = now() WHERE id = :id AND user_id = :user_id";
      $stmt = $this->db->prepare($sql);
      
      $stmt->bindValue(':title', $values['title']);
      $stmt->bindValue(':comment', $values['comment']);
      $stmt->bindValue(':id', $values['id']);
      $stmt->bindValue(':user_id', $values['user_id']);
      $stmt->execute();
      $this->db->commit();
    } catch(Exception $e){
      echo $e->getMessage();
      $this->db->rollBack();
    }
  }

  public function deleteThread($id)
  {
    try {
      $this->db->beginTransaction();
      $sql = "DELETE FROM threads WHERE id = :id";
      $stmt = $this->db->prepare($sql);

      $stmt->bindValue(':id', (int)$id);
      $stmt->execute();
      $this->db->commit();
      echo '投稿を削除しました。';
    } catch(Exception $e){
      echo $e->getMessage();
      $this->db->rollBack();
    }
  }

  public function searchThread($values)
  {
    try {
      $sql = "SELECT * FROM threads WHERE title LIKE :values or comment LIKE :values";
      $stmt = $this->db->prepare($sql);
      $stmt->bindValue(':values', "%" .$values. "%");
      $stmt->execute();
      return $stmt->fetchAll(\PDO::FETCH_OBJ);
    } catch(Exception $e){
      echo $e->getMessage();
      
    }
  }
}