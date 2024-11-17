<?php
include 'get-parameters.php'; // Include file with database connection parameters

$prefix = "";

// Establish a connection using mysqli
$bd = mysqli_connect($mysql_hostname, $mysql_user, $mysql_password, $mysql_database);

// Check the connection
if (!$bd) {
    die("Could not connect to the database: " . mysqli_connect_error());
}

?>

