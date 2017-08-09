<?php
/*
  Model table Resources
  - Return configuration information

  Methods:
  - getQueryField - Get the field query_field from a resource
  - getAllByField - Get a chose field from all the resources
  - getFieldInResource - Get an specific field in a resource
  - getFieldInAction - Get a specific field filter by action and resource
  - getValidActions - Get all the valid actions for this resource
  - getValidMethods - Get all the valid methods for this resource (GET,POST,DELETE)

  Author: Alberto Nebot Oliva
  Email: albertonebotoliva@gmail.com
*/

class ResourcesModel extends BaseModel{

  private $table = 'resources';

  function __construct(){
    parent::__construct($this->table);
  }

  public function getQueryField($resource):array{
    $result = $this->getFieldInResource("query_field",$resource);
    return $result;
  }

  public function getAllByField($field):array{
    $resources =  parent::list($field);

    foreach ($resources as $resource) {
      foreach ($resource as $key => $value) {
        $data[] = $value;
      }
    }

    return $data;
  }

  private function getFieldInResource($field,$resource):array{
    $data = array();

    $resources =  parent::filter($this->table, sprintf('resource = "%s"',$resource) ,$field);

    foreach ($resources as $resource) {
      foreach ($resource as $key => $value) {
        $data[] = $value;
      }
    }

    return $data;
  }
  private function getFieldInAction($field,$resource,$action):array{
    $data = array();

    $resources =  parent::filter($this->table, sprintf('action = "%s" and resource = "%s"',$action,$resource) ,$field);

    foreach ($resources as $resource) {
      foreach ($resource as $key => $value) {
        $data[] = $value;
      }
    }

    return $data;
  }

  public function getValidActions($resource){
    return $this->getFieldInResource('DISTINCT(action)',$resource);
  }
  public function getValidMethods($resource,$action){
    return $this->getFieldInAction('method',$resource,$action);
  }

}
?>
