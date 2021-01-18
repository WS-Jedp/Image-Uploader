<?php

namespace App\Http;

class Request {

  protected $segments = [];
  protected $controller;
  protected $method;
  protected $params;

  public function __construct()
  {
    $this->segments = explode('/', $_SERVER["REQUEST_URI"]);

    $this->setController();
    $this->setMethod();
    $this->setParams();

    $this->send();
  }

  /*
    ** Set main information to redirect to the correct Controller thanks to the URI
  */ 
  private function setController()
  {
    $this->controller = empty($this->segments[1]) ? 'home' : $this->segments[1];
  }

  private function setMethod()
  {
    $this->method = empty($this->segments[2]) ? 'index' : $this->segments[2];
  }

  private function setParams()
  {
    $this->params = empty($this->segments[3]) ? NULL : $this->segments[3];
  }

  /**
    * Setting the correct names to the Controller and Method for be called in the correct way
  */
  public function getController()
  {
    $controller = ucfirst($this->controller);

    return "App\Http\Controller\\{$controller}Controller";
  }

  public function getMethod(){
    if(empty($this->params))
    {
      return ucfirst($this->method);
    }

    return ucfirst("$this->method($this->params)");
  }


  /**
    * Function to response the data that we need to return
  */
  private function send()
  {
    $controller = $this->getController();
    $method = $this->getMethod();

    $response = call_user_func([
      new $controller,
      $method
    ]);

    $response->send();

  }
}
