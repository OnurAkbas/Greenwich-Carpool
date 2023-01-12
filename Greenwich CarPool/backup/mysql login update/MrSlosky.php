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
<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#myPage">Greenwich Car Pool</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#about">About</a></li>
        <li><a href="#register">Register</a></li>
        <li><a href="#login">LOGIN</a></li>
      </ul>
    </div>
  </div>
</nav>
<div id="login" class="container-fluid text-center">
<div class="jumbotron text-center">
  <h1>Greenwich Car Pool</h1> 
  <p> Transporting around Greenwich was never this easy. </p> 
  <form class="form-inline">
      
    <div class="input-group">
        
    <div>
    <label style="padding-right: 7px"> Username  </label>
        
    <div class="input-group" style="padding-bottom: 20px">
    <span class="input-group-addon" id="basic-addon1">@</span>
    <input style="padding-left: 15px" type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon1" name="Username" maxlength="12">
    </div>
    </div>
        
    <label style="padding-right: 10px"> Password  </label>
        
    <div class="input-group" style="padding-bottom: 20px">
    <input type="password" size="26" class="form-control"  placeholder="Password" aria-describedby="basic-addon1" name="Password" maxlength="12">
    </div>
    </div>
      <div class="input-group-btn" style="padding-top: 20px">
      <button id="btn1" name="btn1" class="btn btn-danger" type="submit">Login Now</button>
      </div>
    </form> 
    
      

    <h1> <?php   //mysql Login System
        if(isset($_GET['Username']))
        {
        $conn = mysqli_connect("mysql","oa4933r","Mr213546879+","mdb_oa4933r");
        $username = $_GET['Username'];
        $password = $_GET['Password'];
        $sql = "SELECT user FROM userinfo WHERE user = '$username' and pass = '$password'";
        $result = mysqli_query($conn,$sql);
        if($result)
        {
           $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
            $count = mysqli_num_rows($result);
            if($count == 1)
            {
                echo "Login successful";
            }
            else
            {
                echo "Login failed.";
            }
        }
        }
        ?></h1>
    
    </div>
    </div>
  
    

<!-- Body Container for - About  Section -->
<div id="about" class="container-fluid bg-grey">
  <h2 class="text-center">About Greenwich Car Pool</h2>

         
</div>


<footer class="container-fluid text-center">
  <a href="#myPage" title="To Top">
    <span class="glyphicon glyphicon-chevron-up"></span>
  </a>
  <p>Greenwich Car Pool ¦ Onur & Co</p>
</footer>

<!-- Smooth Scroll Script -->
<script>
$(document).ready(function(){
  $(".navbar a, footer a[href='#myPage']").on('click', function(event) {
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
