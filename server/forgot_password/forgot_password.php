 <?php

// getting email for sending recovery link
// $_POST['email']);
// $email = 'ganeshpawar.me@gmail.com';
//$mobile_no = 7387268749;
if (isset($_POST['email'])) {
    $root_dir = $_SERVER['DOCUMENT_ROOT'];
    include $root_dir.'/server/connect.php';
    $email = $_POST['email'];

    $query = "select notifier_id from personal_profile where email= '$email' limit 1";
    $result = mysqli_query($dbc, $query);

    $row = mysqli_fetch_array($result);

    $notifier_id = $row['notifier_id'];

    if ($num = mysqli_num_rows($result) > 0) {
        $str = '12345';
        $otp = str_shuffle($str);

        $query1 = "insert into forgot_password values ('','$notifier_id','$otp')";
        $result1 = mysqli_query($dbc, $query1);

    //send email with otp_link

    $otp_link = "notifier.esy.es/server/forgot_password/forgot_password_otp_validation.php?otp=$otp";
        $subject = 'Click on the link below to change your password';
        $message = $otp_link;
        $headers = 'From: no-reply@notifier.website'."\r\n".'Reply-To: no-reply@notifier.website'."\r\n".'X-Mailer: PHP/'.phpversion();

        if (mail($email, $subject, $message, $headers)) {
            //echo "Password has been sent to your email id";
      $registered = true;
            echo '1';
        } else {
            echo '0';
        }
    } else {
        echo '0';
    }
} else {
    echo 'direct access is denied';
}

     ?>
