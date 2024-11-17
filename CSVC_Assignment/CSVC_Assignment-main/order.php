<?php
session_start();
require_once('auth.php');
include('connection.php'); // Ensure this file sets up the $bd connection
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Wings Cafe</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="src/facebox.css" media="screen" rel="stylesheet" type="text/css" />
<script src="lib/jquery.js" type="text/javascript"></script>
<script src="src/facebox.js" type="text/javascript"></script>
<script type="text/javascript">
    jQuery(document).ready(function($) {
      $('a[rel*=facebox]').facebox({
        loadingImage : 'src/loading.gif',
        closeImage   : 'src/closelabel.png'
      })
    })
</script>
<script type="text/javascript">
function validateForm() {
    var a=document.forms["abcd"]["num"].value;
    if (a==null || a=="") {
      alert("you must enter your student #");
      return false;
    }
    if (document.abcd.checkbox.checked == false) {
      alert ('pls. agree to the terms and conditions');
      return false;
    }
    return true;
}
</script>
</head>
<body onLoad="ShowTime()">
<div id="container">
  <div id="header_section">
    <div style="float:right; margin-right:30px;">
      <?php 
      $id = $_SESSION['SESS_MEMBER_ID'];
      $resulta = mysqli_query($bd, "SELECT * FROM members WHERE id = '$id'");
      while ($row = mysqli_fetch_array($resulta)) {
          echo $row['name'] .' '. $row['surname'];
      }
      ?>
      &nbsp;<a href="logout.php" id="logout-button">Logout</a>
    </div> 
  </div>
  <div id="menu_bg">
    <div id="menu">
      <ul>
        <div style="float:left">
          <input name="time" type="text" id="txt" readonly style="border: 0; font-size: 25px; height: 23px; width: 130px; background-color:#000; color:#F00;" />
        </div> 
      </ul>
    </div>
  </div>
  <div id="header"></div>
  <div id="content">
    <div id="content_left">
      <div class="text">Select From Menu Below</div>
      <div class="view1">
        <?php
        $result2 = mysqli_query($bd, "SELECT * FROM products");
        while ($row2 = mysqli_fetch_array($result2)) {
          $id = $row2['id'];
          $result3 = mysqli_query($bd, "SELECT * FROM products WHERE product_id='$id'");
          $row3 = mysqli_fetch_array($result3);
          echo '<div class="box"> <a rel="facebox" href=portal.php?id=' . $row3["product_id"] . '><img src="images/bgr/'.$row3['product_photo'].'" width="75px" height="75px" /></a>';
          echo '<div class="textbox"> '.$row3['name'].' </div>';
          echo '</div>';
        }
        ?>
      </div>
    </div>
    <div id="content_right">
      <form method="post" action="confirm.php" name="abcd" onsubmit="return validateForm()">
        <input name="id" type="hidden" value="<?php echo $_SESSION['SESS_MEMBER_ID']; ?>" />
        <input name="transactioncode" type="hidden" value="<?php echo $_SESSION['SESS_FIRST_NAME']; ?>" />
        <h2>Order Details</h2>
        <table width="335" border="1" cellpadding="0" cellspacing="0">
          <tr>
            <td><strong>Product Name</strong></td>
            <td><strong>Qty</strong></td>
            <td><strong>Price</strong></td>
            <td><strong>Total</strong></td>
            <td><strong>Del</strong></td>
          </tr>
          <?php
          $memid = $_SESSION['SESS_FIRST_NAME'];
          $resulta = mysqli_query($bd, "SELECT * FROM orderditems WHERE transactioncode = '$memid'");
          while ($row = mysqli_fetch_array($resulta)) {
            echo '<tr>';
            echo '<td>' . $row['name'] . '</td>';
            echo '<td>' . $row['quantity'] . '</td>';
            echo '<td>' . $row['price'] . '</td>';
            echo '<td>' . $row['total'] . '</td>';
            echo '<td><a href=deleteorder.php?id=' . $row["id"] . '>Cancel</a></td>';
            echo '</tr>';
          }
          ?>
          <tr>
            <td colspan="4">Grand Total:</td>
            <td>
              <?php
              $result = mysqli_query($bd, "SELECT SUM(total) FROM orderditems WHERE transactioncode = '$memid'");
              while ($rows = mysqli_fetch_array($result)) { 
                echo '<input name="total" type="text" size="10" value="'.$rows['SUM(total)'].'"/>'; 
              }
              ?>
            </td>
          </tr>
        </table>
        <p>
          <label>Student Num:</label>
          <input type="text" name="num">
          <label><input type="checkbox" name="checkbox" value="checkbox"> I Agree The <a rel="facebox" href="terms.php">Terms and Condition</a></label>
        </p>
        <input type="submit" value="Confirm Order" />
      </form>
    </div>
    <div id="card"></div>
  </div>
  <div id="container_end"></div>	
</div>
<div id="footer">
  <div class="middle">Copyright © Wings Cafe 2013</div>
</div>
</body>
</html>

