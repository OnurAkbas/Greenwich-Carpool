<?php
include('/home/oa4933r/public_html/config/mysql.php');
ob_start();
session_start();
if(isset($_SESSION["username"]))
        {
        $usernamee = $_SESSION["username"];
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
}else{
 header("Location: login.php", true, 301);
 exit();   
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Greenwich Pool | Main Page</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="Onur Akbas">
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
        else ?>
        <li><a href="dashboard.php">Dashboard</a></li> 
        <li><a style="margin-right: 50px;" href="profile.php">Profile</a></li><?php
        { ?><p>
         Welcome Back <b><?php echo $_SESSION["username"]; ?> <a href="logout.php" >Logout</a> <?php
        }
        ?>
        </b></p>
      </ul>
    </div>
  </div>
    
</nav>
<div id="login" class="container-fluid text-center">
<div class="jumbotron text-center" style="margin-bottom: -60px;">
  <h1>Greenwich Car Pool</h1> 
  <p> Transporting around Greenwich was never this easy. </p>  
  
  </div></div>
    
  <form action="" method="post">
  <div id="comment" class="container-fluid text-center">
  <div class="jumbotron text-center" style="margin-bottom: 60px;">
  <h2>Dashboard Page</h2>
  <css-1> 
  
  <label for="comment"><?php echo "Hey! " . $_SESSION["username"] . ","; ?> </label>
  <label for="comment">Leave a comment on your recent Journey:</label>
    <?php
   if (isset($_SESSION['editing']) && $_SESSION['editing'] == 1)
    {
      $check = $_SESSION["editid"];
      $sql = "SELECT * FROM comments WHERE id = '$check' ";
      $result = mysqli_query($conn, $sql);
      $row = mysqli_fetch_array($result);
      $comment = $row['comment'];
      ?>   
   <textarea class="form-control" rows="1" cols="100"id="comment" name="comment" maxlength="100"> <?php echo $comment ?> </textarea>
   <button style="margin-left: 1100px;" id="btn4" value="Button 4" class="btn btn-warning" for="comment" name='btn_submit' type="submit">EDIT!</button>
   <?php }else { ?>
   <textarea class="form-control" rows="1" cols="100"id="comment" name="comment" maxlength="100"></textarea>
   <button style="margin-left: 1100px;" id="btn1" value="Button 1" class="btn btn-success" for="comment" name='btn_submit' type="submit">Submit!</button> 
   <?php }
   ?>
      <?php
      $sql = "SELECT * FROM comments ORDER BY id DESC LIMIT 15; ";
      if($result = mysqli_query($conn, $sql))
      {
          if(mysqli_num_rows($result) > 0)
          { ?>
      <table>
          <tr> 
              <tatop>
              <th>ID</th>
              <th>Name</th>
              <th>Comments</th>
              <th></th>
              <th></th>
              </tatop>
          </tr>  <?php
        while($row = mysqli_fetch_array($result))
        {     
            echo "<td><taid>" . $row['id'] . "</taid></td>";
            echo "<td><ta>" . $row['username'] . "</ta></td>";   
            echo "<td><ta>" . $row['comment'] . "</ta></td>";
                
            $user = $row['username'];   
            $takeid = $row['id'];
                
            if ($user != $usernamee)
            {  
                
            }else{
            ?>
          <td> <ta> <button id="btn2" value="Button 2 <?php echo $row['id'] ?>" class="btn btn-warning" name='btn_submit' type="submit">Edit Comment!</button></ta></td>
          <td> <ta> <button id="btn3" value="Button 3 <?php echo $row['id'] ?>" class="btn btn-danger" name='btn_submit' type="submit">Delete Comment!</button></ta></td>
            <?php 
            }
            echo "</tr>";
        }
        echo "</table>";
        // Free result set
        mysqli_free_result($result);
          } else{
         }
      } else{ 
          echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
      }
      ?>

  </css-1> <P style="margin-bottom: 500px;"> </P>
  </div>
  </div>
  </form>
      <?php

   if (isset($_POST['btn_submit']) && $_POST['btn_submit'] == 'Button 1')
   {
          $usernamee = $_SESSION["username"]; 
          $comment = $_POST['comment']; 
          $date = date("d-m-y");
          
          if($comment == "")
          { ?>
    <script> 
    alert("Please Enter Something into the Textarea before submiting!");
    </script> 
    <?php
    }
    else
    {
    $sql = "INSERT INTO comments (username, comment, date) VALUES ('$usernamee', '$comment' , '$date')";
    mysqli_query($conn,$sql);
    header("Location: dashboard.php", true, 301);
    exit();
    }
}
      if (isset($_POST['btn_submit']) && (substr($_POST['btn_submit'],0,8)=="Button 2"))
      {
      $check = substr($_REQUEST['btn_submit'],8,11);
          
      $sql = "SELECT * FROM comments WHERE id = '$check' ";
      $result = mysqli_query($conn, $sql);
      $row = mysqli_fetch_array($result);
      $comment = $row['comment'];
      $_SESSION["editing"] = 1;
      $_SESSION["editid"] = $check;
      header("Location: dashboard.php", true, 301);
      exit();
          
      }else{}

      if (isset($_POST['btn_submit']) && (substr($_POST['btn_submit'],0,8)=="Button 3"))
      {
      $check = substr($_REQUEST['btn_submit'],8,11);
      $sql = "DELETE FROM comments WHERE id='$check'";
      mysqli_query($conn,$sql);
      header("Location: dashboard.php", true, 301);
      exit(); 
      }else{}
      
      if (isset($_POST['btn_submit']) && (substr($_POST['btn_submit'],0,8)=="Button 4"))
      {
          $comment = $_POST['comment']; 
          $date = date("d-m-y");
          
          if($comment == "")
          { ?>
            <script> 
            alert("Please Enter Something into the Textarea before Editing!");
            </script> 
            <?php
            }
            else
            {
            $sql = "UPDATE comments SET comment='$comment' WHERE id = '$check'";
            mysqli_query($conn,$sql);
				
            if ($conn->query($sql) === TRUE) 
            {
            $_SESSION["editing"] = 0;
            header("Location: dashboard.php", true, 301);
            exit();
             } 
             else 
			 {
    		echo "Error updating record: " . $conn->error;
            }
    header("Location: dashboard.php", true, 301);
    exit();
    }
                 
      }else{}
?>
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
