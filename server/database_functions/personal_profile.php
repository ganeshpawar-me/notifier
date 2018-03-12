<?php

  function change_password($notifier_id, $password)
  {
      $root_dir = $_SERVER['DOCUMENT_ROOT'];
      include $root_dir.'/server/connect.php';
      $password = sha1($password);
      $query = "update personal_profile set password = '$password' where notifier_id = '$notifier_id'";

      return $query = mysqli_query($dbc, $query);
  }
