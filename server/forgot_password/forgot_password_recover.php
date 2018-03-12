 <?php

 session_start();
 if (!isset($_SESSION['username'])) {
     echo 'session is not start';
 } else {
     $root_dir = $_SERVER['DOCUMENT_ROOT'];
     include $root_dir.'/server/connect.php';
     $password = $_POST['newpassword'];
      // $password = 'ganeshpawar';
      $notifier_id = $_SESSION['username'];
     $password = sha1($password);

     $query = "update personal_profile set password = '$password' where notifier_id = '$notifier_id'";
     $result = mysqli_query($dbc, $query);

     $query = "delete from forgot_password where notifier_id = '$notifier_id'";
     $query = mysqli_query($dbc, $query);

     unset($_SESSION['username']);
     session_destroy();
     echo '1';
 }

     ?>
