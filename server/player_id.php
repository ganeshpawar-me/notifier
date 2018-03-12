<?php

   class player_id {
      
     function insert_player_id($player_id){
       include 'database_functions/player_id.php';
       $result = set_player_id($player_id);
     }
  }


    if(isset($_POST['player_id'])) {

      $player_id = trim($_POST['player_id']);
      $new = new player_id();
      $new ->insert_player_id($player_id);
    }

  ?>
