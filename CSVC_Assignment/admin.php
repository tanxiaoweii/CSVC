<?php
session_start();

include("connection.php"); // Make sure this file establishes a $bd connection

// Sanitize the POST values
$id = mysqli_real_escape_string($bd, $_POST['email']);
$password = mysqli_real_escape_string($bd, $_POST['password']);

// Create and execute the query
$sql = "SELECT * FROM users WHERE email = '$id' AND password = '$password'";
$result = mysqli_query($bd, $sql);

// Check the result
$count = mysqli_num_rows($result);
if ($count == 1) {
    // Login successful
    session_regenerate_id();
    $member = mysqli_fetch_assoc($result);
    $_SESSION['SESS_MEMBER_ID'] = $member['id'];
    $_SESSION['SESS_FIRST_NAME'] = $member['username'];
    session_write_close();
    header("location: home_admin.php");
    exit();
} else {
    echo "<h4 style='color:red;'>Please enter your correct login details!!!</h4>";
    die(mysqli_error($bd)); // Use mysqli_error for error handling
}
?>

