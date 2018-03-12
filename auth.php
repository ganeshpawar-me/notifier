<?php

  function link_validation($link)
  {
      $root_dir = $_SERVER['DOCUMENT_ROOT'];
      include $root_dir.'/server/connect.php';

      $query = "select notifier_id from org_profile where link='$link' limit 1";
      $result = mysqli_query($dbc, $query);

      if ($num = mysqli_num_rows($result) > 0) {
          $row = mysqli_fetch_array($result);

          return $row['notifier_id'];
      } else {
          return false;
      }
  }

  function auth_duplication($personal_notifier_id, $org_notifier_id)
  {
      $root_dir = $_SERVER['DOCUMENT_ROOT'];
      include $root_dir.'/server/connect.php';
      $query = "select org_notifier_id from auth_access where org_notifier_id='$org_notifier_id' AND personal_notifier_id='$personal_notifier_id'";
      $result = mysqli_query($dbc, $query);

      if ($num = mysqli_num_rows($result) > 0) {
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

  function auth_access_add($personal_notifier_id, $org_notifier_id)
  {
      $root_dir = $_SERVER['DOCUMENT_ROOT'];
      include $root_dir.'/server/connect.php';
      $query = "insert into auth_access values ('','$org_notifier_id','$personal_notifier_id')";

      return $result = mysqli_query($dbc, $query);
  }

  if (isset($_GET['org'])) {
      $link = $_GET['org'];

      $validation = link_validation($link);
      if (!$validation == false) {
          $org = $validation;
    //to check login
    $notifier_id = is_login();
          if ($notifier_id == false) {
              setcookie('auth_link', $link);
      // write redirect code
      echo '<script>alert("please login first");</script>';
              echo '<script>location.href="./index.html";</script>';
      // echo '<script>location.href="../test.php";</script>';
          } else {

      //for duplication
      if (auth_duplication($notifier_id, $org)) {
          echo '<script>alert("Authorized access already exists");</script>';
          echo '<script>location.href="./personal.html";</script>';
      } else {

      // for adding
      if (auth_access_add($notifier_id, $org)) {
          echo '<script>alert("Authorized access given. Go to organization tab");</script>';
          echo '<script>location.href="./personal.html";</script>';
      } else {
          echo 'error';
      }
      }
          }
      } else {
          echo '<script>alert("Link is not valid")</script>';
      }
  }
  // not login
    else {
        if (isset($_COOKIE['auth_link'])) {
            $link = $_COOKIE['auth_link'];
            $validation = link_validation($link);
            if (!$validation == false) {
                session_start();
                $org = $validation;
                $notifier_id = $_SESSION['notifier_id'];
      //for duplication
      if (auth_duplication($notifier_id, $org)) {
          echo '<script>alert("Authorized access already exists");</script>';
          echo '<script>location.href="./personal.html";</script>';
      } else {
          if (auth_access_add($notifier_id, $org)) {
              echo '<script>alert("Authorized access given. Go to organization tab");</script>';
              echo '<script>location.href="./personal.html";</script>';
          } else {
              echo 'error';
          }
      }
            } else {
                echo '<script>alert("invalid link");</script>';
            }
            $expire = time() - 300;
            setcookie('auth_link', '', $expire);
        } else {
            echo 'session not set';
        }
    }
