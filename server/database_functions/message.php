 <?php

    function insert_into_message($subject, $message, $count)
    {
        $root_dir = $_SERVER['DOCUMENT_ROOT'];
        include $root_dir.'/server/connect.php';

        $str = 'abcdefghij';
        $shuffled = str_shuffle($str);

        $date = date_create();
        $time_stamp = date_timestamp_get($date);
        $time_stamp = $time_stamp.$shuffled;

        $date = date_format($date, 'Y/m/d');
        date_default_timezone_set('Asia/kolkata');
        $time = date('h:i:sa');

        $message_id = $time_stamp;

        $query = "insert into message values('','$message_id','$subject','$message','$date','$time','$count')";
        $result = mysqli_query($dbc, $query);

        if ($result) {
            $msgObj = array('date' => $date, 'time' => $time, 'id' => $message_id);

            return $msgObj;
        } else {
            return false;
        }
    }

 ?>
