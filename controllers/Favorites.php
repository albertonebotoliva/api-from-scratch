<?php
/*
  Favorites Controller
  Accepts:
    /favorites/[:user_id]  - GET     - List user favorites
    /favorites/       - POST    - Add a song to favorites
      - You must send in the body {"song_id": "[:song_id]"}
    /favorites/       - DELETE  - Delete a song from favorites
      - You must send in the body {"song_id": "[:song_id]"}

  Author: Alberto Nebot Oliva
  Email: albertonebotoliva@gmail.com
*/
class Favorites extends BaseController{

  private $table = "favorites";
  protected $request;
  protected $model;

  function __construct($Request){
    parent::__construct($Request);
    $this->request = $Request;
    $this->model = new BaseModel($Request->getController());
  }


  public function deleteFavorite(){
    $body = $this->request->getBody();
    $Auth = new Auth($this->request->getSecurityToken());
    $userId = $Auth->getUserId();
    $body = json_decode($body);
    $songId = $body->song_id;

    $where = "song_id='".$songId."' and user_id='".$userId['user_id']."'";
    $response = $this->model->delete('favorites',$where);

    if($response){
      return array("code"=>"202","status"=>"ACCEPTED","message"=>"Resource was marked for deletion","data"=>null);
    }else{
      return array("code"=>"500","status"=>"INTERNAL SERVER ERROR","message"=>"INTERNAL SERVER ERROR","data"=>null);
    }

  }

  public function addFavorite(){
    $body = $this->request->getBody();

    $Auth = new Auth($this->request->getSecurityToken());
    $userId = $Auth->getUserId();

    $body = json_decode($body);
    if(isset($body->song_id)){
      $songId = $body->song_id;
      $songs = new BaseModel('Songs');
      $song = $songs->getById($songId,'id');
    }
    //favorites model
    $is_favorite = $this->model->getByid($songId,'song_id');

    if(count($is_favorite) > 0){
      return array("code"=>"409","status"=>"OK","message"=>"The request could not be completed due to a conflict with the current state of the resource.","data"=>null);
    }else{

      $data['id'] = '';
      $data['user_id'] = $userId['user_id'];
      $data['song_id'] = $song[0]['id'];
      $data['song_name'] = $song[0]['name'];
      $data['song_duration'] = $song[0]['duration'];
      $response = $this->model->insert('favorites',$data);
      if($response){
        return array("code"=>"201","status"=>"CREATED","message"=>"CREATED","data"=>$data['song_id']);
      }else{
        return array("code"=>"500","status"=>"INTERNAL SERVER ERROR","message"=>"INTERNAL SERVER ERROR","data"=>null);
      }
    }
  }

}
?>
