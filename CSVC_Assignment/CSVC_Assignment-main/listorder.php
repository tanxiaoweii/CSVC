<style type="text/css">
    .style1 {color: #FFFFFF}
</style>

<table width="249" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td width="189"><div align="left">&nbsp;&nbsp;&nbsp;&nbsp;Products</div></td>
    <td width="65">Price</td>
    <td width="50">Qty</td>
  </tr>

<?php
if (isset($_GET['id'])) {		   
    include('connection.php'); // Ensure database connection is included

    $id = $_GET['id'];
    
    // Use mysqli_query and mysqli_fetch_array with $bd connection
    $result3 = mysqli_query($bd, "SELECT * FROM orderditems WHERE transactioncode = '$id'");
    
    while ($row3 = mysqli_fetch_array($result3)) {  
        echo '<tr>';
        echo '<td><div align="left">&nbsp;&nbsp;&nbsp;&nbsp;' . htmlspecialchars($row3['name']) . '</div></td>';
        echo '<td>M' . htmlspecialchars($row3['price']) . '.00</td>';
        echo '<td>' . htmlspecialchars($row3['quantity']) . '</td>';
        echo '</tr>';
    }
}
?>
</table><br>

<?php
if (isset($_GET['id'])) {		   
    include('connection.php');

    $id = $_GET['id'];
    
    $result3 = mysqli_query($bd, "SELECT * FROM orderditems WHERE transactioncode = '$id'");
    $row3 = mysqli_fetch_array($result3);
    $var = $row3['customer'];

    // Fetch the member data
    $result4 = mysqli_query($bd, "SELECT * FROM members WHERE id = '$var'");
    $row4 = mysqli_fetch_array($result4);
}
?>
<br />

