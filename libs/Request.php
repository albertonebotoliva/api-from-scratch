<?php
/*
  Handles the Request

  Methods:
    - setAction         - Sets the method to call in the controller
    - cleanInput        - Filters the input to prevent basic security issues
    - getController     - Gets the controller from the resource (url)
    - getBody           - Gets the body of the request
    - getAction         - Gets the method to call
    - getParameters     - Gets the extra parameters (not in use)
    - getMethod         - Get the call method (GET,POST,DELETE)
    - getElementId      - Get the id from url
    - getSecurityToken  - Get the token from the header Authorization
    - getFormat         - Get the accepted format (application/json)

  Author: Alberto Nebot Oliva
  Email: albertonebotoliva@gmail.com
*/
class Request{

  // uri related
  private $controller;
  private $action;
  private $params;
  private $id;
  // http related
  private $headers;
  private $method;
  private $body;

  public function __construct(){
    $baseUri = '/deezer/';
    $requestUri = $_SERVER['REQUEST_URI'];

    $dataUri = explode("/",str_replace($baseUri,"",$requestUri));

    $this->controller = array_shift($dataUri);
    $this->id = array_shift($dataUri);

    if(is_numeric($this->id)){
      $this->params = $dataUri;
    }else{
      $this->params = $this->id;
      $this->id = null;
    }
    $this->headers = getallheaders();
    $this->method = $_SERVER['REQUEST_METHOD'];
    $this->body   = file_get_contents('php://input');

    $this->setAction();
  }

  private function setAction(){
    switch($this->method){
      case 'GET':
        $this->action = "list";
        if(is_numeric($this->id)){
          $this->action = "getById";
        }
      break;
      case 'POST':
        $this->action = "addFavorite";
      break;
      case 'DELETE':
        $this->action = "deleteFavorite";
      break;
    }
  }

  private function cleanInput($input){
    return strip_tags(trim(strtolower($input)));
  }

  public function getController(){
    return $this->cleanInput($this->controller);
  }
  public function getBody(){
    return $this->cleanInput($this->body);
  }
  public function getAction(){
    return $this->cleanInput($this->action);
  }
  public function getParameters(){
    return $this->params;
  }
  public function getMethod():string{
    return strtoupper($this->cleanInput($this->method));
  }
  public function getElementId(){
    return (isset($this->id) && !empty($this->id))? $this->cleanInput($this->id) : null;
  }
  public function getSecurityToken():int{
    return isset($this->headers['Authorization'])? $this->headers['Authorization'] : 0;
  }
  public function getFormat():string{

    $content_type = isset($this->headers['Accept']) ? $this->headers['Accept'] : null;

    if($content_type){
      $data = explode(';',$content_type);
      return $data[0]; //application/json, application/xml
    }
    return "false";
  }

}
