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
    $json = [
      "data" => $this->db->selectOne('images', '*', $id),
      "status" => 200
    ];
    http_response_code(200);

    return new Response('json', json_encode($json));
  }
}