<?php
// Start session
session_start();

// Connect to mysql server
include('connection.php');

// Error message array and flag
$errmsg_arr = array();
$errflag = false;

// Function to sanitize values to prevent SQL injection
function clean($str, $connection) {
    $str = @trim($str);
    if (get_magic_quotes_gpc()) {
        $str = stripslashes($str);
    }
    return mysqli_real_escape_string($connection, $str);
}

// Function to create a random password
function createRandomPassword() {
    $chars = "abcdefghijkmnopqrstuvwxyz023456789";
    srand((double)microtime() * 1000000);
    $i = 0;
    $pass = '';
    while ($i <= 7) {
        $num = rand() % 33;
        $tmp = substr($chars, $num, 1);
        $pass .= $tmp;
        $i++;
    }
    return $pass;
}

// Get the database connection from connection.php
global $bd; // Ensure $bd is available from connection.php

// Generate a confirmation code
$confirmation = createRandomPassword();

// Sanitize the POST values
$login = clean($_POST['user'], $bd);
$password = clean($_POST['password'], $bd);

// Create query
$qry = "SELECT * FROM members WHERE email='$login' AND password='$password'";
$result = mysqli_query($bd, $qry);

// Check whether the query was successful or not
if ($result) {
    if (mysqli_num_rows($result) > 0) {
        // Login successful
        session_regenerate_id();
        $member = mysqli_fetch_assoc($result);
        $_SESSION['SESS_MEMBER_ID'] = $member['id'];
        $_SESSION['SESS_FIRST_NAME'] = $confirmation;
        
        session_write_close();
        header("location: order.php");
        exit();
    } else {
        // Login failed
        $errmsg_arr[] = 'Invalid Email address or password';
        $errflag = true;
        if ($errflag) {
            $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
            session_write_close();
            header("location: loginindex.php");
            exit();
        }
    }
} else {
    die("Query failed: " . mysqli_error($bd));
}
?>

