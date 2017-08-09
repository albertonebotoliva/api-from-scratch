<?php
/*
  Base Model to access the DB

  Methods:
  - filter
  - list
  - getById
  - insert
  - delete
  
  Author: Alberto Nebot Oliva
  Email: albertonebotoliva@gmail.com
*/

class BaseModel{

  private $table;

  function __construct($table){
    $this->table = $table;
  }

  public function filter($tb, $where, $select_fields)
  {
    $db = new Database();
    $result = $db->filter($tb, $where, $select_fields);
    return $result;
  }
  public function list($fields = "*"):array{
    return $this->filter($this->table,'1',$fields);
  }
  public function getById($id,$field):array{
    return $this->filter($this->table,sprintf("$field = '%d'",$id),'*');
  }

  public function insert($tb, $data){
    $db = new Database();
    $result = $db->insert($tb, $data);
    return $result;
  }

  public function delete($tb,$where){
    $db = new Database();
    $result = $db->delete($tb, $where);
    return $result;
  }

}
?>
