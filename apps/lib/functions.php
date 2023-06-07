<?php

// Set timezone
date_default_timezone_set('Asia/Bangkok');

define('db_host', 'localhost');
define('db_user', 'apkssoft_grubber');
define('db_pass', '@dmin1234S');
define('db_name', 'apkssoft_grubber');
define('db_char', 'utf8mb4');

// Connected to database
function db_connected()
{
    $conn = mysqli_connect(db_host, db_user, db_pass, db_name);
    if ($conn === false) {
        die('Error..!' . mysqli_connect_error());
    }

    mysqli_set_charset($conn, db_char);
    return $conn;
}

// Function Insert 1 row with 2 column into table
function db_insertweighing($reference, $seller, $product, $wgval, $dt, $operator, $image)
{
    $db_conn = db_connected();

    $stmt = mysqli_stmt_init($db_conn);
    $sqlcmd = "INSERT INTO tbl_weighing (wg_reference, wg_seller, wg_product, wg_value, wg_created, wg_operator, wg_imgref) VALUES (?, ?, ?, ?, ?, ?, ?)";

    if (mysqli_stmt_prepare($stmt, $sqlcmd)) {
        mysqli_stmt_bind_param($stmt, "sssdsss", $reference, $seller, $product, $wgval, $dt, $operator, $image);

        mysqli_stmt_execute($stmt);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }
}

// Function Insert row into table
function db_insertref($tbl_name, $ref_column, $ref_value, $ref_type)
{
    $db_conn = db_connected();

    $stmt = mysqli_stmt_init($db_conn);
    $sqlcmd = "INSERT INTO $tbl_name ($ref_column) VALUES (?)";

    if (mysqli_stmt_prepare($stmt, $sqlcmd)) {
        switch ($ref_type) {
            case 1:
                mysqli_stmt_bind_param($stmt, "i", $ref_value);
                break;

            case 2:
                mysqli_stmt_bind_param($stmt, "s", $ref_value);
                break;

            default:
                echo "Invalid reference type";
                break;
        }

        mysqli_stmt_execute($stmt);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }
}

// Function update row by reference
function db_updaterowbyref($tbl_name, $ref_column, $ref_value, $ref_type, $upd_column, $upd_value, $upd_type)
{
    $db_conn = db_connected();

    $stmt = mysqli_stmt_init($db_conn);
    $sqlcmd = "UPDATE $tbl_name SET $upd_column = ? WHERE $ref_column = ?";

    if (mysqli_stmt_prepare($stmt, $sqlcmd)) {
        switch (($upd_type * 10) + $ref_type) {
            case 11:
                mysqli_stmt_bind_param($stmt, "ii", $upd_value, $ref_value);
                break;

            case 12:
                mysqli_stmt_bind_param($stmt, "is", $upd_value, $ref_value);
                break;

            case 21:
                mysqli_stmt_bind_param($stmt, "si", $upd_value, $ref_value);
                break;

            case 22:
                mysqli_stmt_bind_param($stmt, "ss", $upd_value, $ref_value);
                break;

            default:
                echo "Invalid reference type";
                break;
        }

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}
// Function update row by reference
function db_updatefloatrowbyref($tbl_name, $ref_column, $ref_value, $ref_type, $upd_column, $upd_value, $upd_type)
{
    $db_conn = db_connected();

    $stmt = mysqli_stmt_init($db_conn);
    $sqlcmd = "UPDATE $tbl_name SET $upd_column = ? WHERE $ref_column = ?";

    if (mysqli_stmt_prepare($stmt, $sqlcmd)) {
        switch (($upd_type * 10) + $ref_type) {
            case 11:
                mysqli_stmt_bind_param($stmt, "ii", $upd_value, $ref_value);
                break;

            case 12:
                mysqli_stmt_bind_param($stmt, "ds", $upd_value, $ref_value);
                break;

            case 21:
                mysqli_stmt_bind_param($stmt, "si", $upd_value, $ref_value);
                break;

            case 22:
                mysqli_stmt_bind_param($stmt, "ss", $upd_value, $ref_value);
                break;

            default:
                echo "Invalid reference type";
                break;
        }

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

// Function delete all row(s) by 2 references
function db_deleteallby2refs($tbl_name, $ref1_column, $ref1_value, $ref1_type, $ref2_column, $ref2_value, $ref2_type)
{
    $db_conn = db_connected();

    $stmt = mysqli_stmt_init($db_conn);
    $sqlcmd = "DELETE FROM $tbl_name WHERE $ref1_column = ? AND $ref2_column = ?";

    if (mysqli_stmt_prepare($stmt, $sqlcmd)) {
        switch (($ref1_type * 10) + $ref2_type) {
            case 11:
                mysqli_stmt_bind_param($stmt, "ii", $ref1_value, $ref2_value);
                break;

            case 12:
                mysqli_stmt_bind_param($stmt, "is", $ref1_value, $ref2_value);
                break;

            case 21:
                mysqli_stmt_bind_param($stmt, "si", $ref1_value, $ref2_value);
                break;

            case 22:
                mysqli_stmt_bind_param($stmt, "ss", $ref1_value, $ref2_value);
                break;

            default:
                die('Invalid reference type');
                break;
        }

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } else {
        log_write('function-error', 'db error', mysqli_stmt_error($stmt));
        die();
    }
}

// Function delete oldest row by 2 references and datetime column
function db_deleteoldestby2refs($tbl_name, $ref1_column, $ref1_value, $ref1_type, $ref2_column, $ref2_value, $ref2_type, $datetime_column)
{
    $db_conn = db_connected();

    $stmt = mysqli_stmt_init($db_conn);
    $sqlcmd = "DELETE FROM $tbl_name WHERE $ref1_column = ? AND $ref2_column = ? ORDER BY $datetime_column ASC LIMIT 1";

    if (mysqli_stmt_prepare($stmt, $sqlcmd)) {
        switch (($ref1_type * 10) + $ref2_type) {
            case 11:
                mysqli_stmt_bind_param($stmt, "ii", $ref1_value, $ref2_value);
                break;

            case 12:
                mysqli_stmt_bind_param($stmt, "is", $ref1_value, $ref2_value);
                break;

            case 21:
                mysqli_stmt_bind_param($stmt, "si", $ref1_value, $ref2_value);
                break;

            case 22:
                mysqli_stmt_bind_param($stmt, "ss", $ref1_value, $ref2_value);
                break;

            default:
                die('Invalid reference type');
                break;
        }

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } else {
        log_write('function-error', 'db error', mysqli_stmt_error($stmt));
        die();
    }
}


// Return counting number of row(s) by 1 reference
function db_cntrowby1ref($tbl_name, $ref_column, $ref_value, $ref_type)
{
    $db_conn = db_connected();

    $stmt = mysqli_stmt_init($db_conn);
    $sqlcmd = "SELECT COUNT(*) FROM $tbl_name WHERE $ref_column=?";

    if (mysqli_stmt_prepare($stmt, $sqlcmd)) {
        switch ($ref_type) {
            case 2:
                mysqli_stmt_bind_param($stmt, "s", $ref_value);
                break;
            case 1:
                mysqli_stmt_bind_param($stmt, "i", $ref_value);
                break;

            default:
                die('Invalid reference type');
                break;
        }

        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $count);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        return $count;
    }
}

// Return counting number of row(s) by 2 references
function db_cntrowby2refs($tbl_name, $ref1_column, $ref1_value, $ref1_type, $ref2_column, $ref2_value, $ref2_type)
{
    $db_conn = db_connected();

    $stmt = mysqli_stmt_init($db_conn);

    $sqlcmd = "SELECT COUNT(*) FROM $tbl_name WHERE $ref1_column=? AND $ref2_column=?";

    if (mysqli_stmt_prepare($stmt, $sqlcmd)) {
        switch (($ref1_type * 10) + $ref2_type) {
            case 22:
                mysqli_stmt_bind_param($stmt, "ss", $ref1_value, $ref2_value);
                break;
            case 21:
                mysqli_stmt_bind_param($stmt, "si", $ref1_value, $ref2_value);
                break;
            case 12:
                mysqli_stmt_bind_param($stmt, "is", $ref1_value, $ref2_value);
                break;
            case 11:
                mysqli_stmt_bind_param($stmt, "ii", $ref1_value, $ref2_value);
                break;

            default:
                die('Invalid reference type');
                break;
        }
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $count);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        return $count;
    }
}

// Function to get column data from database by 1 reference
function db_get1databy1ref($tbl_name, $ref_column, $ref_value, $ref_type, $ret_column)
{
    $db_conn = db_connected();

    $stmt = mysqli_stmt_init($db_conn);
    $sqlcmd = "SELECT * FROM $tbl_name WHERE $ref_column=?";

    if (mysqli_stmt_prepare($stmt, $sqlcmd)) {
        switch ($ref_type) {
            case 2:
                mysqli_stmt_bind_param($stmt, "s", $ref_value);
                break;
            case 1:
                mysqli_stmt_bind_param($stmt, "i", $ref_value);
                break;

            default:
                die('Invalid reference type');
                break;
        }

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $data = mysqli_fetch_assoc($result);

        mysqli_stmt_close($stmt);

        if ($data !== null) {
            return $data[$ret_column];
        } else {
            return null;
        }
        // return $data[$ret_column];
    }
}

// Function to get column data from database by 2 references
function db_get1databy2refs($tbl_name, $ref1_column, $ref1_value, $ref1_type, $ref2_column, $ref2_value, $ref2_type, $ret_column)
{
    $db_conn = db_connected();

    $stmt = mysqli_stmt_init($db_conn);
    $sqlcmd = "SELECT * FROM $tbl_name WHERE $ref1_column = ? AND $ref2_column = ?";

    if (mysqli_stmt_prepare($stmt, $sqlcmd)) {
        switch (($ref1_type * 10) + $ref2_type) {
            case 22:
                mysqli_stmt_bind_param($stmt, "ss", $ref1_value, $ref2_value);
                break;
            case 21:
                mysqli_stmt_bind_param($stmt, "si", $ref1_value, $ref2_value);
                break;
            case 12:
                mysqli_stmt_bind_param($stmt, "is", $ref1_value, $ref2_value);
                break;
            case 11:
                mysqli_stmt_bind_param($stmt, "ii", $ref1_value, $ref2_value);
                break;

            default:
                die('Invalid reference type');
                break;
        }

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $data = mysqli_fetch_assoc($result);

        mysqli_stmt_close($stmt);

        if ($data !== null) {
            return $data[$ret_column];
        } else {
            return null;
        }
    }
}


// Log(s) write to keep in text file
function log_write($event_app, $event_grp, $event_txt)
{    // get current date and time
    $timestamp = date('Y-m-d H:i:s');

    // create log object
    $logObject = array(
        "log_time" => $timestamp,
        "log_cate" => $event_grp,
        "log_text" => $event_txt
    );

    // create logs folder if it doesn't exist
    if (!is_dir('logs')) {
        mkdir('logs');
    }

    // generate file name
    $logFile = 'logs' . DIRECTORY_SEPARATOR . $event_app . '-' . date('Y-m-d') . ".json";

    // check if file exists
    $fileExists = file_exists($logFile);

    // read existing logs from file
    $logs = $fileExists ? json_decode(file_get_contents($logFile), true) : array();

    // append new log object to array
    $logs[] = $logObject;

    // encode logs array to JSON
    $json = json_encode($logs, JSON_PRETTY_PRINT);

    // write JSON string to file
    file_put_contents($logFile, $json);

    // append comma and newline if file exists and is not empty
    if ($fileExists && filesize($logFile) > 0) {
        $lastChar = substr($json, -1);
        if ($lastChar != "]") {
            file_put_contents($logFile, "," . PHP_EOL, FILE_APPEND);
        }
    }
}

// Function to sanitize and validate input
function sanitize_input($input)
{
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    // Add additional validation here if needed
    return $input;
}

// Function to generate Token by input of length
function generated_token($length)
{
    $token = '';
    $characters = '';
    $characters .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $characters .= 'abcdefghijklmnopqrstuvwxyz';
    $characters .= '0123456789';

    for ($i = 0; $i < $length; $i++) {
        $rand_pos = random_int(0, strlen($characters) - 1);
        $token .= substr($characters, $rand_pos, 1);
    }

    return $token;
}

// Function to separate user data
function user_data($data_to_return, $user_signin_role)
{
    // $user_application . $user_division . $user_userlevel . $user_reference
    switch ($data_to_return) {
        case 'user_application':
            return substr($user_signin_role, 0, 14);
            break;

        case 'user_division':
            return substr($user_signin_role, 14, 4);
            break;

        case 'user_level':
            return substr($user_signin_role, 18, 2);
            break;

        case 'user_reference':
            return substr($user_signin_role, 20, 14);
            break;

        default:
            die('Invalid return data');
            break;
    }
}

// function to check existing files in specific folder related to reference 
function file_exist($file_reference, $file_folder)
{
    // echo $file_folder;
    // echo '<br>';
    $baseDir = dirname(__FILE__) . DIRECTORY_SEPARATOR;
    $base2Remove = dirname(dirname($baseDir));
    $baseDir = '';
    // echo $baseDir . '<br>';
    $folder2Scan = $baseDir . $file_folder;
    // echo $refNumber . '<br>';

    if (!empty($file_reference)) {
        $files2 = glob($folder2Scan . $file_reference . "*");

        if ($files2) {
            $filecount = count($files2);
            for ($iFiles2 = 0; $iFiles2 < $filecount; ++$iFiles2) {
                // $tmpGenID4DelIcon = explode(".", str_replace($baseDir . $file_folder . DIRECTORY_SEPARATOR, '', $files2[$iFiles2]));
                // $genID4DelIcon = $tmpGenID4DelIcon[0];
                // echo $base2Remove . '<br>';
                // echo $files2[$iFiles2] . '<br>';
                $path_to_img = str_replace($base2Remove, '', $files2[$iFiles2]);
                // echo $path_to_img . '<br>';
                // echo "&nbsp;<a href=\"file-delete.php?file2Delete=" . $path_to_img . "\" onclick=\"return confirm('Want to delete this file')\">";
                // echo "<i class=\"bi bi-x-circle text-danger\"></i>";
                // echo "</a>";
                // echo '&nbsp;';

                // Allow file extension
                // "pdf", "doc", "docx", "xls", "xlsx", "jpg", "png", "jpeg", "ppt", "pptx", "ods"
                // $extension = pathinfo(str_replace($baseDir, '', $folder2Scan) . str_replace($folder2Scan, '', $files2[$iFiles2]), PATHINFO_EXTENSION);

                echo "<a class=\"btn btn-sm btn-round btn-warning\" href=\""  . $path_to_img . "\"target=\"_blank\" style=\"font-size:10px!important;\">";
                // echo "file(s) " . ($iFiles2 + 1) . "->[" . $extension . "]";
                echo 'img';
                echo "</a>";
                echo '&nbsp;';
            }
        } else {
            echo "<p style=\"font-size:10px!important;\">[ No file(s) ]</p>";
        }
    } else {
        echo "<p style=\"font-size:10px!important;\">[ No reference ]</p>";
    }
}

function file_image_resize($file_image)
{

    $input = $file_image; // Name of input

    $maxDim = 400;
    foreach ($_FILES[$input]['tmp_name'] as $file_name) {
        list($width, $height, $type, $attr) = getimagesize($file_name);
        if ($width > $maxDim || $height > $maxDim) {
            $target_filename = $file_name;
            $ratio = $width / $height;
            if ($ratio > 1) {
                $new_width = $maxDim;
                $new_height = $maxDim / $ratio;
            } else {
                $new_width = $maxDim * $ratio;
                $new_height = $maxDim;
            }
            $src = imagecreatefromstring(file_get_contents($file_name));
            $dst = imagecreatetruecolor($new_width, $new_height);
            imagecopyresampled($dst, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
            imagedestroy($src);
            imagepng($dst, $target_filename); // adjust format as needed
            imagedestroy($dst);
        }
    }
}

// function to delete file
function file_deleted($file_to_delete)
{
    $vg_file2Delete = filter_input(INPUT_GET, "file2Delete");
    $vg_prjRefNumber = filter_input(INPUT_GET, "projRefnumber");

    unlink($vg_file2Delete);
    if (file_exists($vg_file2Delete)) {
        echo "<script>alert(\"ลบไฟล์ไม่สำเร็จ\")</script>";
        echo "<script>window.location.href=\"expense-add.php?reference_number=" . $vg_prjRefNumber . "\"</script>";
    } else {
        echo "<script>alert(\"ลบไฟล์แล้ว\")</script>";
        echo "<script>window.location.href=\"expense-add.php?reference_number=" . $vg_prjRefNumber . "\"</script>";
    }
}


// function send line notification
function send_line_notify($message, $line_noti_token)
{
    // $token      = $line_noti_token;
    // $url        = 'https://notify-api.line.me/api/notify';
    // $headers    = [
    //     'Content-Type: application/x-www-form-urlencoded',
    //     'Authorization: Bearer ' . $token
    // ];
    // $fields     = "$message";

    // $ch = curl_init();
    // curl_setopt($ch, CURLOPT_URL, $url);
    // curl_setopt($ch, CURLOPT_POST, 1);
    // curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // $result = curl_exec($ch);
    // curl_close($ch);

    // var_dump($result);
    // $result = json_decode($result, TRUE);
    $sMessage = $message;
    // $sMessage = '&#3607;&#3604;&#3626;&#3629;&#3610;&#3626;&#3656;&#3591;&#3588;&#3656;&#3634;&#3629;&#3640;&#3603;&#3627;&#3616;&#3641;&#3617;&#3636;';
    $chOne = curl_init();
    curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
    curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($chOne, CURLOPT_POST, 1);
    curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=" . $sMessage);
    $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $line_noti_token . '',);
    curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($chOne);
    //Result error
    if (curl_error($chOne)) {
        echo 'error:' . curl_error($chOne);
    } else {
        $result_ = json_decode($result, true);
        echo "status : " . $result_['status'];
        echo "message : " . $result_['message'];
    }
    curl_close($chOne);
}

// ================================================================== //
// Note: Important function for mys MVC (with out OOP)
function get($name, $default = '')
{
    return isset($_REQUEST[$name]) ? $_REQUEST[$name] : $default;
}
