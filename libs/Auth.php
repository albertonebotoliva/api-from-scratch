<?php
/*
  Basic Token access control
  - Not any specific protocol

  Methods:
    - getUserId  - gets user id from auth table depending on token
    - has_access - grants the access to the api for a given token 

  Author: Alberto Nebot Oliva
  Email: albertonebotoliva@gmail.com
*/
class Auth{

  private $securityToken = null;

  function __construct($token = null) {
    $this->securityToken = $token;
  }

  public function getUserId():array{
    $Auth = new AuthModel($this->securityToken);
    $response = $Auth->getUserId($this->securityToken);
    if(count($response)>0){
      return $response[0];
    }
    return array();
  }

  public function has_access():bool{
    $Auth = new AuthModel($this->securityToken);
    $response = $Auth->has_access($this->securityToken);

    if(count($response)>0){
      return true;
    }
    return false;

  }

}
