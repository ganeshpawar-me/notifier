 <?php

    function start_session()
    {
        session_start();
        echo $_SESSION['notifier_id'] = 'aditya';

        if (isset($_SESSION['notifier_id'])) {
            echo 'session start';
        }
    }

    function stop_session()
    {
        session_start();
        unset($_SESSION['notifier_id']);
        session_destroy();
        if (!isset($_SESSION['notifier_id'])) {
            echo 'session stop';
        }
    }

    function set_cookie()
    {
        $org_notifier_id = 'akshaysorganization';
    //$notifier_id ='akshay';

        setcookie('org_notifier_id', $org_notifier_id);
    //setcookie('notifier_id',$notifier_id);

            if (isset($_COOKIE['org_notifier_id'])) {
                echo ' org cookie set';
            }

        if (isset($_COOKIE['notifier_id'])) {
            echo 'personal cookie set';
        }
    }

    function unset_cookie()
    {
        $expire = time() - 300;
        setcookie('org_notifier_id', '', $expire);
        setcookie('notifier_id', '', $expire);
        if (!isset($_COOKIE['org_notifier_id'])) {
            echo 'cookie unset';
        }
    }

     /*$date        = date_create();
     echo $time_stamp  = date_timestamp_get($date);*/

    //  start_session();
    stop_session();
    // set_cookie();
  //  unset_cookie();
  //  echo '<script>location.href="links/org_auth_access_link.php";</script>';

//   $date = date_create();
//   $date = date_format($date, 'Y/m/d');

// date_default_timezone_set('Asia/kolkata');
//  $time = date('h:i:sa');

 ?>
