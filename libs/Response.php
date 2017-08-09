<?php
/*
  Handles the Response

  Methods:
    - setHeaders - Set the headers
    - render     - Renders the response

  Author: Alberto Nebot Oliva
  Email: albertonebotoliva@gmail.com
*/


class Response{

  private $header = array();
  private $data = null;

  public function __construct($data){
    $this->data['data'] = $data['data'];
    $this->header['code'] = $data['code'];
    $this->header['status'] = $data['status'];
    $this->header['message'] = $data['message'];
    $this->header['content-type'] = "application/json";
    $this->header['charset'] = "utf-8";
  }

  private function setHeaders():bool{
    header("Code: ".$this->header['code']);
    header("Status: ".$this->header['status']);
    header("Message: ".$this->header['message']);
    header("Content-Type: ".$this->header['content-type']);
    header("charset: ".$this->header['charset']);

    return true;
  }

  public function render(){

    $this->setHeaders();

    if($this->header['code'] < 300){
      echo json_encode($this->data);
    }
  }

}
