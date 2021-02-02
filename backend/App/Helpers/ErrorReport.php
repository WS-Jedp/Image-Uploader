<?php

namespace App\Helpers;

use \App\Http\Response;


class ErrorReport {

  public function report_db_error($msg) {
    $status = 401;
    $json = [
      "message" => $msg,
      "status" => $status,
      "where" => "Database"
    ];
    http_response_code($status);

    return new Response("json", json_encode($json));
  }  

  public function report_internal_error($msg, $error = null) {
    $json = [
      "error" => $msg,
    ];

    if($error) {
      $json["where"] = $error;
    }

    return new Response("json", json_encode($json));
  }
}
