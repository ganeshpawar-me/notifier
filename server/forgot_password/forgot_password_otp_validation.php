 <?php

 if (!isset($_GET['otp'])) {
     echo 'could not get otp';
 } else {
     $otp = $_GET['otp'];
     $root_dir = $_SERVER['DOCUMENT_ROOT'];
     include $root_dir.'/server/connect.php';

   //$otp_link=25431;

   $query = "select * from forgot_password where otp = '$otp'";
     $result = mysqli_query($dbc, $query);

     $row = mysqli_fetch_array($result);
     $notifier_id = $row['notifier_id'];

     if ($notifier_id == '') {
         echo 'query failed';
     } else {
         session_start();
         $_SESSION['username'] = $notifier_id;
         echo 'session start';
         printf("<script>location.href='./pass-reset.html'</script>");
     }
 }

     ?>
