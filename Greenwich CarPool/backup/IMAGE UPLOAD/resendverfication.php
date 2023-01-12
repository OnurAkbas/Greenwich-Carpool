<?php
include('/home/oa4933r/public_html/config/mysql.php');
ob_start();
$usernamee = $_COOKIE["user"];

$sql = "SELECT * FROM userinfo WHERE user = '$usernamee' ";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
$email = $row['email'];
$verificationcode = $row['verification'];

    $subject = 'Greenwich Car Pool | Verifcation Code';
    $message = " Hey, $usernamee \r\n" .'Thanks For Registering With Greenwich Car Pool' .  "\r\n\r\n" . 'Your Verfication Code is : ' . "$verificationcode \r\n\r\n" . 'http://stuweb.cms.gre.ac.uk/~oa4933r/verify.php' . "\r\n\r\n" . 'King Regards';
    $headers = 'From: noreply@gre.ac.uk' . "\r\n" .
    'Reply-To: oa4933r@gre.ac.uk' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
    mail($email, $subject, $message, $headers);
    header("Location: verify.php", true, 301);
    exit();
?>