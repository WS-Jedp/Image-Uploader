<?php

namespace App\Http\Controller;

use \App\Database\DB_MYSQL;
use \App\Http\Response;

class ApiController
{

  protected $db;

  public function __construct()
  {
    $this->db = new DB_MYSQL();
  }

  public function Index()
  {
    $json = [
      "data" => $this->db->selectMultiple('images', '*'),
      "status" => 200
    ];
    http_response_code(200);
    return new Response('json', json_encode($json));
    
  }

  public function Find($id){
    
    header("Access-Control-Allow-Origin: http://localhost:8000");    
    header('Access-Control-Allow-Credentials: false');
    header("Access-Control-Allow-Methods: GET"); 
    $resource = $this->db->selectOne('images', '*', $id);
    $json = [
      "data" => $resource[0],
      "status" => 200
    ];
    http_response_code(200);

    return new Response('json', json_encode($json));
  }
}