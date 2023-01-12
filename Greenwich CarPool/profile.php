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
  <h1>Greenwich Car Pool</h1> 
  <p> Transporting around Greenwich was never this easy. </p> 
    <?php 
    if(!isset($_SESSION["ViewUser"]))
    {
     ?>
  <h2>Profile Page</h2> 
    <?php
    }
    else
    {
        ?>   <h2>Viewing Profile</h2> 
    <a href="unset.php"> Back To Profile </a> <?php
      } 
?>
    <form class="form-inline" method="post">
    <div class="input-group">
     <?php 
    if(!isset($_SESSION["ViewUser"]))
    {
     ?>
    <p>
    <label>Username : <?php echo $_COOKIE["user"];  ?></label>
    </p>   <?php 
        }else{
    ?>
        <p>
    <label>Username : <?php echo $_SESSION["ViewUser"];  ?></label>
    </p> 
       
        <?php
     }
        
        if(!isset($_SESSION["ViewUser"]))
        {  
        $usernamee = $_COOKIE["user"];
        
        $sqll = "SELECT * FROM userinfo WHERE user = '$usernamee'";
        $result = mysqli_query($conn,$sqll);
        if($result)
        {
            $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
            $id = $row["id"];
            if ($row["pic"])
            {
            $profilepic = $row["pic"];    
            }else
            {
            $profilepic = "http://keithmackay.com/images/picture.jpg";
            }  
        }
        ?>
        
        <div>
     <img src="<?php echo $profilepic ?>" height="300" width="300"/>
        </div> 
        
        <div>
        <label> Please Enter The URL OF YOUR NEW PROFILE PIC</label>
            </div>
        <div>
     <input type="text" size="50" class="form-control"  placeholder="www.myprofilepic.com/blabla.jpg" aria-describedby="basic-addon1" name="text" maxlength="200" required>    
       </div>
        
        <div>
         <button id="btn1" value="btn1" class="btn btn-secondary" name='btn_submit' type="submit">Upload Image</button>
        </div>
          </div> 
        </form>
    </div>
    </div>
    
    <?php
    if(isset($_POST['text']))
        {
        $sql = "SELECT * FROM userinfo WHERE user = '$usernamee'";
        $result = mysqli_query($conn,$sql);
        if($result)
        {
            $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
            $count = mysqli_num_rows($result);
            if($count == 1)
			{
		        //it will check if url is an image.
                $urlimage = $_POST['text'];  
                if (!preg_match('/(\.jpg|\.png|\.gif)$/i', $urlimage)) {
                echo "we can't procced as the following is not an image or not supported (JPG/PNG/GIF)";
                return;
                } 
  
		        $sql = "UPDATE userinfo SET pic='$urlimage' WHERE user = '$usernamee'";
                mysqli_query($conn,$sql);
				
                    if ($conn->query($sql) === TRUE) 
                    {
                    header("Location: profile.php", true, 301);
                    exit();
                    } 
                    else 
				    {
    			    echo "Error updating record: " . $conn->error;
				    }
                }else{
             echo "<h3>" . "Their was an error updating your profile picture." . "</h3>";
            }
            }
            
    }
        }else
        {
        $usernamee = $_SESSION["ViewUser"];
        
        $sqll = "SELECT * FROM userinfo WHERE user = '$usernamee'";
        $result = mysqli_query($conn,$sqll);
        if($result)
        {
            $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
            $id = $row["id"];
            
            if ($row["pic"])
            {
            $profilepic = $row["pic"];    
            }else
            {
            $profilepic = "http://keithmackay.com/images/picture.jpg";
            }
        }
        
        $filename = 'ProfileImages/' . $id . '.jpg';
        
        if (file_exists($filename)) {
        $imageid = $id;
        } else {
        $imageid = "default";
        }
        
        ?>
        <div>
     <img src="ProfileImages/<?php echo $imageid ?>.jpg" height="150" width="150"/>
     <img src="<?php echo $profilepic ?>" height="150" width="150"/>
        </div> 
    </div>
          </div> 
        </form>
    </div>
    </div> <?php
    }         ?>
  
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
