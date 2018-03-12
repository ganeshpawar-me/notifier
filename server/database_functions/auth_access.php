 <?php

    function add_auth_access($org_notifier_id, $personal_notifier_id)
    {
        $root_dir = $_SERVER['DOCUMENT_ROOT'];
        include $root_dir.'/server/connect.php';
        $query = "insert into auth_access values('','$org_notifier_id','$personal_notifier_id')";

        return $result = mysqli_query($dbc, $query);
    }

    function remove_auth_access($org_notifier_id, $personal_notifier_id)
    {
        $root_dir = $_SERVER['DOCUMENT_ROOT'];
        include $root_dir.'/server/connect.php';
        $query = "delete from auth_access where
		org_notifier_id = '$org_notifier_id'
		AND
		personal_notifier_id ='$personal_notifier_id'";

        return $result = mysqli_query($dbc, $query);
    }

    function is_auth_access($org_notifier_id, $personal_notifier_id)
    {
        $root_dir = $_SERVER['DOCUMENT_ROOT'];
        include $root_dir.'/server/connect.php';
        $query = "select org_notifier_id from auth_access where
		org_notifier_id = '$org_notifier_id'
		AND
		personal_notifier_id = '$personal_notifier_id'";
        $result = mysqli_query($dbc, $query);

        if (mysqli_num_rows($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

     function personal_load_auth_access($notifier_id)
     {
         $root_dir = $_SERVER['DOCUMENT_ROOT'];
         include $root_dir.'/server/connect.php';
         $query = "select org_notifier_id from auth_access where personal_notifier_id = '$notifier_id'";
         $result = mysqli_query($dbc, $query);
         $auth_access = array();
         if ($result) {
             while ($row = mysqli_fetch_array($result)) {
                 $org_notifier_id = $row['org_notifier_id'];
                 array_push($auth_access, "$org_notifier_id");
             }

             return json_encode($auth_access);
         } else {
             echo 'errer';
         }
     }

  function org_load_auth_access($notifier_id)
  {
      $root_dir = $_SERVER['DOCUMENT_ROOT'];
      include $root_dir.'/server/connect.php';
      $query = "select personal_notifier_id from auth_access where org_notifier_id = '$notifier_id'";
      $result = mysqli_query($dbc, $query);
      $auth_access = array();
      if ($result) {
          while ($row = mysqli_fetch_array($result)) {
              $personal_notifier_id = $row['personal_notifier_id'];
              array_push($auth_access, "$personal_notifier_id");
          }

          return json_encode($auth_access);
      } else {
          echo 'errer';
      }
  }

 ?>
