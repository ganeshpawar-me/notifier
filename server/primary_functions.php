<?php

 // for duplication check

    function duplication($key, $value, $table_name)
    {
        $root_dir = $_SERVER['DOCUMENT_ROOT'];
        include $root_dir.'/server/connect.php';

        $query = "select $key from $table_name";
        $result = mysqli_query($dbc, $query);

        while ($row = mysqli_fetch_array($result)) {
            if ($value == $row["$key"]) {
                return true;
                break;
            }
        }

        return false;
    }

 // notifier_id_duplication('notifier_id','ganesh','temp');

  function password_validation($notifier_id, $password)
  {
      $root_dir = $_SERVER['DOCUMENT_ROOT'];
      include $root_dir.'/server/connect.php';
      $password = sha1($password);

      $query = "select notifier_id from personal_profile where notifier_id = '$notifier_id' AND password = '$password'";

      return  $result = mysqli_query($dbc, $query);
  }

    function remember_user()
    {
        session_start();
        if (isset($_SESSION['notifier_id'])) {
            return true;
        } elseif (isset($_COOKIE['notifier_id'])) {
            session_start();
            $_SESSION['notifier_id'] = $_COOKIE['notifier_id'];

            return true;
        } else {
            return false;
        }
        // if (!isset($_SESSION['notifier_id'])) {
        //     if (isset($_COOKIE['notifier_id'])) {
        //         session_start();
        //         $_SESSION['notifier_id'] = $_COOKIE['notifier_id'];

        //         return true;
        //     } else {
        //         return false;
        //     }
        // } else {
        //     return true;
        // }
    }

    function isset_cookie()
    {
        if (isset($_COOKIE['orgname']) && isset($_COOKIE['groupname'])) {
            return '<script>location.href="./connection.php"</script>';
        } else {
            if (isset($_COOKIE['auth_link'])) {
                return '<script>location.href="./auth.php"</script>';
            } else {
                if (isset($_COOKIE['org_signup'])) {
                    return '<script>location.href="./org-signup.php"</script>';
                } else {
                    return '<script>location.href="./personal.html"</script>';
                }
            }
        }
    }
