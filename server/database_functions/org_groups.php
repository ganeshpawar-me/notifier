<?php

     function insert_org_groups($notifier_id, $groupname, $admin)
     {
         $root_dir = $_SERVER['DOCUMENT_ROOT'];
         include $root_dir.'/server/connect.php';

         $query = "insert into org_groups values ('','$notifier_id','$groupname','$admin')";

         return $result = mysqli_query($dbc, $query);
     }

     function delete_org_groups($notifier_id, $groupname)
     {
         $root_dir = $_SERVER['DOCUMENT_ROOT'];
         include $root_dir.'/server/connect.php';
         $query = "delete from org_groups where notifier_id = '$notifier_id' AND groupname ='$groupname'";
         $result1 = mysqli_query($dbc, $query);

         $query = "delete from org_connection where notifier_id  = '$notifier_id' AND groupname = '$groupname'";
         $result2 = mysqli_query($dbc, $query);

         if ($result1 and $result2) {
             return true;
         } else {
             return false;
         }
     }

   function load_groups($notifier_id)
   {
       $root_dir = $_SERVER['DOCUMENT_ROOT'];
       include $root_dir.'/server/connect.php';
       $groups_list = array();

       $query = "select  groupname from org_groups where notifier_id='$notifier_id'";
       $result = mysqli_query($dbc, $query);
       $group_members = array();
       while ($row = mysqli_fetch_array($result)) {
           $groupname = $row['groupname'];
           $members = array();
        // to find member
        $query_member = "select member from org_connection where notifier_id='$notifier_id' AND             groupname='$groupname'";
           $result_member = mysqli_query($dbc, $query_member);

           while ($row_member = mysqli_fetch_array($result_member)) {
               array_push($members, $row_member['member']);
           }
           $group_members[$groupname] = array(
             'members' => $members,
             'link' => "http://notifier.esy.es/connection.php?group=$groupname&org=$notifier_id", );
       }

       return json_encode($group_members);
   }
