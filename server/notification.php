<?php

  include 'connect.php';
  include 'onesignal.php';
  $recipients = 'aditya';
  $subject = 'hello';

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
   print_r($player_id);
  
  sendMessage($subject,$playerid);
?>