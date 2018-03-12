<?php
    include 'primary_functions.php';
    include 'connect.php';

    session_start();

    if (!isset($_SESSION['notifier_id'])) {
        setcookie('org_signup', 'org', null, '/');
        echo '0';
    } else {
        // write code here to session value
    $errors = [];
        $org_name = trim($_POST['org-name']);
        $new_notifierid = trim($_POST['org-notifier-id']);

        if ($org_name == '') {
            $errors['org-name'] = 'Organization name empty';
        } elseif (!preg_match('/^[A-Z|a-z| ]*$/', $org_name)) {
            $errors['org-name'] = 'Special Characters are not allowed';
        }

        if ($new_notifierid == '') {
            $errors['org-notifier-id'] = 'Username Empty';
        } elseif (!preg_match('/^[A-Z|a-z]*$/', $new_notifierid)) {
            $errors['org-notifier-id'] = 'Only Alpha-Numeric characters are allowed';
        }

        if (
        duplication('notifier_id', $new_notifierid, 'personal_profile')
        ||
        duplication('notifier_id', $new_notifierid, 'org_profile')

        ) {
            $errors['org-notifier-id'] = 'Org Username already exists';
        } else {
            $empty_array = array();
            $empty_array = serialize($empty_array);
            $admin = $_SESSION['notifier_id'];  // take this value from session
            $str = 'axt';
            $num = '861';
            $link = $num.$new_notifierid.$str;
            $link = str_shuffle($link);
             // insert into org_profile
             $query = "insert into org_profile values
			            (
						'',
						'$new_notifierid',
						'$org_name',
						'$admin',
            '$link'
						)";

            if (mysqli_query($dbc, $query)) {
                $expire = time() - 300;
                setcookie('org_signup', '', $expire, '/');
                echo '1';
            }
        }
        if (!empty($errors)) {
            echo json_encode($errors);
        }
    }
