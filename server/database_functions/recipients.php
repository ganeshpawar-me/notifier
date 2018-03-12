 <?php


    function insert_into_recipients($message_id, $recipients)
    {
        $root_dir = $_SERVER['DOCUMENT_ROOT'];
        include $root_dir.'/server/connect.php';

        $split_recipient = explode(',', $recipients);
        foreach ($split_recipient as $notifier_id) {
            $query = "insert into recipients values ('','$message_id','$notifier_id')";
            $result = mysqli_query($dbc, $query);
            if ($result) {
            } else {
                return $result;
            }
        }

        return $result;
    }

   function delete_recipients($message_id, $notifier_id)
   {
       $root_dir = $_SERVER['DOCUMENT_ROOT'];
       include $root_dir.'/server/connect.php';

       $query = "delete from recipients where message_id = '$message_id' AND recipients = '$notifier_id'";

       return $result = mysqli_query($dbc, $query);
   }

    function load_inbox($notifier_id)
    {
        $root_dir = $_SERVER['DOCUMENT_ROOT'];
        include $root_dir.'/server/connect.php';
        $inbox = array();
        $message = array();
        $query = "select message_id from recipients where recipients ='$notifier_id'";
        $result = mysqli_query($dbc, $query);

        while ($row = mysqli_fetch_array($result)) {
            $message_id = $row['message_id'];

        // to get message sender

        $query_message_sender = "select parent_sender , child_sender from sender where message_id = '$message_id' limit 1 ";
            $result_message_sender = mysqli_query($dbc, $query_message_sender);
            $row_message_sender = mysqli_fetch_array($result_message_sender);
            $parent_sender = $row_message_sender['parent_sender'];
            $child_sender = $row_message_sender['child_sender'];

        // to get message contents
      $query_message_contents = "select * from message where message_id = '$message_id' limit 1";
            $result_message_contents = mysqli_query($dbc, $query_message_contents);
            $row_message_contents = mysqli_fetch_array($result_message_contents);
            $message = $row_message_contents['message'];
            $subject = $row_message_contents['subject'];
            $date = $row_message_contents['date'];
            $time = $row_message_contents['time'];

            $message = array(
                        'id' => "$message_id",
                        'sender' => array(
                          'parent' => "$parent_sender",
                          'child' => "$child_sender",
                        ),
                        'subject' => "$subject",
                        'body' => "$message",
                        'date' => "$date",
                        'time' => "$time",
                        );

            array_push($inbox, $message);
        }

        return json_encode($inbox);
    }

 ?>
