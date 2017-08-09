<?php
/*
  Base Controller

  Methods:
    - getById - Generic method to get records by id

  Author: Alberto Nebot Oliva
  Email: albertonebotoliva@gmail.com
*/
class BaseController{

    protected $model;
    protected $request;

    public function __construct($Request){
      $this->request = $Request;
      $this->model = new BaseModel($Request->getController());
    }

    // Check if the method exists
    public function __call($action, $attributes){
      $output =  array("code"=>"404","status"=>"NOT FOUND","message"=> "The method you are trying to access is invalid","data"=>"");
    }

    public function getById($id,$field):array{
      $response = $this->model->getById($id,$field);
      return array("code"=>"200","status"=>"OK","message"=>"getbyid","data"=>$response);
    }
    

}

?>
