<?php

 function group_validation($orgname, $groupname)
 {
     $root_dir = $_SERVER['DOCUMENT_ROOT'];
     include $root_dir.'/server/connect.php';
     $query = "select groupname from org_groups where notifier_id='$orgname' AND groupname='$groupname'";
     $result = mysqli_query($dbc, $query);

     if ($row = mysqli_num_rows($result) > 0) {
         return true;
     }

     return false;
 }

 function group_duplication($orgname, $groupname, $member)
 {
     $root_dir = $_SERVER['DOCUMENT_ROOT'];
     include $root_dir.'/server/connect.php';
     $query = "select * from org_connection where notifier_id='$orgname' AND groupname='$groupname'
    AND member='$member'";
     $result = mysqli_query($dbc, $query);

     if ($row = mysqli_num_rows($result) > 0) {
         return true;
     }

     return false;
 }

function group_add($orgname, $groupname, $member)
{
    $root_dir = $_SERVER['DOCUMENT_ROOT'];
    include $root_dir.'/server/connect.php';

    $query = "insert into org_connection values('','$orgname','$groupname','$member')";
    $result = mysqli_query($dbc, $query);

    if ($result) {
        return true;
    } else {
        return false;
    }
}

function is_login()
{
    session_start();
    if (isset($_SESSION['notifier_id'])) {
        $notifier_id = $_SESSION['notifier_id'];

        return $notifier_id;
    } else {
        if (isset($_COOKIE['notifier_id'])) {
            $notifier_id = $_COOKIE['notifier_id'];

            return $notifier_id;
        } else {
            return false;
        }
    }
}

     if (isset($_GET['group']) && isset($_GET['org'])) {
         $groupname = $_GET['group'];
         $orgname = $_GET['org'];
     // for validation of groups
     if (group_validation($orgname, $groupname)) {

     //for user login
        $notifier_id = is_login();
         if ($notifier_id == false) {
             setcookie('orgname', $orgname);
             setcookie('groupname', $groupname);
        // write redirect code
        echo '<script>alert("Please login first")</script>';
             echo '<script>location.href="./index.html";</script>';
         } else {
             //echo "loged in";
        // for duplication of groups
        if (group_duplication($orgname, $groupname, $notifier_id)) {
            echo '<script>alert("connection already exists")</script>';
            echo '<script>location.href="./personal.html";</script>';
        } else {
            //echo "not exists";
          if (group_add($orgname, $groupname, $notifier_id)) {
              //echo "successfully added";
            echo '<script>alert("Connection Added. Go to connection tab")</script>';
            //redirect
            echo '<script>location.href="./personal.html";</script>';
          } else {
              echo 'error';
          }
        }
         }
     } else {
         //echo "not valid";
       echo '<script>alert("Link is not valid")</script>';
     }
     }

     // redirect from login page
     else {
         if (isset($_COOKIE['orgname']) && isset($_COOKIE['groupname'])) {
             session_start();
             $notifier_id = $_SESSION['notifier_id'];
             $groupname = $_COOKIE['groupname'];
             $orgname = $_COOKIE['orgname'];
             if (group_duplication($orgname, $groupname, $notifier_id)) {
                 //echo "exists";

              echo '<script>alert("Connection already exists")</script>';
                 echo '<script>location.href="./personal.html";</script>';
             } else {
                 //echo "not exists";
              if (group_add($orgname, $groupname, $notifier_id)) {
                  //echo "successfully added";
                echo '<script>alert("Connection added. Go to Connection tab")</script>';
                //redirect
                echo '<script>location.href="./personal.html";</script>';
              } else {
                  echo 'error';
              }
             }
             $expire = time() - 300;
             setcookie('orgname', '', $expire);
             setcookie('groupname', '', $expire);
         } else {
             echo ' session not set';
         }
     }
