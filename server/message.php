<?php

   class message
   {
       public function send($recipients, $subject, $message)
       {
           include 'database_functions/sender.php';
           include 'database_functions/recipients.php';
           include 'database_functions/message.php';
           include 'database_functions/player_id.php';
           include 'onesignal.php';

           $str = 'abcdefghijklmnopqrst';
           $shuffled = str_shuffle($str);

           $count = 0;
           $split_recipient = explode(',', $recipients);
           foreach ($split_recipient as $notifier_id) {
               ++$count;
           }
           $msgObj = insert_into_message($subject, $message, $count);
           $message_id = $msgObj['id'];
           if ($message_id == false) {
               echo 'error in message';
           } else {
               session_start();

               $parent_sender = $_COOKIE['org_notifier_id'];
               $child_sender = $_SESSION['notifier_id'];
               if ($result = insert_into_sender($message_id, $parent_sender, $child_sender)) {
                   if ($result = insert_into_recipients($message_id, $recipients)) {

            $player_id = get_player_id($recipients);
           // print_r($player_id);
           //pl($player_id);
            sendMessage($subject,$player_id);
                  //      echo json_encode($msgObj);
                   } else {
                       echo 'error';
                   }
               } else {
                   echo  'error in sender';
               }
           }
       }

       public function delete_inbox($message_id, $notifier_id)
       {
           include 'database_functions/recipients.php';
           if ($result = delete_recipients($message_id, $notifier_id)) {
               echo '1';
           } else {
               echo '0';
           }
       }
       public function delete_sentbox($message_id, $notifier_id)
       {
           include 'database_functions/sender.php';
           if ($result = delete_sender($message_id, $notifier_id)) {
               echo '1';
           } else {
               echo '0';
           }
       }
   }

    // to send message
    // use $_POST['subject'];
    //$_POST['message'];
    //$_POST['recipients'];
    //$recipients = 'ganesh';
    // 
    if (isset($_POST['recipients'])) {
        $recipients = trim($_POST['recipients']);
      //$recipients = 'aditya';
        $subject = trim($_POST['subject']);
        $message = trim($_POST['message']);
        //$recipients = 'ganesh,akshay';
        if (empty($recipients)) {
            echo 'Please select recipients';
        } else {

    //       		$recipients = 'ganesh';
        // $subject = 'message';
         //$message = 'hdhfjhfjk';

        $msg = new message();
            $msg->send($recipients, $subject, $message);
        }
    }
        // to delete message
        //$_POST['Acc_type'];
        //$_POST['message_id'];
        //$_POST['table_name'];

         //$message_id  = 1483691427;
        if (isset($_POST['message_id'])) {
            $message_id = trim($_POST['message_id']);
            //$Acc_type = 'personal';
      $Acc_type = trim($_POST['acc_type']);
            // $table_name = 'inbox';
      $table_name = trim($_POST['table_name']);
            // $message_id = 1483691427;

            if ($Acc_type == 'org') {
                $notifier_id = $_COOKIE['org_notifier_id'];
            }
            if ($Acc_type == 'personal') {
                session_start();
                $notifier_id = $_SESSION['notifier_id'];
            }

            if ($table_name == 'sender') {
                $msg = new message();
                $msg->delete_sentbox($message_id, $notifier_id);
            }
            if ($table_name == 'recipients') {
                $msg = new message();
                $msg->delete_inbox($message_id, $notifier_id);
            }
        }
