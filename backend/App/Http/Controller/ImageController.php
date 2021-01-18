<?php

namespace App\Http\Controller;

use \App\Http\Response;
use \App\Database\DB_MYSQL;

class ImageController
{

  
  /**
  ** CREATE METHOD **
  */
  public function Create()
  {
    $db = new DB_MYSQL('localhost:3306', 'Jedp05022001082', 'root', 'image_uploader');
    $target_name = ""; 
    $error = null; 
    $extension_file; 
    $status = "";
    $image_dir = "files/images";
    $allows_extensions = "/^jpg$|^png$|^webp$/";

    
    if(isset($_POST["submit"]))
    {
      $target_name = $image_dir . basename($_FILES["image"]["name"]);
      if(file_exists($target_name))
      {
        $error = true;
        throw new Exception("The file already exists", 1);
      }
      
      $extension_file = strtolower(pathinfo($target_name, PATHINFO_EXTENSION));
      if(!preg_match($allows_extensions, $extension_file))
      {
        throw new Exception("We can't handle the file", 1);
      }

      if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_name))
      {
        $status = 201;
        $message = "The images was move successfully";
      } else {
        $status = 401;
        $message = "There is an error";
      }
    } else {
      throw new Exception("There is no file", 1);
    }

    
    
    $resp = $this->db->insertOneInto('images', "'url'", "'$image_dir'");

    $json = [
      "status" => $status,
      "message" => $message,
    ];

    if($status = 201) {
      $json["id"][$resp];
    }

    return new Response('json', json_encode($json));
  }


  /**
    ** UPDATE METHOD **
  */
  public function Update($id)
  {
    $target_name;
    $error; 
    $extension_file; 
    $status;
    $image_dir = "files/images";
    $allows_extensions = "/^jpg$|^png$|^webp$/";

    
    if(isset($_POST["submit"]))
    {
      $target_name = $image_dir . basename($_FILES["image"]["name"]);
      if(file_exists($target_name))
      {
        $error = true;
        throw new Exception("The file already exists", 1);
      }
      
      $extension_file = strtolower(pathinfo($target_name, PATHINFO_EXTENSION));
      if(!preg_match($allows_extensions, $extension_file))
      {
        throw new Exception("We can't handle the file", 1);
      }

      if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_name))
      {
        $status = 201;
        $message = "The images was updated successfully";
      } else {
        $status = 401;
        $message = "There is an error";
      }
    } else {
      throw new Exception("There is no file", 1);
    }

    
    
    $resp = $this->db->updateOne($id, 'images', ["url" => $image_dir]);

    $json = [
      "status" => $status,
      "message" => $message,
    ];

    if($status = 201) {
      $json["id"][$id];
    }

    return new Response('json', json_encode($json));


  }

  /**
    ** DELETE METHOD **
  */
  public function Delete($id)
  {
    $resp = $this->db->deleteOne('images', $id);
    $json = [
      "status" => 201,
      "message" => "The images was deleted succesfully"
    ];

    return new Response('json', json_encode($json));
  }
}