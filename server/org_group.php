 <?php

  session_start();
    class group
    {
        public function create($groupname)
        {
            $root_dir = $_SERVER['DOCUMENT_ROOT'];
            include $root_dir.'/server/connect.php';
            include 'database_functions/org_groups.php';
            $notifier_id = $_COOKIE['org_notifier_id'];
            $query = "select notifier_id from org_groups where notifier_id = '$notifier_id' AND groupname = '$groupname'";
            $result = mysqli_query($dbc, $query);
            $row = mysqli_fetch_array($result);
            if (mysqli_num_rows($result) > 0) {
                // group exists
                  echo '0';
            } else {
                $admin = $_SESSION['notifier_id'];
                if ($result = insert_org_groups($notifier_id, $groupname, $admin)) {
                    echo "http://notifier.esy.es/connection.php?group=$groupname&org=$notifier_id";
                    //  group created
                } else {
                    echo 'Database Error';
                }
            }
        }

        public function delete($groupname)
        {
            include 'database_functions/org_groups.php';
            $notifier_id = $_COOKIE['org_notifier_id'];
            $result = delete_org_groups($notifier_id, $groupname);
            if ($result) {
                echo '1';
            } else {
                echo '0';
            }
        }

        public function delete_group_member($delete_group_member, $groupname)
        {
            include 'database_functions/org_connections.php';
            $notifier_id = $_COOKIE['org_notifier_id'];
            $result = delete_group_member($notifier_id, $delete_group_member, $groupname);
            if ($result) {
                echo '1';
            } else {
                echo '0';
            }
        }
    }

    //for group creation
    if (isset($_POST['create_group'])) {
        $groupname = trim($_POST['create_group']);
        $group = new group();
        $group->create($groupname);
    }

    // for group deletion
     if (isset($_POST['delete_group'])) {
         $groupname = trim($_POST['delete_group']);
         $group = new group();
         $group->delete($groupname);
     }

    //for group member deletion
    if (isset($_POST['group_member']) && isset($_POST['group_name'])) {
        $delete_group_member = trim($_POST['group_member']);
        $group_name = trim($_POST['group_name']);
        $group = new group();
        $group->delete_group_member($delete_group_member, $group_name);
    }

 ?>
