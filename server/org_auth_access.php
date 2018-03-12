 <?php

    class auth_access
    {
        public function add_auth_access($add_auth_access)
        {
            include 'database_functions/auth_access.php';
            $notifier_id = $_COOKIE['org_notifier_id'];
            $result = search_auth_access($notifier_id, $add_auth_access);
            if ($result) {
                echo 'Already Exists';
            } else {
                if ($result = add_auth_access($notifier_id, $add_auth_access)) {
                    echo 'Added';
                } else {
                    echo 'Error';
                }
            }
        }

        public function remove_auth_access($remove_auth_access)
        {
            include 'database_functions/auth_access.php';
            $notifier_id = $_COOKIE['org_notifier_id'];
            if ($result = remove_auth_access($notifier_id, $remove_auth_access)) {
                echo '1';
            } else {
                echo '0';
            }
        }

        public function is_auth_access($org_notifier_id)
        {
            include 'database_functions/auth_access.php';
            session_start();

            $personal_notifier_id = $_SESSION['notifier_id'];
            if ($result = is_auth_access($org_notifier_id, $personal_notifier_id)) {
                // echo 'Auth Access';
                setcookie('org_notifier_id', $org_notifier_id, null, '/');
                echo '1';
            } else {
                echo '0';
            }
        }

        public function is_admin_access($org_notifier_id)
        {
            include 'database_functions/org_profile.php';
            session_start();

            $personal_notifier_id = $_SESSION['notifier_id'];

            if ($result = is_admin_access($org_notifier_id, $personal_notifier_id)) {
                // echo 'Auth Access';
                setcookie('org_notifier_id', $org_notifier_id, null, '/');
                // write redirect code here
                echo '1';
            } else {
                echo '0';
            }
        }
    }

    // for adding auth access
    // use $_POST['add_auth_access'];
   // $add_auth_access = 'ganesh';
   if (isset($_POST['add_auth_access'])) {
       $add_auth_access = trim($_POST['add_auth_access']);
      //  $add_auth_access = 'ganesh';
       $auth_access = new auth_access();
       $auth_access->add_auth_access($add_auth_access);
   }

   // for removing auth_access
   // use $_POST['remove_auth_access'];
    // $remove_auth_access = 'ganesh';
     if (isset($_POST['remove_auth_access'])) {
         $remove_auth_access = trim($_POST['remove_auth_access']);
        //  $remove_auth_access = 'ganesh';
         $auth_access = new auth_access();
         $auth_access->remove_auth_access($remove_auth_access);
     }

     //for checking for auth access
     //use $_POST['is_auth_access'];
     //$is_auth_access = 'scoe';
     if (isset($_POST['is_auth_access'])) {
         $is_auth_access = trim($_POST['is_auth_access']);
        //  $is_auth_access ='scoe';
         $auth_access = new auth_access();
         $auth_access->is_auth_access($is_auth_access);
     }

     // for checking admin access
     // use $_POST['is_admin_access']
    //  $is_admin_access = 'scoe';
     if (isset($_POST['is_admin_access'])) {
         $is_admin_access = trim($_POST['is_admin_access']);
         $auth_access = new auth_access();
         $auth_access->is_admin_access($is_admin_access);
     }

 ?>
