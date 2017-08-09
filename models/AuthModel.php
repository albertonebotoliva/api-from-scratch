<?php
/*
  Model associated to Auth library. Operates with the database.

  Methods:
  - getUserId  - gets user id from auth table depending on token
  - has_access - grants the access to the api for a given token

  Author: Alberto Nebot Oliva
  Email: albertonebotoliva@gmail.com
*/

class AuthModel extends BaseModel{

  private $table = 'auth';

  public function getUserId($securityToken):array{
    $where = sprintf("token = %d",$securityToken);
    return parent::filter($this->table,$where,"user_id");
  }

  public function has_access($securityToken):array{
    $where = strtotime(date('Y-m-d H:i:s')) . sprintf(" <= expires and token = %d",$securityToken);
    return parent::filter($this->table,$where,"*");
  }
}
?>
