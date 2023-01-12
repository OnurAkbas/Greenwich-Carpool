<?php
include('/home/oa4933r/public_html/config/mysql.php');
ob_start();
session_start();
$usernamee = $_SESSION["username"];


$sql = "SELECT * FROM userinfo WHERE user = '$usernamee' ";
if($result = mysqli_query($conn, $sql)){
    if(mysqli_num_rows($result) > 0){
        echo "<table>";
            echo "<tr>";
                echo "<th>email</th>";
                echo "<th>verification</th>";
            echo "</tr>";
        while($row = mysqli_fetch_array($result)){
            $email = $row['email'];
            $verificationcode = $row['verification'];
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['verification'] . "</td>";

            echo "</tr>";
        }
        echo "</table>";
        // Free result set
        mysqli_free_result($result);
    } else{
        echo "No records matching your query were found.";
    }
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
    $subject = 'Greenwich Car Pool | Verifcation Code';
    $message = " Hey, $usernamee \r\n" .'Thanks For Registering With Greenwich Car Pool' .  "\r\n\r\n" . 'Your Verfication Code is : ' . "$verificationcode \r\n\r\n" . 'http://stuweb.cms.gre.ac.uk/~oa4933r/verify.php' . "\r\n\r\n" . 'King Regards';
    $headers = 'From: noreply@gre.ac.uk' . "\r\n" .
    'Reply-To: oa4933r@gre.ac.uk' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
    mail($email, $subject, $message, $headers);
    header("Location: verify.php", true, 301);
    exit();
?>