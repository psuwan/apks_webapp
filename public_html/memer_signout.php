<?php

session_start(); // start session

// unset all session variables
// psuwan: set session to empty array();
$_SESSION = array();

// destroy the session
session_destroy();

// redirect to login page
header("Location: ./?page=home");
exit();
