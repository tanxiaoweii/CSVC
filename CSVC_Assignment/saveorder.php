<?php
session_start();

include('connection.php');
$memid = $_POST['id'];
$qty = $_POST['quantity'];
$name = $_POST['name'];
$transcode = $_POST['transcode'];
$id = isset($_POST['butadd']) ? $_POST['butadd'] : null; // Check if 'butadd' is set

// Ensure necessary values are provided before executing the query
if ($id && $qty && $name && $transcode) {
    $pprice = (int)$_REQUEST['price'];
    $pn = mysqli_real_escape_string($bd, $_REQUEST['name']);
    $total = $pprice * $qty;

    // Insert data into the database using mysqli
    $query = "INSERT INTO orderditems (customer, quantity, price, total, name, transactioncode) 
              VALUES ('$memid', '$qty', '$pprice', '$total', '$pn', '$transcode')";

    if (mysqli_query($bd, $query)) {
        header("location: order.php");
        exit();
    } else {
        die("Error: " . mysqli_error($bd)); // Display any query error
    }
} else {
    echo "Required data is missing. Please check your inputs.";
}
?>

