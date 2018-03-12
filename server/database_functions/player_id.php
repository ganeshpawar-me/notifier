<?php

  function set_player_id($player_id)
  {
      $root_dir = $_SERVER['DOCUMENT_ROOT'];
      include $root_dir.'/server/connect.php';
      session_start();
      $notifier_id = $_SESSION['notifier_id'];

      $query = "insert into player_id values ('','$notifier_id','$player_id')";
      $result = mysqli_query($dbc, $query);
  }

  function get_player_id($recipients)
  {
      $root_dir = $_SERVER['DOCUMENT_ROOT'];
      include $root_dir.'/server/connect.php';
      $player_id = [];
      $split_recipient = explode(',', $recipients);
      foreach ($split_recipient as $notifier_id) {
          $query = "select player_id from player_id where notifier_id='$notifier_id'";
          $result = mysqli_query($dbc, $query);

          while ($row = mysqli_fetch_array($result)) {
              $playerid = $row['player_id'];
              $player_id[] = (string) $playerid;
            // array_push($player_id,$playerid);
          }
      }

    return $player_id;
  }

//$recipients = 'ganesh,pawar';
  // print_r (get_player_id($recipients));
  //get_player_id($recipients);
