<?php
/*
  Songs Controller (generic)

  NOTE: You don't need this controller to the API work

  Author: Alberto Nebot Oliva
  Email: albertonebotoliva@gmail.com
*/
class Songs extends BaseController{

  private $table = "songs";

  function __construct($Request){
    parent::__construct($Request);
  }

}
?>
