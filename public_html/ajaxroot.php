<?php
session_start();

date_default_timezone_set('Asia/Bangkok');
$dt_now = date('Y-m-d H:i:s');

const DS = DIRECTORY_SEPARATOR;
$dir_apps = dirname(__DIR__) . DS . 'apps';

defined('APPLIcATION_PATH') || define('APPLICATION_PATH', realpath($dir_apps));

require APPLICATION_PATH . DS . 'config' . DS . 'config.php';

$process_name = get('process_name');

if (!empty($process_name)) {
    switch ($process_name) {
        case 'maillist_subscribed':

            $maillist_email = sanitize_input(get('maillist_email'));

            db_insertref('tbl_maillists', 'maillist_email', $maillist_email, 2);
            db_updaterowbyref('tbl_maillists', 'maillist_email', $maillist_email, 2, 'maillist_enabled', 1, 1);

            $maillist_text = '';
            $maillist_text .= '<script>alert(\'Thank you to subscribe..\');</script>';
            $maillist_text .= '<script>window.location.href=\'./?page=home\';</script>';
            echo $maillist_text;
            break;
        case 'contact_message':

            $message_reference = sanitize_input(get('message_reference'));
            $message_contname = sanitize_input(get('message_contname'));
            $message_contemail = sanitize_input(get('message_contemail'));
            $message_subject = sanitize_input(get('message_subject'));
            $message_message = sanitize_input(get('message_message'));
            $message_datetime = date('Y-m-d H:i:s');

            db_insertref('tbl_messages', 'message_reference', $message_reference, 2);
            db_updaterowbyref('tbl_messages', 'message_reference', $message_reference, 2, 'message_contname', $message_contname, 2);
            db_updaterowbyref('tbl_messages', 'message_reference', $message_reference, 2, 'message_contemail', $message_contemail, 2);
            db_updaterowbyref('tbl_messages', 'message_reference', $message_reference, 2, 'message_subject', $message_subject, 2);
            db_updaterowbyref('tbl_messages', 'message_reference', $message_reference, 2, 'message_message', $message_message, 2);
            db_updaterowbyref('tbl_messages', 'message_reference', $message_reference, 2, 'message_datetime', $message_datetime, 2);

            $message_text = '';
            $message_text .= '<script>alert(\'Thank you very much for your message\\nWe will contact as soon as\');</script>';
            $message_text .= '<script>window.location.href=\'./?page=home\'</script>';
            echo $message_text;

            break;

        case 'user_checked_existing':
            $user_username = sanitize_input(get('user_username'));
            $user_application = sanitize_input(get('user_application'));
            // check in tbl_users for existing user_username
            // if none echo 0
            // if existing echo 1
            // if other echo 2
            echo db_cntrowby2refs('tbl_users', 'user_application', $user_application, 2, 'user_username', $user_username, 2);
            break;

        case 'user_signup':
            // insert user's data into table
            // application := application or program that user want to use
            // reference := reference number for user who signup

            $db_conn = db_connected();
            if (!$db_conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // a little bit verified input
            $user_application = sanitize_input(get('user_application'));
            $user_reference = sanitize_input(get('user_reference'));
            $user_username = sanitize_input(get('user_username'));
            $user_password = sanitize_input(get('user_password1st'));

            $user_password = password_hash($user_password, PASSWORD_DEFAULT);

            db_insertref('tbl_users', 'user_reference', $user_reference, 2);
            db_updaterowbyref('tbl_users', 'user_reference', $user_reference, 2, 'user_application', $user_application, 2);
            db_updaterowbyref('tbl_users', 'user_reference', $user_reference, 2, 'user_username', $user_username, 2);
            db_updaterowbyref('tbl_users', 'user_reference', $user_reference, 2, 'user_password', $user_password, 2);
            db_updaterowbyref('tbl_users', 'user_reference', $user_reference, 2, 'user_created', $dt_now, 2);

            log_write($user_application, 'user sign-up', 'user [' . $user_reference . '] signed-up');

            $output = '<script>alert(\'User registered\');</script>';
            $output .= '<script>window.location.href=\'user_signin.php\';</script>';
            echo $output;
            break;

        case 'user_signin':
            // define number of device(s) one user able to sign-in into application
            $max_signin = 1;
            // checked user who login to application
            $db_conn = db_connected();
            if (!$db_conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // a little bit verified input
            $user_application = sanitize_input(get('user_application'));
            $user_username = sanitize_input(get('user_username'));
            $user_password = sanitize_input(get('user_password'));

            // collection of data
            $user_reference = db_get1databy1ref('tbl_users', 'user_username', $user_username, 2, 'user_reference');
            $user_userlevel = db_get1databy2refs('tbl_users', 'user_application', $user_application, 2, 'user_reference', $user_reference, 2, 'user_userlevel');
            $user_userlevel = str_pad($user_userlevel, 2, '0', STR_PAD_LEFT);
            $user_division = db_get1databy2refs('tbl_users', 'user_application', $user_application, 2, 'user_reference', $user_reference, 2, 'user_division');
            $user_signinnum = db_cntrowby2refs('tbl_signin', 'signin_app', $user_application, 2, 'signin_userref', $user_reference, 2);

            // 1st checked was sign-in username existing in application or not
            $is_user_in_app = db_cntrowby2refs('tbl_users', 'user_application', $user_application, 2, 'user_username', $user_username, 2);
            switch ($is_user_in_app) {
                case 1:
                    // 2nd verified password
                    $pass2verified = db_get1databy2refs('tbl_users', 'user_application', $user_application, 2, 'user_username', $user_username, 2, 'user_password');
                    $verified_pass = password_verify($user_password, $pass2verified);
                    if ($verified_pass === false) {
                        log_write($user_application, 'user sign-in', 'user [' . $user_reference . '] sign-in failed');
                        $alert_text = '<script>alert(\'Wrong password\\ntry to sign-in again\');</script>';
                        $alert_text .= '<script>window.location.href=\'user_signin.php\';</script>';
                        echo $alert_text;
                        die();
                    } else {
                        $usersignin_token = generated_token(50);

                        // check limit of user able to login to application ($max_signin)
                        while ($user_signinnum >= $max_signin) {
                            echo $user_signinnum . '<br>';
                            db_deleteoldestby2refs('tbl_signin', 'signin_app', $user_application, 2, 'signin_userref', $user_reference, 2, 'signin_datetime');
                            $user_signinnum = db_cntrowby2refs('tbl_signin', 'signin_app', $user_application, 2, 'signin_userref', $user_reference, 2);
                        }

                        // write data into sign-in table to check number of user able to login to application
                        // if number of user more than or equa to maximun allow will force to maximum
                        db_insertref('tbl_signin', 'signin_token', $usersignin_token, 2);
                        db_updaterowbyref('tbl_signin', 'signin_token', $usersignin_token, 2, 'signin_userref', $user_reference, 2);
                        db_updaterowbyref('tbl_signin', 'signin_token', $usersignin_token, 2, 'signin_app', $user_application, 2);
                        db_updaterowbyref('tbl_signin', 'signin_token', $usersignin_token, 2, 'signin_datetime', $dt_now, 2);

                        // Generated $_SESSION variable
                        $_SESSION['user_signin_token'] = $usersignin_token;
                        $_SESSION['user_signin_role'] = $user_application . $user_division . $user_userlevel . $user_reference;


                        log_write($user_application, 'user sign-in', 'user [' . $user_reference . '] sign-in succeed');

                        // Popup sign-in succeed text
                        $signin_success_text = '';
                        $signin_success_text .= '<script>alert(\'Sign-In Succeed\');</script>';
                        $signin_success_text .= '<script>window.location.href=\'./?page=member\'</script>';
                        echo $signin_success_text;
                    }
                    break;
                case 0:
                    echo 'Invalid user in this application';
                    break;

                default:
                    echo 'Invalid input parameters please re-input or contact administrator';
                    break;
            }
            break;

        case 'product_weighing':
            // echo '<pre>';
            // print_r($_POST);
            // echo '</pre>';

            $wg_reference = sanitize_input(get('po_reference'));
            $wg_seller = sanitize_input(get('seller_reference'));
            $wg_product = sanitize_input(get('wg_product'));
            $wg_value = sanitize_input(get('wg_value'));
            $wg_created = date('Y-m-d H:i:s');
            $wg_operator = user_data('user_reference', $_SESSION['user_signin_role']);

            $img_reference = db_cntrowby1ref('tbl_weighing', 'wg_reference', $wg_reference, 2);
            $wg_image = $wg_reference . '_' . str_pad(($img_reference + 1), 3, '0', STR_PAD_LEFT);


            db_insertweighing($wg_reference, $wg_seller, $wg_product, $wg_value, $wg_created, $wg_operator, $wg_image);

            $weighing_text = '';
            $weighing_text .= '<script>alert(\'Weight recorded\');</script>';
            $weighing_text .= '<script>window.location.href=\'./?page=weigh&action=weighing&weighing_reference=' . get('po_reference') . '&seller_reference=' . get('seller_reference') . '\'</script>';

            echo $weighing_text;
            break;

        case 'check_seller':
            // print_r($_POST);
            $name_2_check = get('name_2_check');
            $is_existing_customer = db_cntrowby1ref('tbl_sellers', 'seller_name', $name_2_check, 2);
            if ($is_existing_customer === 0) {
                $cust_reference = date('YmdHis');
                db_insertref('tbl_sellers', 'seller_reference', $cust_reference, 2);
                db_updaterowbyref('tbl_sellers', 'seller_reference', $cust_reference, 2, 'seller_name', $name_2_check, 2);
                db_updaterowbyref('tbl_sellers', 'seller_reference', $cust_reference, 2, 'seller_created', $dt_now, 2);
                echo 'New seller added';
            } else {
                echo 'Existing seller';
            }
            break;

        case 'watering':
            // process_name: 'watering',
            // tbl_name: 'tbl_weighing',
            // ref_col: 'wg_imgref',
            // ref_val: imgRef,
            // upd_col: 'wg_water',
            // upd_val: parseFloat(inputValue)

            $wg_imgref = sanitize_input(get('ref_val'));
            $wg_water = sanitize_input(get('upd_val'));
            db_updatefloatrowbyref('tbl_weighing', 'wg_imgref', $wg_imgref, 2, 'wg_water', $wg_water, 1);
            break;

        case 'pricing':

            $wg_imgref = sanitize_input(get('ref_val'));
            $wg_price = sanitize_input(get('upd_val'));
            db_updatefloatrowbyref('tbl_weighing', 'wg_imgref', $wg_imgref, 2, 'wg_price', $wg_price, 1);
            break;

        default:
            die('Invalid this..! [' . $process_name . '] process');
            break;
    }
}
