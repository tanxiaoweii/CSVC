<?php 
require_once('auth.php');
include('connection.php'); // Ensure connection is established

// Fetch total and transaction code from the previous form submission
$total = $_POST['total'] ?? null;
$transactioncode = $_POST['transactioncode'] ?? null;
$student = $_POST['num'] ?? null;

// Display hidden form fields for total and transaction code
?>
<form method="post" action="">
    <input name="transactioncode" type="hidden" value="<?php echo htmlspecialchars($transactioncode); ?>" />
    <input name="total" type="hidden" value="<?php echo htmlspecialchars($total); ?>" />
</form>

<?php
// Check if required POST data is available
if (!$total || !$transactioncode || !$student) {
    echo "Required data is missing. Please go back and ensure all fields are filled.";
    exit;
}

// Get the current date for the transaction
$transactiondate = date("m/d/Y");

// Check if the student number exists in the members table
$data = mysqli_query($bd, "SELECT * FROM members WHERE studentnum = '$student'") or die(mysqli_error($bd));
$info = mysqli_fetch_assoc($data);

if (!$info) {
    echo "Wrong student number.";
    exit;
}

// Insert order details into wings_orders table
$stud = $info['studentnum'];
$insertQuery = "INSERT INTO wings_orders (cusid, total, transactiondate, transactioncode) 
                VALUES ('$stud', '$total', '$transactiondate', '$transactioncode')";

if (mysqli_query($bd, $insertQuery)) {
    echo "Order successfully confirmed.";
} else {
    die("Error inserting order: " . mysqli_error($bd));
}
?>

<a rel="facebox" href="order.php"><img src="images/28.png" width="75px" height="75px" /></a>

