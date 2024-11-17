<?php
require_once('auth.php');
include('connection.php'); // Ensure the connection is established
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Wings Cafe</title>
<link href="css/ble.css" rel="stylesheet" type="text/css" />
<link href="css/main.css" rel="stylesheet" type="text/css" />
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
<link rel="stylesheet" href="./febe/style.css" type="text/css" media="screen" charset="utf-8">
<script src="argiepolicarpio.js" type="text/javascript" charset="utf-8"></script>
<script src="./js/application.js" type="text/javascript" charset="utf-8"></script>
<style type="text/css">
    .style1 {font-size: 16}
    a:link, a:visited, a:hover, a:active {
        text-decoration: none;
    }
</style>
</head>

<body>
<div style="width:900px; margin:0 auto; border:3px solid rgba(0,0,0,0); border-radius:5px; box-shadow:0 0 18px rgba(0,0,0,0.4); margin-top:10%;">
    <div style="background-color:#ff3300; height:40px; margin-bottom:10px;">
        <div style="float:right; width:50px; margin-right:20px; background-color:#cccccc; text-align:center;">
            <a href="home_admin.php">back</a>
        </div>
        <div style="float:left; margin-left:10px; margin-top:10px;">
            <strong>Welcome</strong> <?php echo $_SESSION['SESS_FIRST_NAME'];?>
        </div>
    </div>

    <label style="margin-left:12px;">Filter</label> 
    <input type="text" name="filter" value="" id="filter" />
    <br /><br />

    <table cellpadding="1" cellspacing="1" id="resultTable" border="1">
        <thead>
            <tr bgcolor="#cccccc" style="margin-bottom:10px;">
                <th>Student Num</th>
                <th>Amount Paid</th>
                <th>Code (click to view order)</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result3 = mysqli_query($bd, "SELECT * FROM wings_orders");
            while ($row3 = mysqli_fetch_array($result3)) {
                echo '<tr>';
                echo '<td>'.$row3['cusid'].'</td>';
                echo '<td>M'.$row3['total'].'.00</td>';
                echo '<td><a rel="facebox" href=listorder.php?id=' . $row3["transactioncode"] . '>' . $row3['transactioncode'].'</a></td>';
                echo '<td>'.$row3['transactiondate'].'</td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>

