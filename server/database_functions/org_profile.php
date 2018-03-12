 <?php

    function search_org_profile($notifier_id)
    {
        $root_dir = $_SERVER['DOCUMENT_ROOT'];
        include $root_dir.'/server/connect.php';
        $query = "select notifier_id from org_profile where notifier_id = '$notifier_id' limit 1";

        return $result = mysqli_query($dbc, $query);
    }

    function is_admin_access($notifier_id, $admin)
    {
        $root_dir = $_SERVER['DOCUMENT_ROOT'];
        include $root_dir.'/server/connect.php';

        $query = "select notifier_id from org_profile where notifier_id='$notifier_id' AND admin = '$admin' limit 1";

        $result = mysqli_query($dbc, $query);

        if (mysqli_num_rows($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    function load_admin_access($notifier_id)
    {
        $root_dir = $_SERVER['DOCUMENT_ROOT'];
        include $root_dir.'/server/connect.php';
        $admin = array();
        $query = "select notifier_id from org_profile where admin = '$notifier_id'";
        $result = mysqli_query($dbc, $query);

        if ($result) {
            while ($row = mysqli_fetch_array($result)) {
                $org_notifier_id = $row['notifier_id'];
                array_push($admin, $org_notifier_id);
            }

            return json_encode($admin);
        } else {
            echo 'error';
        }
    }

  function update_auth_link()
  {
      $root_dir = $_SERVER['DOCUMENT_ROOT'];
      include $root_dir.'/server/connect.php';
      $notifier_id = $_COOKIE['org_notifier_id'];
      $str = 'hti';
      $num = '691';
      $link = $str.$notifier_id.$num;
      $link = str_shuffle($link);

      $query = "update org_profile set link='$link' where notifier_id='$notifier_id'";

      $result = mysqli_query($dbc, $query);
      if ($result) {
          return $link;
      } else {
          return 'error';
      }
  }

  function get_auth_link($notifier_id)
  {
      $root_dir = $_SERVER['DOCUMENT_ROOT'];
      include $root_dir.'/server/connect.php';
      $query = "select link from org_profile where notifier_id='$notifier_id' limit 1";
      $result = mysqli_query($dbc, $query);
      if ($result) {
          $row = mysqli_fetch_array($result);

          return $row['link'];
      } else {
          return false;
      }
  }
 ?>
