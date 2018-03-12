 <?php


    function insert_into_sender($message_id, $parent_sender, $child_sender)
    {
        $root_dir = $_SERVER['DOCUMENT_ROOT'];
        include $root_dir.'/server/connect.php';

        $query = "insert into sender values ('','$message_id','$parent_sender','$child_sender')";

        return $result = mysqli_query($dbc, $query);
    }

    function delete_sender($message_id, $notifier_id)
    {
        $root_dir = $_SERVER['DOCUMENT_ROOT'];
        include $root_dir.'/server/connect.php';

        $query = "delete from sender where message_id = '$message_id' AND parent_sender = '$notifier_id'";

        return $result = mysqli_query($dbc, $query);
    }

  function load_sentbox($notifier_id)
  {
      $root_dir = $_SERVER['DOCUMENT_ROOT'];
      include $root_dir.'/server/connect.php';
      $sentbox = array();
      $message = array();
      $query = "select message_id from sender where parent_sender ='$notifier_id'";
      $result = mysqli_query($dbc, $query);

      while ($row = mysqli_fetch_array($result)) {
          $message_id = $row['message_id'];

          $query_message_contents = "select * from message where message_id = '$message_id' limit 1";
          $result_message_contents = mysqli_query($dbc, $query_message_contents);
          $row_message_contents = mysqli_fetch_array($result_message_contents);
          $message = $row_message_contents['message'];
          $subject = $row_message_contents['subject'];
          $count = $row_message_contents['count'];
          $date = $row_message_contents['date'];
          $time = $row_message_contents['time'];

          $message = array(
                        'id' => "$message_id",
                                'subject' => "$subject",
                    'body' => "$message",
                    'to' => "$count",
                    'date' => "$date",
                    'time' => "$time",
                               );

          array_push($sentbox, $message);
      }

      return json_encode($sentbox);
  }

 ?>
