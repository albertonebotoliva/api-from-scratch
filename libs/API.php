<?php
/*
  API control file

  Functions:
    - parseRequest
    - authentize
    - authorize
    - initController
    - initAction
    - sendResponse
    - run

  Author: Alberto Nebot Oliva
  Email: albertonebotoliva@gmail.com
*/

class API{

  public $Request;
  public $Response;
  public $Auth;
  public $Resources;

  public $object;

  public $output;

  public $controller;
  public $action;
  public $method;
  public $format;
  public $queryField;
  public $elementId;

  public $validResources;
  public $validActions;
  public $validMethods;


  function __construct(){
    $this->Request = new Request();
    $this->Auth = new Auth($this->Request->getSecurityToken());
    $this->Resources = new ResourcesModel();
  }
  public function parseRequest(){
    $this->controller = $this->Request->getController();
    $this->action     = $this->Request->getAction(); //Method to be called in the controller
    $this->method     = $this->Request->getMethod(); //GET/POST/DELETE
    $this->format     = $this->Request->getFormat(); //application/json

    if($this->action == 'getbyid'){
      $this->queryField = $this->Resources->getQueryField($this->controller);
      $this->elementId  = $this->Request->getElementId(); //Method to get the id
    }
    $this->parameters = $this->Request->getParameters();
  }

  public function authentize(){
    if($this->Auth->has_access()){
      return true;
    }

    $this->output = array("code"=>"401","status"=>"UNAUTHORIZED","message"=> "You don't have access to this API","data"=>"");
    return false;
  }

  public function authorize(){

    $this->validResources = $this->Resources->getAllByField('resource');
    $this->validActions = $this->Resources->getValidActions($this->controller);
    $this->validMethods = $this->Resources->getValidMethods($this->controller,$this->action);

    if(
      (!empty($this->controller) && !empty($this->action)) &&
      (in_array($this->controller,$this->validResources)) &&
      (in_array($this->action,$this->validActions)) &&
      (in_array($this->method,$this->validMethods))
    )
    {
      return true;
    }
    $this->output = array("code"=>"401","status"=>"UNAUTHORIZED","message"=> "You don't have access to this API","data"=>"");
    return false;
  }

  public function initController(){
    if( file_exists( "controllers/$this->controller.php" ) ){
      $this->object = new $this->controller($this->Request);
    }else{
      $this->object = new BaseController($this->Request);
    }
  }

  public function initAction(){
    $action = $this->action;
    if($this->action == 'getbyid'){
      $this->output = $this->object->$action($this->elementId,$this->queryField[0]);
    }else{
      $this->output = $this->object->$action();
    }
  }

  public function sendResponse(){
    $this->Response = new Response($this->output);
    $this->Response->render();
  }

  public function run(){
    $this->parseRequest();

    if($this->authentize() && $this->authorize()){
      $this->initController();
      $this->initAction();
    }else{
      $this->output = array("code"=>"404","status"=>"NOT FOUND","message"=> "The requested resource is invalid","data"=>"");
    }

    $this->sendResponse();
  }
}
?>
