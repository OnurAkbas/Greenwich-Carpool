<?php
include('/home/oa4933r/public_html/config/mysql.php');
ob_start();
session_start();
if(isset($_SESSION["username"]))
        {
        $usernamee = $_SESSION["username"];
        $sql = "SELECT user FROM userinfo WHERE user = '$usernamee' and verifed = '1'";
        $result = mysqli_query($conn,$sql);
        if($result)
        {
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        $count = mysqli_num_rows($result);
            if($count == 1)
			{
                header("Location: profile.php", true, 301);
                exit();
            }   
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
          
        <?php  // if logged in remove tabs and show username
        if(!isset($_SESSION["username"]))
        {
        ?><li><a href="Register.php">Register</a></li> 
          <li><a href="login.php">LOGIN</a></li>
          <?php
        }
        else
        { ?><p style="padding left=20px;">
         Welcome Back <b><?php echo $_SESSION["username"]; ?> <a href="logout.php" >Logout</a> <?php
        }
        ?>
        </b></p>
      </ul>
    </div>
  </div>
    
</nav>
<div id="login" class="container-fluid text-center">
<div class="jumbotron text-center">
  <h1>Greenwich Car Pool</h1>  
  <h2>Verify Your Account</h2>
  
  <form class="form-inline" method="post" >
      
    <div class="input-group">
    <div>
    <label style="padding-right: 7px"> Username Name :  </label>
    <div class="input-group" style="padding-bottom: 20px">
    <span class="input-group-addon" id="basic-addon1">@</span>
    <input style="padding-left: 15px" type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon1" name="Username" maxlength="12" value="<?php if(isset($_SESSION["username"]))
        {
        $usernamee = $_SESSION["username"];
        echo "$usernamee";
        }else { echo "";} ?>">
    </div>
    </div>
    <label style="padding-right: 10px"> Verfication Code: </label>
    <div class="input-group" style="padding-bottom: 20px">
    <input type="text" size="26" class="form-control"  placeholder="Verfication Code" aria-describedby="basic-addon1" name="verify" maxlength="16">
    </div>
		<h3>You can find your verifcation code, which is sent to your Email (Note: It can take up to 1-5 Mins).</h3>
    </div>
      <div class="input-group-btn" style="padding-top: 20px">
      <button id="btn1" name="btn1" class="btn btn-secondary" type="submit">Verify</button>
       
      </div>
      Didn't Receive Your Verfication Code?  <a style="color : red" href="resendverfication.php">Resend!</a>
    </form> 
    
    <h1> <?php   //mysql Verifcation System
        if(isset($_POST['Username']))
        {
        $username = $_POST['Username'];
        $verifyy = $_POST['verify'];
        $sql = "SELECT user FROM userinfo WHERE user = '$username' and verification = '$verifyy'";
        $result = mysqli_query($conn,$sql);
        if($result)
        {
            $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
            $count = mysqli_num_rows($result);
            if($count == 1)
			{
		        //now it will update their verfication
		        $sql = "UPDATE userinfo SET verifed='1' WHERE user = '$username'";
                mysqli_query($conn,$sql);
				
                    if ($conn->query($sql) === TRUE) 
                    {
                    $_SESSION["username"] = $username;
                    header("Location: verify.php", true, 301);
                    exit();
                    } 
                    else 
				    {
    			    echo "Error updating record: " . $conn->error;
				    }
                }
            }
        }
        ?></h1>
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