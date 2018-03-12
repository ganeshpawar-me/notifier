 <?php

    function delete_group_member($notifier_id, $delete_group_member, $groupname)
    {
        $root_dir = $_SERVER['DOCUMENT_ROOT'];
        include $root_dir.'/server/connect.php';
        $query = "delete from org_connection where
		notifier_id = '$notifier_id'
		AND
		groupname = '$groupname'
		AND
		member = '$delete_group_member'";

        return $result = mysqli_query($dbc, $query);
    }

    function search_org_connections($notifier_id)
    {
        $root_dir = $_SERVER['DOCUMENT_ROOT'];
        include $root_dir.'/server/connect.php';
        $query = "select notifier_id , groupname from org_connection where notifier_id = '$notifier_id'";

        return $result = mysqli_query($dbc, $query);
    }

    function duplication_org_connctions($notifier_id, $group, $member)
    {
        $root_dir = $_SERVER['DOCUMENT_ROOT'];
        include $root_dir.'/server/connect.php';
        $query = "select member from org_connection where notifier_id ='$notifier_id' AND member = '$member'";

        return $result = mysqli_query($dbc, $query);
    }

    function add_org_connection($notifier_id, $group, $member)
    {
        $root_dir = $_SERVER['DOCUMENT_ROOT'];
        include $root_dir.'/server/connect.php';

        $query = "insert into org_connection values ('','$notifier_id','$group','$member')";

        return $result = mysqli_query($dbc, $query);
    }

    function remove_org_connection($notifier_id, $group, $member)
    {
        $root_dir = $_SERVER['DOCUMENT_ROOT'];
        include $root_dir.'/server/connect.php';

        $query = "delete from org_connection where notifier_id = '$notifier_id' AND groupname ='$group' AND member ='$member'";

        return $result = mysqli_query($dbc, $query);
    }

    function load_connections($notifier_id)
    {
        $root_dir = $_SERVER['DOCUMENT_ROOT'];
        include $root_dir.'/server/connect.php';
        $connections = array();
        $query = "select notifier_id,groupname from org_connection where member = '$notifier_id'";
        $result = mysqli_query($dbc, $query);
        while ($row = mysqli_fetch_array($result)) {
            $org_notifier_id = $row['notifier_id'];
            $groupname = $row['groupname'];
            $connections["$groupname"] = $org_notifier_id;
            // array_push($connections,$new_connection);
        }

        return json_encode($connections);
    }

 ?>
