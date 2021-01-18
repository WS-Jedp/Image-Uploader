<?php

namespace App\Http;

class Response {
  private $type;
  private $data;

  public function __construct($type, $data)
  {
    $this->type = $type;
    $this->data = $data;
  }

  private function getView()
  {
    $view = $this->data;
    $content = file_get_contents(__DIR__ . "../../views/$view.php");

    require __DIR__ . "/../../views/$view.php";
  }

  private function getJson()
  {
    $json = $this->data;
    header('Content-type:application/json;charset=utf-8');
    return $json;
  }

  private function setResponse($type)
  {
    switch ($type) {
      case 'view':
        return $this->getView();

      case 'json':
        echo $this->getJson();
        
      default:
        $this->getView();
        break;
    }
  }

  public function send()
  {
    $this->setResponse($this->type);
  }
}