<?php

            $root_dir = $_SERVER['DOCUMENT_ROOT'];
            include $root_dir.'/server/connect.php';
            include 'primary_functions.php';
            //include 'validation.php';

            $firstname = '';
            $lastname = '';
            $mobile_no = 1111111111;
            // $email = 'akshaynaik404@gmail.com';
            $confirm_new_password = trim($_POST['confirm-password']);
            $new_notifierid = trim($_POST['new-notifier-id']);
            $new_password = trim($_POST['new-password']);
            $email = trim($_POST['email']);
            $errors = [];

            if ($new_notifierid == '') {
                $errors['new-notifier-id'] = 'Username cannot be empty';
            } elseif (!preg_match("/^[A-Z|a-z|\_|\-]*$/", $new_notifierid)) {
                $errors['new-notifier-id'] = 'Special characters not allowed';
            }
            if ($new_password == '') {
                $errors['new-password'] = 'New password cannot be empty';
            }
            if ($new_password != $confirm_new_password) {
                $errors['confirm-password'] = 'Passwords do not match';
            }
            if ($email == '') {
                $errors['email'] = 'E-mail cannot be empy';
            } elseif (duplication('email', $email, 'temp')) {
                $errors['email'] = 'Verification link already sent';
            } elseif (duplication('email', $email, 'personal_profile')) {
                $errors['email'] = 'Email already exists';
            }

            if (!empty($errors)) {
                echo json_encode($errors);
            } else {
                if (
              duplication('notifier_id', $new_notifierid, 'personal_profile')
              ||
              duplication('notifier_id', $new_notifierid, 'org_profile')

              ) {
                    $errors['new-notifier-id'] = 'Username already exists';
                    echo json_encode($errors);
                } else {
                    $otp = 'adfd';
                    $otp = str_shuffle($otp);
                    $query = "insert into temp values
  			            (
  						 '',
  						'$new_notifierid',
  						'$firstname',
  						'$lastname',
  						'$email',
  						'$confirm_new_password',
  						'$mobile_no',
  						'$otp'
  						)";

                    if (mysqli_query($dbc, $query)) {
                        $otp_link = "notifier.esy.es/server/personal_signup.php?otp=$otp";
                        $to = $email;
                        $subject = 'Verify your Notifier Account';
                        $message = $otp_link;
                        $headers = 'From: notifier.website'."\r\n".'Reply-To: no-reply@notifier.website'."\r\n".'X-Mailer: PHP/'.phpversion();
                        // echo '1';
                        if (mail($to, $subject, $message, $headers)) {
                            echo '1';
                        } else {
                            echo '0';
                        }
                    } else {
                        echo '0';
                    }
                }
            }
