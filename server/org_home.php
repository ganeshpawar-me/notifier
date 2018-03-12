 <?php

   class org_home
   {
       public function load_sentbox()
       {
           include 'database_functions/sender.php';

           $notifier_id = $_COOKIE['org_notifier_id'];
           echo  $result = load_sentbox($notifier_id);
       }

       public function load_groups()
       {
           include 'database_functions/org_groups.php';
           $notifier_id = $_COOKIE['org_notifier_id'];
           echo $result = load_groups($notifier_id);
       }

       public function load_auth_access()
       {
           include 'database_functions/auth_access.php';
           $notifier_id = $_COOKIE['org_notifier_id'];
           echo $result = org_load_auth_access($notifier_id);
       }

       public function update_auth_link()
       {
           $root_dir = $_SERVER['DOCUMENT_ROOT'];
           include $root_dir.'/server/connect.php';
           include 'database_functions/org_profile.php';

           echo update_auth_link();
       }

       public function get_org()
       {
           if (isset($_COOKIE['org_notifier_id'])) {
               echo  $_COOKIE['org_notifier_id'];
           } else {
               echo '0';
           }
       }

       public function get_auth_link()
       {
           include 'database_functions/org_profile.php';

           $notifier_id = $_COOKIE['org_notifier_id'];
           echo $auth_link = get_auth_link($notifier_id);
       }

       public function logout()
       {
           $expire = time() - 300;
           setcookie('org_notifier_id', '', $expire, '/');
           echo '1';
       }
   }

   // for loading sentbox
   //$sentbox = ;
   //$sentbox = 'sentbox';
   if (isset($_POST['load_sentbox'])) {
       $org_home = new org_home();
       $org_home->load_sentbox();
   }

  //for loading groups
  // $load_groups = 'load_groups';
  if (isset($_POST['load_groups'])) {
      $org_home = new org_home();
      $org_home->load_groups();
  }

  //for load_auth_access
  // $load_auth_access = ;
//  $load_auth_access = "load_auth_access";
  if (isset($_POST['load_auth_access'])) {
      $org_home = new org_home();
      $org_home->load_auth_access();
  }

//for updation link
  if (isset($_POST['update_auth_link'])) {
      $org_home = new org_home();
      $org_home->update_auth_link();
  }

// for getting org_auth_access link

  if (isset($_POST['get_auth_link'])) {
      $org_home = new org_home();
      $org_home->get_auth_link();
  }

  if (isset($_POST['get_org'])) {
      $org_home = new org_home();
      $org_home->get_org();
  }

  if (isset($_POST['logout'])) {
      $org_home = new org_home();
      $org_home->logout();
  }

 ?>
