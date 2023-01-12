<?php
include('/home/oa4933r/public_html/config/mysql.php');
ob_start();
session_start();
if(!isset($_COOKIE["user"]))
        {
    header("Location: login.php", true, 301);
    exit();  
}else{
        $usernamee = $_COOKIE["user"];
        $sql = "SELECT user FROM userinfo WHERE user = '$usernamee' and verifed = '0'";
        $result = mysqli_query($conn,$sql);
        if($result)
        {
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        $count = mysqli_num_rows($result);
            if($count == 1)
			{
                header("Location: verify.php", true, 301);
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
        if(!isset($_COOKIE["user"]))
        {
        ?><li><a href="Register.php">Register</a></li> 
          <li><a href="login.php">LOGIN</a></li>
          <?php
        }
        else ?>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="ReturnPost.php">Post</a></li>
        <li><a style="margin-right: 50px;" href="profile.php">Profile</a></li></ul><?php
        { ?><p>
         Welcome Back <b><?php echo $_COOKIE["user"]; ?> <a href="logout.php" >Logout</a> <?php
        }
        ?>
        </b></p>
      
    </div>
  </div>
    
</nav>
<div id="login" class="container-fluid text-center" >
<div class="jumbotron text-center" style="padding-bottom: 100px;">
    <?php 
    if(!isset($_SESSION["JourneyID"]))
    {
    header("Location: dashboard.php", true, 301);
    exit();   
    }
    else 
    {
    $journeyID = $_SESSION["JourneyID"];
   $sql = "SELECT * FROM comments WHERE id = '$journeyID' ";
   $result = mysqli_query($conn, $sql);
   $row = mysqli_fetch_array($result);
   
   $userinfoid = $row['username'];
        
   $sql1 = "SELECT * FROM userinfo WHERE user = '$userinfoid'";
   $result1 = mysqli_query($conn, $sql1);
   $row1 = mysqli_fetch_array($result1);
        
   if ($row1["pic"])
            {
            $profilepic = $row1["pic"];    
            }else
            {
            $profilepic = "";
            }     
        
    ?>
    <h1><?php echo $row['Start'] . " To " . $row['Destination'];   ?></h1>
    <p><?php echo $row['Service'];?></p>
    <?php } ?>
    <div>
    <fieldset>
    <legend>Journey Information</legend>
     
        <div> <h2>User Information</h2></div>
    <div>
    <label> Username : <?php echo "" . $row['username']; ?> </label> 
    </div>
        
    <div>
    <label> Contact Email : <?php echo "" . $row1['email']; ?> </label> 
        </div>
        
        <div>
        <?php if ($profilepic)
{
   ?> <img src="<?php echo $profilepic ?>" height="150" width="150"/> <?php
}else{
    
}?>
        </div>
        <div> <h2>Time And Date</h2></div>
    <div>
    <label>Date Of Journey: <?php echo " " . $row['Day'];?></label> <label><?php echo " YYYY-MM-DD";  ?></label>
        </div>
        <div>
    <label>Time Of Journey:<?php echo " " . $row['Time'];?></label>
    </div>
        
        <div> <h2>Car Information</h2></div>
    <div>
    <label>Seats Available : <?php echo " " . $row['seats'];?></label>
        </div>
        <div>
    <label>Car Model :<?php echo " " . $row['Car'];?></label>
    </div>
        <div>
    <label>Car Licence :<?php echo " " . $row['Licence'];?></label>
    </div>
        <div>
    <label>Car Insurance :<?php echo " " . $row['Insurance'];?></label>
    </div>
        <div>
    <label>Posted on :<?php echo " " . $row['date'];?></label>
    </div>
        
    </fieldset>
    
    <fieldset>
    <legend>Images About this Journey</legend>
     <div>
         
    <?php  
    $sql2 = "SELECT * FROM image WHERE PID = '$journeyID'";
    if($result2 = mysqli_query($conn, $sql2))
      {
          if(mysqli_num_rows($result2) > 0)
          { 
        while($row2 = mysqli_fetch_array($result2))
        {     
            ?> <img class="mySlides" src="<?php echo $row2['img_path']; ?>" style="width:25%">       <?php
        }    
    }
    }
   ?>   
    </div>   
    </fieldset>
    </div>
    
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
