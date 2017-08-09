<?php
/*
  Users Controller (generic)

  NOTE: You don't need this controller to the API work

  Author: Alberto Nebot Oliva
  Email: albertonebotoliva@gmail.com
*/
class Users extends BaseController{

  private $table = "users";

  function __construct($Request){
    parent::__construct($Request);
  }

}
?>
