<?php
   class personal_home
   {
       public function login($notifier_id, $password)
       {
           include 'primary_functions.php';
           $result = password_validation($notifier_id, $password);

           if (mysqli_num_rows($result) > 0) {
               session_start();
               $_SESSION['notifier_id'] = $notifier_id;
               setcookie('notifier_id', $notifier_id, null, '/');
               echo $redirect = isset_cookie();
           } else {
               echo 'Wrong username or password';
           }
       }

       public function load_inbox()
       {
           include 'database_functions/recipients.php';
           session_start();
           $notifier_id = $_SESSION['notifier_id'];
           echo $result = load_inbox($notifier_id);
       }

       public function load_auth_access()
       {
           include 'database_functions/auth_access.php';
           session_start();
           $notifier_id = $_SESSION['notifier_id'];
           echo $result = personal_load_auth_access($notifier_id);
       }

       public function load_connections()
       {
           include 'database_functions/org_connections.php';
           session_start();
           $notifier_id = $_SESSION['notifier_id'];
           echo $result = load_connections($notifier_id);
       }

       public function load_admin_access()
       {
           include 'database_functions/org_profile.php';
           session_start();
           $notifier_id = $_SESSION['notifier_id'];
           echo $result = load_admin_access($notifier_id);
       }

       public function change_password($old_password, $new_password)
       {
           include 'database_functions/personal_profile.php';
           include 'primary_functions.php';

           session_start();
           $notifier_id = $_SESSION['notifier_id'];
           $result = password_validation($notifier_id, $old_password);

           if (mysqli_num_rows($result) > 0) {
               $result = change_password($notifier_id, $new_password);
               if ($result) {
                   echo '1';
               } else {
                   echo 'db error';
               }
           } else {
               echo '0';
           }
       }

       public function logout()
       {
           session_start();
           unset($_SESSION['username']);
           session_destroy();
           $expire = time() - 300;
           setcookie('notifier_id', '', $expire, '/');
           setcookie('orgname', '', $expire, '/');
           setcookie('groupname', '', $expire, '/');
           setcookie('auth_link', '', $expire, '/');
           setcookie('org_signup', '', $expire, '/');
           echo '1';
       }

       public function remember_user()
       {
           include 'primary_functions.php';
           if (remember_user()) {
               //  echo '<script>location.href="../personal_home.html";</script>';
              echo '1';
           } else {
               //  echo '<script>location.href="../index.html";</script>';
              echo '0';
           }
       }
   }

  //   //for login
  //   //$notifier_id = 'akshay';
  //   //$password   = '$password';
    if (isset($_POST['notifier_id']) && isset($_POST['password'])) {
        $notifier_id = trim($_POST['notifier_id']);
        $password = trim($_POST['password']);
        $personal_home = new personal_home();
        $personal_home->login($notifier_id, $password);
    }

  //   // for loading inbox
    //$inbox = $_POST['inbox'];
    //$inbox = 'inbox';
    if (isset($_POST['inbox'])) {
        $personal_home = new personal_home();
        $personal_home->load_inbox();
    }

    //for loading auth access
    //$auth_access = $_POST['auth_access'];
    //$auth_access = 'auth_access';
    if (isset($_POST['auth_access'])) {
        $personal_home = new personal_home();
        $personal_home->load_auth_access();
    }

    // for loading connections
    //$connections = $_POST['connections'];
    //$connections  = 'connections';
    if (isset($_POST['connections'])) {
        $personal_home = new personal_home();
        $personal_home->load_connections();
    }

    //for loading admin access
    //$admin_access = $_POST['admin_access'];
    //$admin_access = 'admin_access';
    if (isset($_POST['admin_access'])) {
        $personal_home = new personal_home();
        $personal_home->load_admin_access();
        // echo json_encode(array());
        // sleep(4);
    }

    //for changing password
    //$new_password = 'qwer';
    if (isset($_POST['new_password'])) {
        $personal_home = new personal_home();
        $new_password = trim($_POST['new_password']);
        $old_password = trim($_POST['old_password']);
        $personal_home->change_password($old_password, $new_password);
    }

    // for logging out
    //$logout= $_POST['logout'];
    // $logout = 'logout';
    if (isset($_POST['logout'])) {
        $personal_home = new personal_home();
        $personal_home->logout();
    }

    if (isset($_POST['remember_user'])) {
        $personal_home = new personal_home();
        $personal_home->remember_user();
    }
