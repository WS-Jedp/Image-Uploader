<?php

namespace App\Http\Controller;
use \App\Http\Response;
use App\Database\DB_MYSQL;

class HomeController {
  public function Index()
  {

    $json = ['name' => 'juan'];
    return new Response('json', json_encode($json));
  }
}