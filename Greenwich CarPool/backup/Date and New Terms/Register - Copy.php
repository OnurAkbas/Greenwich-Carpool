<?php
include('/home/oa4933r/public_html/config/mysql.php');
ob_start();
session_start();
$_SESSION['error'] = "";
if(isset($_SESSION["username"]))
        {
        header("Location: verify.php", true, 301);
        exit();
        }

    if($_SERVER["REQUEST_METHOD"]== "POST")
    {
    $totalent = $_POST['Captcha'];
    $totalentint = (int)$totalent;
        
    $totalsum = $_SESSION['totalsum'];
    $totalint = (int)$totalsum;
    
    $username = mysqli_real_escape_string($conn,$_POST['Username']);
    $password = mysqli_real_escape_string($conn,$_POST['Password']);
    $encript = md5($password);
    $email = mysqli_real_escape_string($conn,$_POST['Email']);
       
    $validation = "SELECT user FROM userinfo WHERE user = '$username'";
    $validResult = mysqli_query($conn,$validation);
    $validCount = mysqli_num_rows($validResult);
       
    if ($validCount != 1)
    {
        if($totalint == $totalentint)
        {
		$password1 = $_POST['Password'];   
		$password2 = $_POST['PasswordConfirm'];
			if($password1 == $password2)
			{
				if ($_POST['cbconfirm'] == 'confirm')
            	{
				$randomnum = rand(10000,99999);
                $verificationcode = (int)$randomnum;
				$sql = "INSERT INTO userinfo (user, pass, email, verification) VALUES ('$username', '$encript' , '$email', ' $verificationcode' )";
                mysqli_query($conn,$sql);
                
                $subject = 'Greenwich Car Pool | Verifcation Code';
                $message = " Hey, $username \r\n" .'Thanks For Registering With Greenwich Car Pool' .  "\r\n\r\n" . 'Your Verfication Code is : ' . "$verificationcode \r\n\r\n" . 'http://stuweb.cms.gre.ac.uk/~oa4933r/verify.php' . "\r\n\r\n" . 'King Regards';
                $headers = 'From: noreply@gre.ac.uk' . "\r\n" .
                'Reply-To: oa4933r@gre.ac.uk' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
                mail($email, $subject, $message, $headers);
				$_SESSION["username"] = $username;
				header("Location: verify.php", true, 301);
                exit();
				} 
				else
				{
				$_SESSION['error'] = "Please Confirm The Terms And Conditions";  
				}
			}
            else
            {
			$_SESSION['error'] = "Your Password Doesn't Match";
            }
        }
        else
        {
        $_SESSION['error'] = "Captcha Incorrect, Are You A Robot?";
        }
    }
    else
    {
    $_SESSION['error'] =  "This username is already listed, Pick Another Username";
    }    
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Greenwich Pool | Main Page</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/css.css">
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Lato" >
  <script src="js/jquery-3.2.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  
</head>
<body id="Main" data-spy="scroll" data-target=".navbar" data-offset="60">

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <a class="navbar-brand" href="#Main">Greenwich Car Pool</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="Register.php">Register</a></li> 
        <li><a href="login.php">LOGIN</a></li>
      </ul>
    </div>
  </div>
    
</nav>
<div id="login" class="container-fluid text-center">
<div class="jumbotron text-center">
  <h1>Greenwich Car Pool</h1> 
  <p> Transporting around Greenwich was never this easy. </p>  
  <h2>Register Page</h2>
  <form class="form-inline" method="post" >
      
    <div class="input-group">
    <h5 style="padding-right: 70px"> Username  </h5>
    <div class="input-group" style="padding-bottom: 20px">
    <span class="input-group-addon" id="basic-addon1">@</span>
    <input style="padding-left: 15px" type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon1" name="Username" maxlength="12" pattern=".{4,12}" required title="4 to 12 characters" value="<?php echo isset($_POST['Username']) ? $_POST['Username'] : '' ?>">
    </div>
    
    <div>
    <h5 style="padding-right: 70px"> Password  </h5>
    <div class="input-group" style="padding-bottom: 20px">
    <input type="password" size="26" class="form-control"  placeholder="Password" aria-describedby="basic-addon1" name="Password" maxlength="16" pattern=".{8,16}" required title="8 to 16 characters" >
    </div>
    </div>
        
    <h5 style="padding-right: 10px"> Confirm Password  </h5>
    <div class="input-group" style="padding-bottom: 20px">
    <input type="password" size="26" class="form-control"  placeholder="Repeat Your Password" aria-describedby="basic-addon1" name="PasswordConfirm" maxlength="16" pattern=".{8,16}" required title="8 to 16 characters">
    </div>
        
    <div>
    <h5 style="padding-right: 100px">Email  </h5>
    <div class="input-group" style="padding-bottom: 20px">
    <input type="email" size="26" class="form-control"  placeholder="Email" aria-describedby="basic-addon1" name="Email" maxlength="30" required value="<?php echo isset($_POST['Email']) ? $_POST['Email'] : '' ?>">
    </div>
    </div>
        
    <div>
    <h5 style="padding-right: 80px">Captcha</h5>
    <div class="input-group" style="padding-bottom: 0px">
    <h5 style="padding-left: 0px"> <?php echo $num1 = rand(0,10)." + ".$num2 = rand(0,10)."?";
    $add = ($num1 + $num2);
    $_SESSION['totalsum'] = $add; 
    ?>
    </h5>   <h5 style="padding-right: 10px"> = </h5> 
    <input type="text" size="15" placeholder="Are you a Robot" id="Captcha" name="Captcha" maxlength="100" required> 
    </div>
    </div>
       
    <div class="input-group" style="padding-top:40px">
    <h5 style="max-width: 400px;">
    <input type="checkbox" class="form-check-input" name="cbconfirm" value="confirm">
      Please Tick the box, once you have agreeed to the <a href="terms.html" target="_blank">  Terms and Condition.</a>
    </h5>
    </div>
    </div>
      
      <div class="input-group-btn" style="padding-top: 20px">
      <button id="btnRegister" name="btnRegister" class="btn btn-secondary" type="submit">Register</button>
      </div>
      </form> 
    
    <?php
    $error = $_SESSION['error'];
    echo "$error";
    ?>
    </div>
    </div>
  
<!-- Body Container for - About  Section -->
<div id="about" class="container-fluid bg-grey">
  <h2 class="text-center">Review About Greenwich Car Pool</h2>

    <div id="myCarousel" class="carousel slide text-center" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
    <li data-target="#myCarousel" data-slide-to="3"></li>
    <li data-target="#myCarousel" data-slide-to="4"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <div class="item active">
    <h4>"You are a Genius!"<br><span style="font-style:normal;">Basil Yip, Student @ Greenwich</span></h4>
    </div>
    <div class="item">
      <h4>"Amazing Webiste With Amazing Rabbits"<br><span style="font-style:normal;">Sandesh, Student @ Greenwich</span></h4>
    </div>
    <div class="item">
      <h4>"A-Team has done it again."<br><span style="font-style:normal;">Kevin McManus, Program Leader</span></h4>
    </div>
     <div class="item">
      <h4>"Great Car Service"<br><span style="font-style:normal;">Pasha Kazmi, Student @ Greenwich</span></h4>
    </div>
    <div class="item">
      <h4>"Good Husband"<br><span style="font-style:normal;">Jahi, Professional @ Rock Climbing</span></h4>
    </div>
  </div>

  <!-- Left and right controls -->
  <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
         
</div>


<footer class="container-fluid text-center">
  <a href="#Main" title="To Top">
    <span class="glyphicon glyphicon-chevron-up"></span>
  </a>
  <p>Greenwich Car Pool ¦ Onur & Co</p>
</footer>

<!-- Smooth Scroll Script -->
<script>
$(document).ready(function(){
  $(".navbar a, footer a[href='#Main']").on('click', function(event) {
    if (this.hash !== "") {
      event.preventDefault();
        
      var hash = this.hash;

      $('html, body').animate({
        scrollTop: $(hash).offset().top
      }, 900, function(){
   
        window.location.hash = hash;
      });
    } 
  });
  
  $(window).scroll(function() {
    $(".slideanim").each(function(){
      var pos = $(this).offset().top;

      var winTop = $(window).scrollTop();
        if (pos < winTop + 600) {
          $(this).addClass("slide");
        }
    });
  });
})
</script> 

</body>
</html>