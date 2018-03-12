 <?php


    class personal_connection
    {
        public function search_org_connection($notifier_id)
        {
            $root_dir = $_SERVER['DOCUMENT_ROOT'];
            include $root_dir.'/server/connect.php';
            include 'database_functions/org_connections.php';
            include 'database_functions/org_profile.php';

            $result = search_org_profile($notifier_id);
            if ($result) {
                if (mysqli_num_rows($result) > 0) {
                    if ($result = search_org_connections($notifier_id)) {
                        if (mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_array($result);
                            echo $row['notifier_id'];
                            echo $row ['groupname'];
                        } else {
                            echo 'This organization does not have any groups yet';
                        }
                    } else {
                        echo 'error';
                    }
                } else {
                    echo 'This notifier id does not exists';
                }
            } else {
                echo 'error';
            }
        }

        public function add_org_connection($add_org_connection, $group)
        {
            include 'database_functions/org_connections.php';
            session_start();
            $member = $_SESSION['notifier_id'];
            if ($result = duplication_org_connctions($add_org_connection, $group, $member)) {
                if (mysqli_num_rows($result) > 0) {
                    echo 'Already Exists';
                } else {
                    if ($result = add_org_connection($add_org_connection, $group, $member)) {
                        echo 'Added';
                    } else {
                        echo 'error';
                    }
                }
            } else {
                echo 'error';
            }
        }

        public function remove_org_connection($remove_org_connection, $group)
        {
            include 'database_functions/org_connections.php';
            session_start();
            $member = $_SESSION['notifier_id'];

            if ($result = remove_org_connection($remove_org_connection, $group, $member)) {
                echo '1';
            } else {
                echo '0';
            }
        }
    }

   // for searching for org connection
    //use isset for $_POST['search_org_connection'];
    //$search_org_connection = 'scoe';

    if (isset($search_org_connection)) {
        //search_org_connection = $_POST['search_org_connection'];
        $search_org_connection = 'pict';
        $personal_connection = new personal_connection();
        $personal_connection->search_org_connection($search_org_connection);
    }

    // for adding org_connection
    // use isset for $_POST['add_org_connection'];
    //$add_org_connection = 'scoe';
    //$group = 'TE';
    if (isset($add_org_connection)) {
        //$add_org_connection = $_POST['add_org_connection'];
        //$group = $_POST['group'];

        $add_org_connection = 'scoe';
        $group = 'BE';
        $personal_connection = new personal_connection();
        $personal_connection->add_org_connection($add_org_connection, $group);
    }

    // for removing org_connection
    //use isset for $_POST['remove_org_connection'];
    // $remove_org_connection = 'scoe';
    // $group = 'BE';
    if (isset($_POST['remove_org_connection'])) {
        $remove_org_connection = trim($_POST['remove_org_connection']);
        $group = trim($_POST['group_name']);
        // $remove_org_connection = 'scoe';
        // $group = 'BE';

        $personal_connection = new personal_connection();
        $personal_connection->remove_org_connection($remove_org_connection, $group);
    }

 ?>
