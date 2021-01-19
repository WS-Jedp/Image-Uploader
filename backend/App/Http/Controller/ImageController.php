<?php

namespace App\Http\Controller;

use \App\Http\Response;
use \App\Database\DB_MYSQL;

class ImageController
{

  protected $db;

  public function __construct()
  {
    $this->db = new DB_MYSQL();
  }
  
  /**
  ** CREATE METHOD **
  */
  public function Create()
  {
    header("Access-Control-Allow-Origin: http://localhost:8000");    
    // header("Access-Control-Allow-Origin: http://localhost:8000");    
    header('Access-Control-Allow-Credentials: false');
    header("Access-Control-Allow-Methods: GET, POST");    
    header("Access-Control-Allow-Headers: *");

    global $error; 
    $target_name = ""; 
    $filename = "";
    $extension_file = ""; 
    $status = "";
    $image_dir = __DIR__ . "/../../../public/uploads/";
    $allows_extensions = "/^jpg$|^png$|^webp$/";

    if(isset($_FILES["image"]))
    {
      $target_name = $image_dir . $_FILES["image"]["name"];
      $filename = $_FILES["image"]["name"];
      if(file_exists($target_name) === true)
      {
        $error = true;        
        $json = [
          "status" => 401,
          "message" => "The file already exists",
          "files" => $_FILES
        ];
        return new Response('json', json_encode($json));
      }
      
      $extension_file = strtolower(pathinfo($target_name, PATHINFO_EXTENSION));
      if(!preg_match($allows_extensions, $extension_file))
      {
        throw new \Exception("We can't handle the file", 1);
      }

      if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_name))
      {
        $status = 201;
        $message = "The images was move successfully";
        http_response_code($status);
      } else {
        $status = 401;
        $message = "There is an error, we can't move the file";
        http_response_code($status);
      }
    } else {
      $json = [
        "status" => 401,
        "message" => "There is no file",
      ];
      return new Response('json', json_encode($json));
    }

    
  
    $resp = $this->db->insertOneInto("images", "url", "http://localhost:3000/uploads/$filename");

    $message = "The image was move successfully";
    $json = [
      "status" => $status,
      "message" => $message,
      "data" => [
        "id" => $resp
      ]
    ];

    http_response_code($status);

    return new Response('json', json_encode($json));
  }


  /**
    ** UPDATE METHOD **
  */
  public function Update($id)
  {

    $target_name = "";
    $error = NULL; 
    $extension_file = ""; 
    $status = 200;
    $image_dir = __DIR__ . "/../../uploads/";
    $allows_extensions = "/^jpg$|^png$|^webp$/";

    
    if(isset($_FILES))
    {
      $target_name = $image_dir . basename($_FILES["image"]["name"]);
      if(file_exists($target_name))
      {
        $error = true;
        throw new \Exception("The file already exists", 1);
      }
      
      $extension_file = strtolower(pathinfo($target_name, PATHINFO_EXTENSION));
      if(!preg_match($allows_extensions, $extension_file))
      {
        throw new \Exception("We can't handle the file", 1);
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
      throw new \Exception("There is no file", 1);
    }

    
    
    $resp = $this->db->updateOne('images', $id, ["url" => $_FILES["image"]["name"]]);

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
      "message" => "The images was deleted succesfully",
      "response" => $resp
    ];

    return new Response('json', json_encode($json));
  }
}