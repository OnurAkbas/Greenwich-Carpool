<?php 
session_start();
session_destroy();
setcookie("user", "", time() + 3600, "/");
unset ($_COOKIE["user"]);
header('Location: login.php');
exit();
?>