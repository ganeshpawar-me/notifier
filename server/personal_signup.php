 <?php


    if (!isset($_GET['otp'])) {
        echo 'session is not start';
    } else {
        $otp = $_GET['otp'];

        $root_dir = $_SERVER['DOCUMENT_ROOT'];
        include $root_dir.'/server/connect.php';

        $query = "select * from temp where otp ='$otp'";
        $result = mysqli_query($dbc, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);

            $first_name = $row['first_name'];
            $last_name = $row['last_name'];
            $notifier_id = $row['notifier_id'];
            $password = $row['password'];
            $email = $row['email'];
            $mobile_no = $row['mobile_no'];

            $password = sha1($password);

        //insert into personal_profile table
        $query = "insert into personal_profile values
		            (
				     '' ,
					 '$first_name',
					 '$last_name',
					 '$notifier_id',
					 '$password',
					 '$email',
					 '$mobile_no'
					)";
            $result = mysqli_query($dbc, $query);

            if ($result) {
                echo 'success';
                $query = "delete from temp where otp ='$otp'";
                $result = mysqli_query($dbc, $query);

                session_start();
                $_SESSION['username'] = $notifier_id;

                echo '<h1>Registered Successfully</h1>';

      printf("<script>location.href='../new-push.html'</script>");
            } else {
                echo 'error';
            }
        } else {
            echo 'Link Expired';
        }
    }

    ?>
