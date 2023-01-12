<?php 
session_start();
session_destroy();
header('Location: Post.php');
exit();
?>