<?php

// Set timezone
date_default_timezone_set('Asia/Bangkok');

define('db_host', 'localhost');
define('db_user', 'username');
define('db_pass', 'password');
define('db_name', 'databasename');
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

function get_appname($tbl_name, $ref_col, $ref_val, $ref_type, $ret_col)
{
    $db_conn = db_connected();

    if ($ref_type == 1) {
        $sqlcmd = "SELECT * FROM $tbl_name WHERE $ref_col=$ref_val";
    } elseif ($ref_type == 2) {
        $sqlcmd = "SELECT * FROM $tbl_name WHERE $ref_col='$ref_val'";
    }
    $sqlres = mysqli_query($db_conn, $sqlcmd);

    if (!$sqlres) {
        die('Error..! query: ' . mysqli_error($db_conn));
    }

    $sqlfet = mysqli_fetch_assoc($sqlres);

    return $sqlfet[$ret_col];
}

function list_appname()
{
    $db_conn = db_connected();

    $sqlcmd_listapps = "SELECT * FROM tbl_applications WHERE 1";
    $stmt_listapps = mysqli_prepare($db_conn, $sqlcmd_listapps);

    if (!$stmt_listapps) {
        die('Error...');
    }

    mysqli_stmt_execute($stmt_listapps);
    $sqlres_listapps = mysqli_stmt_get_result($stmt_listapps);

    $data = array();
    while ($row = mysqli_fetch_assoc($sqlres_listapps)) {
        $data[] = $row;
    }

    mysqli_free_result($sqlres_listapps);
    mysqli_stmt_close($stmt_listapps);
    mysqli_close($db_conn);

    return $data;
}
