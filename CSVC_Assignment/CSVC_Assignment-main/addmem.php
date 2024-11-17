<?php
session_start();

include('connection.php'); // Ensure this file sets up the $bd connection

$studentnum = mysqli_real_escape_string($bd, $_POST['studentnum']);
$name = mysqli_real_escape_string($bd, $_POST['name']);
$surname = mysqli_real_escape_string($bd, $_POST['surname']);
$contacts = mysqli_real_escape_string($bd, $_POST['contacts']);
$password = mysqli_real_escape_string($bd, $_POST['password']);
$email = mysqli_real_escape_string($bd, $_POST['email']);

// Prepare and execute the SQL query
$sql = "INSERT INTO members (studentnum, name, surname, contacts, password, email) VALUES ('$studentnum', '$name', '$surname', '$contacts', '$password', '$email')";
if (mysqli_query($bd, $sql)) {
    header("location: loginindex.php");
    exit();
} else {
    die("Could not connect: " . mysqli_error($bd)); // Updated error handling with mysqli
}

mysqli_close($bd); // Close the connection
?>

