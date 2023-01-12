<?php
include('/home/oa4933r/public_html/config/mysql.php');
ob_start();
$check = $_SESSION['carrycheck'];
sleep(2);


header("Location: dashboard.php", true, 301);
exit();
?>
          