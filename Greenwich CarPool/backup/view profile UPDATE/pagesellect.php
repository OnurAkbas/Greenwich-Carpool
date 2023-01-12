<?php
session_start();
$_SESSION["pageactive"] = $_GET["activepage"];
header("Location: dashboard.php", true, 301);
exit();
?>