<?php
namespace Board\Controller;


class Image_uploade
{
    public static function upload($file)
  {
    
      $temp_file = $file['tmp_name']; 
      $image = null; 
      $dir = __DIR__ . '/../public/uploads/';

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
          throw new \Exception('対応していない画像形式です');
      }
          // アップロードされたファイルを保存
          if (!move_uploaded_file($temp_file, $dir . $image)) {
            throw new \Exception("ファイルのアップロードに失敗しました。");
             return;
        }
    }
    return $image;
  }
}
