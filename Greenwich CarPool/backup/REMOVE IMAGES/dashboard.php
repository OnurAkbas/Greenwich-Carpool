<?php

if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off"){
    $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $redirect);
    exit();
}

include('/home/oa4933r/public_html/config/mysql.php');
ob_start();
session_start();
if(isset($_COOKIE["user"]))
        {
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
<div id="login" class="container-fluid text-center">
<div class="jumbotron text-center" style="margin-bottom: -60px;">
  <h1>Greenwich Car Pool</h1> 
  <p> Transporting around Greenwich was never this easy. </p>  
  </div></div>
    
  <form method="post">
  <div class="container-fluid text-center">
  <div class="jumbotron text-center" style="margin-bottom: 60px;">
  <h2>Dashboard Page</h2>
  <label for="comment"><?php echo "Hey! " . $_COOKIE["user"] . ","; ?> </label>
  <label for="comment">You Can Post to Provide or Obtain a lift! </label>
  <css-1> 
      <div>
    <legend> Search/Filter Bar</legend>
      <div><label>Filter</label>
     <select name="FormResults">
         <?php 
         if (isset($_SESSION['formStatus']) && $_SESSION['formStatus'] == "true")
         {
         ?>
         <option selected value="True">On</option>
         <option value="False">Off</option>
         <?php } else { ?>
        <option  value="True">On</option>
         <option selected value="False">Off</option>
        <?php } ?></select>
    <label> Filter </label>
    <select name="FormFilter">
          <option value="">Select a Filter</option>
          <?php 
         if (isset($_SESSION['formFilter']) && $_SESSION['formFilter'] == "Destination")
         {
         ?> 
          <option selected value="Destination">Destination</option>
          <option value="Start">Starting Locaiton</option>
          <option value="User">User</option>
          <option value="Cost">Cost</option>
        <?php }elseif (isset($_SESSION['formFilter']) && $_SESSION['formFilter'] == "Start") { ?>
         <option value="Destination">Destination</option>
          <option selected value="Start">Starting Locaiton</option>
          <option value="User">User</option>
          <option value="Cost">Cost</option>       
         <?php }elseif (isset($_SESSION['formFilter']) && $_SESSION['formFilter'] == "User") { ?>
        <option value="Destination">Destination</option>
          <option value="Start">Starting Locaiton</option>
          <option selected value="User">User</option>
          <option value="Cost">Cost</option>
        <?php }elseif (isset($_SESSION['formFilter']) && $_SESSION['formFilter'] == "Cost") { ?>
        <option value="Destination">Destination</option>
          <option value="Start">Starting Locaiton</option>
          <option value="User">User</option>
          <option selected value="Cost">Cost</option>
        <?php }else { ?>
          <option value="Destination">Destination</option>
          <option value="Start">Starting Locaiton</option>
          <option value="User">User</option>
          <option value="Cost">Cost</option>
        <?php } ?>
          </select>
    </div>
          
     <div> 
         <label>Filter Text</label>
         <input type="text" size="25" name="txtboxFilter">
         
         </div>
          
    <button id="btn7" value="Button 7" class="btn btn-warning" name='btn_submit' type="submit">Update Results!</button>
          
      </div>
      
      <legend> Table Results</legend>
      
      
      <?php
      if (isset($_SESSION['formStatus']) && $_SESSION['formStatus'] == "true")
      {
        $searching = $_SESSION['searchFilter'];
        if (isset($_SESSION['formFilter']) && $_SESSION['formFilter'] == "Destination")
        {
        $sql = "SELECT * FROM comments WHERE Destination LIKE '%$searching%';";
        }else if (isset($_SESSION['formFilter']) && $_SESSION['formFilter'] == "Start")
        {
        $sql = "SELECT * FROM comments WHERE Start LIKE '%$searching%';";
        } else if (isset($_SESSION['formFilter']) && $_SESSION['formFilter'] == "User")
        {
        $sql = "SELECT * FROM comments WHERE username LIKE '%$searching%';";
        } else if (isset($_SESSION['formFilter']) && $_SESSION['formFilter'] == "Cost")
        {
        $sql = "SELECT * FROM comments WHERE Cost LIKE '%$searching%';";
        }  
      }
      else
      {
      $result = mysqli_query($conn, "SELECT * FROM comments");
      $num_rows = mysqli_num_rows($result);
      
      if($num_rows >=0 && $num_rows <=10) {
         $_SESSION["page"] = 1;
      }
      if($num_rows >=10 && $num_rows <=20) {
         $_SESSION["page"] = 2;
      }
      if($num_rows >=20 && $num_rows <=30) {
         $_SESSION["page"] = 3;  
      }
      if($num_rows >=30 && $num_rows <=40) {
         $_SESSION["page"] = 4;
      }
      if($num_rows >=40 && $num_rows <=50) {
         $_SESSION["page"] = 5;
      } 
      
      if(!isset($_SESSION["pageactive"]))
      {
      $_SESSION["pageactive"] = "1";
      }
      
      if ($_SESSION["pageactive"] == "1")
      {
      $sql = "SELECT * FROM comments ORDER BY id DESC LIMIT 0, 10;";    
      }
      if ($_SESSION["pageactive"] == "2")
      {
      $sql = "SELECT * FROM comments ORDER BY id DESC LIMIT 10, 10;";    
      }
      if ($_SESSION["pageactive"] == "3")
      {
      $sql = "SELECT * FROM comments ORDER BY id DESC LIMIT 20, 10;";    
      }
      if ($_SESSION["pageactive"] == "4")
      {
      $sql = "SELECT * FROM comments ORDER BY id DESC LIMIT 30, 10;";    
      }
      if ($_SESSION["pageactive"] == "5")
      {
      $sql = "SELECT * FROM comments ORDER BY id DESC LIMIT 40, 10;";    
      }
      }
      if($result = mysqli_query($conn, $sql))
      {
          if(mysqli_num_rows($result) > 0)
          { ?>
      <table>
          <tr> 
              <th>ID</th>
              <th>Name</th>
              <th>From</th>
              <th>Destination</th>
              <th>Service</th>
              <th>Date </th>
              <th>Time</th>
              <th>Seats</th>
              <th>Cost</th>
              <th></th>
              <th></th>
              <th></th>
          </tr><?php
        while($row = mysqli_fetch_array($result))
        {     
            echo "<td><taid>" . $row['id'] . "</taid></td>";
            echo "<td><ta>" . $row['username'] . "</ta></td>";
            echo "<td><ta>" . $row['Start'] . "</ta></td>";
            echo "<td><ta>" . $row['Destination'] . "</ta></td>";
            echo "<td><ta>" . $row['Service'] . "</ta></td>";
            echo "<td><ta>" . $row['Day'] . "</ta></td>";
            echo "<td><ta>" . $row['Time'] . "</ta></td>";
            echo "<td><ta>" . $row['seats'] . "</ta></td>";
            
            if ($row['Cost'] == "£" || $row['Cost'] == "") 
            {
            echo "<td><ta>" . "Free" . "</ta></td>";
            }else
            {
             echo "<td><ta>" . $row['Cost'] . " per person" . "</ta></td>";    
            }
            
            $user = $row['username'];   
            $takeid = $row['id'];
                
            if ($user != $usernamee)
            {  ?>
          <td> <ta> <button id="btn6" value="Button 6 <?php echo $takeid; ?>" class="btn btn-info" name='btn_submit' type="submit">View Journey</button></ta></td>
          <td> <ta> <button id="btn5" value="Button 5 <?php echo $takeid; ?>" class="btn btn-info" name='btn_submit' type="submit">View Profile!
              </button>   </ta></td>
                    <?php
            }else{
            ?>
          <td> <ta> <button id="btn6" value="Button 6 <?php echo $takeid; ?>" class="btn btn-info" name='btn_submit' type="submit">View Journey</button></ta></td>
          <td> <ta> <button id="btn2" value="Button 2 <?php echo $takeid; ?>" class="btn btn-warning" name='btn_submit' type="submit">Edit Comment!</button></ta></td>
          <td> <ta> <button id="btn3" value="Button 3 <?php echo $takeid; ?>" class="btn btn-danger" name='btn_submit' type="submit">Delete Comment!</button></ta></td>
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
      </table>
      <div class="pagination">
      <?php
      $checkpage = $_SESSION["page"];
      if ($checkpage == "1")
      {
        
          ?>
          <a class="active" href="<?php echo "pagesellect.php?activepage=1" ?>">1</a>
          <?php
      }
      else if ($checkpage == "2")////////////////////////////////////////////////////////////////////////////////
      {
          if ($_SESSION["pageactive"] == "1")
          { 
          ?>
          <a class="active" href="<?php echo "pagesellect.php?activepage=1" ?>">1</a>
          <a href="<?php echo "pagesellect.php?activepage=2" ?>">2</a> 
          <a href="<?php echo "pagesellect.php?activepage=2" ?>">&raquo;</a> 
          <?php
          }
          else
          { 
          ?>
          <a href="<?php echo "pagesellect.php?activepage=1" ?>">&laquo;</a>
          <a href="<?php echo "pagesellect.php?activepage=1" ?>">1</a>
          <a class="active" href="<?php echo "pagesellect.php?activepage=2" ?>">2</a>
          <?php
          } 
      }
      else if ($checkpage == "3")////////////////////////////////////////////////////////////////////////////////
      {
          if ($_SESSION["pageactive"] == "1")
          { ?>
          <a class="active" href="<?php echo "pagesellect.php?activepage=1" ?>">1</a>
          <a href="<?php echo "pagesellect.php?activepage=2" ?>">2</a>
          <a href="<?php echo "pagesellect.php?activepage=3" ?>">3</a>
          <a href="<?php echo "pagesellect.php?activepage=2" ?>">&raquo;</a> 
          <?php
          }
          else if ($_SESSION["pageactive"] == "2")
          { 
          ?>
          <a href="<?php echo "pagesellect.php?activepage=1" ?>">&laquo;</a>
          <a href="<?php echo "pagesellect.php?activepage=1" ?>">1</a>
          <a class="active" href="<?php echo "pagesellect.php?activepage=2" ?>">2</a>
          <a href="<?php echo "pagesellect.php?activepage=3" ?>">3</a>
          <a href="<?php echo "pagesellect.php?activepage=3" ?>">&raquo;</a> 
          <?php
          } 
          else
          { 
          ?>
          <a href="<?php echo "pagesellect.php?activepage=2" ?>">&laquo;</a>
          <a href="<?php echo "pagesellect.php?activepage=1" ?>">1</a>
          <a href="<?php echo "pagesellect.php?activepage=2" ?>">2</a>
          <a class="active" href="<?php echo "pagesellect.php?activepage=3" ?>">3</a> 
          <?php
          } 
      }
      else if ($checkpage == "4")/////////////////////////////////////////////////////////////////////////////////////
      { 
          if ($_SESSION["pageactive"] == "1")
          { 
          ?>
          <a class="active" href="<?php echo "pagesellect.php?activepage=1" ?>">1</a>
          <a href="<?php echo "pagesellect.php?activepage=2" ?>">2</a>
          <a href="<?php echo "pagesellect.php?activepage=3" ?>">3</a>
          <a href="<?php echo "pagesellect.php?activepage=4" ?>">4</a>
          <a href="<?php echo "pagesellect.php?activepage=2" ?>">&raquo;</a> 
          <?php
          }
          else if ($_SESSION["pageactive"] == "2")
          { 
          ?>
          <a href="<?php echo "pagesellect.php?activepage=1" ?>">&laquo;</a>
          <a href="<?php echo "pagesellect.php?activepage=1" ?>">1</a>
          <a class="active" href="<?php echo "pagesellect.php?activepage=2" ?>">2</a>
          <a href="<?php echo "pagesellect.php?activepage=3" ?>">3</a>
          <a href="<?php echo "pagesellect.php?activepage=4" ?>">4</a>
          <a href="<?php echo "pagesellect.php?activepage=3" ?>">&raquo;</a> 
          <?php
          } 
          else if ($_SESSION["pageactive"] == "3")
          { 
          ?>
          <a href="<?php echo "pagesellect.php?activepage=2" ?>">&laquo;</a>
          <a href="<?php echo "pagesellect.php?activepage=1" ?>">1</a>
          <a href="<?php echo "pagesellect.php?activepage=2" ?>">2</a>
          <a class="active" href="<?php echo "pagesellect.php?activepage=3" ?>">3</a>
          <a href="<?php echo "pagesellect.php?activepage=4" ?>">4</a>
          <a href="<?php echo "pagesellect.php?activepage=4" ?>">&raquo;</a> 
          <?php
          } 
          else
          { 
          ?>
          <a href="<?php echo "pagesellect.php?activepage=3" ?>">&laquo;</a>
          <a href="<?php echo "pagesellect.php?activepage=1" ?>">1</a>
          <a href="<?php echo "pagesellect.php?activepage=2" ?>">2</a>
          <a href="<?php echo "pagesellect.php?activepage=3" ?>">3</a>
          <a class="active" href="<?php echo "pagesellect.php?activepage=4" ?>">4</a>
          <?php
          } 
      }
      else if ($checkpage == "5") ////////////////////////////////////////////////////////////////////////////////////////
      { 
          if ($_SESSION["pageactive"] == "1")
          { 
          ?>
          <a class="active" href="<?php echo "pagesellect.php?activepage=1" ?>">1</a>
          <a href="<?php echo "pagesellect.php?activepage=2" ?>">2</a>
          <a href="<?php echo "pagesellect.php?activepage=3" ?>">3</a>
          <a href="<?php echo "pagesellect.php?activepage=4" ?>">4</a>
          <a href="<?php echo "pagesellect.php?activepage=5" ?>">5</a>
          <a href="<?php echo "pagesellect.php?activepage=2" ?>">&raquo;</a> 
          <?php
          }
          else if ($_SESSION["pageactive"] == "2")
          { 
          ?>
          <a href="<?php echo "pagesellect.php?activepage=1" ?>">&laquo;</a>
          <a href="<?php echo "pagesellect.php?activepage=1" ?>">1</a>
          <a class="active" href="<?php echo "pagesellect.php?activepage=2" ?>">2</a>
          <a href="<?php echo "pagesellect.php?activepage=3" ?>">3</a>
          <a href="<?php echo "pagesellect.php?activepage=4" ?>">4</a>
          <a href="<?php echo "pagesellect.php?activepage=5" ?>">5</a>
          <a href="<?php echo "pagesellect.php?activepage=3" ?>">&raquo;</a> 
          <?php
          } 
          else if ($_SESSION["pageactive"] == "3")
          { 
          ?>
          <a href="<?php echo "pagesellect.php?activepage=2" ?>">&laquo;</a>
          <a href="<?php echo "pagesellect.php?activepage=1" ?>">1</a>
          <a href="<?php echo "pagesellect.php?activepage=2" ?>">2</a>
          <a class="active" href="<?php echo "pagesellect.php?activepage=3" ?>">3</a>
          <a href="<?php echo "pagesellect.php?activepage=4" ?>">4</a>
          <a href="<?php echo "pagesellect.php?activepage=5" ?>">5</a>
          <a href="<?php echo "pagesellect.php?activepage=4" ?>">&raquo;</a> 
          <?php
          } 
          else if ($_SESSION["pageactive"] == "4")
          { 
          ?>
          <a href="<?php echo "pagesellect.php?activepage=3" ?>">&laquo;</a>
          <a href="<?php echo "pagesellect.php?activepage=1" ?>">1</a>
          <a href="<?php echo "pagesellect.php?activepage=2" ?>">2</a>
          <a href="<?php echo "pagesellect.php?activepage=3" ?>">3</a>
          <a class="active" href="<?php echo "pagesellect.php?activepage=4" ?>">4</a>
          <a href="<?php echo "pagesellect.php?activepage=5" ?>">5</a>
          <a href="<?php echo "pagesellect.php?activepage=5" ?>">&raquo;</a> 
          <?php
          }
          else
          { ?>
          
          <a href="<?php echo "pagesellect.php?activepage=4" ?>">&laquo;</a>
          <a href="<?php echo "pagesellect.php?activepage=1" ?>">1</a>
          <a href="<?php echo "pagesellect.php?activepage=2" ?>">2</a>
          <a href="<?php echo "pagesellect.php?activepage=3" ?>">3</a>
          <a href="<?php echo "pagesellect.php?activepage=4" ?>">4</a>
          <a class="active" href="<?php echo "pagesellect.php?activepage=5" ?>">5</a>  <?php
          }
    }   ?>
  </div>     
  </css-1>
  </div>
  </div>
  </form>
      
    <?php
    if (isset($_POST['btn_submit']) && $_POST['btn_submit'] == 'Button 7')
    {
        if($_POST['FormResults'] == 'True')
        {
        $_SESSION['formStatus'] = "true";
        
        $filtersearch = $_POST['txtboxFilter'];
        $filtersearch = stripslashes($filtersearch);
        $_SESSION['searchFilter'] = $filtersearch;
            
            if($_POST['FormFilter'] == 'Destination')
            {
            $_SESSION['formFilter'] = "Destination";  
            }
            else if ($_POST['FormFilter'] == 'Start')
            {
             $_SESSION['formFilter'] = "Start";    
            }
            else if ($_POST['FormFilter'] == 'User')
            {
             $_SESSION['formFilter'] = "User";    
            }
            else if ($_POST['FormFilter'] == 'Cost')
            {
             $_SESSION['formFilter'] = "Cost";    
            }else{
             $_SESSION['formFilter'] = "";    
            }
        }
        else
        {
        $_SESSION['formFilter'] = "";
        $_SESSION['formStatus'] = "false";    
        }  
    header("Location: dashboard.php", true, 301);
    exit();
    
}
    
    
   if (isset($_POST['btn_submit']) && $_POST['btn_submit'] == 'Button 1')
   {
          $usernamee = $_COOKIE["user"]; 
          $comment = $_POST['comment']; 
          $comment = stripslashes($comment);
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
      $_SESSION["editid"] = $check;
      header("Location: Post.php", true, 301);
      exit();
          
      }else{}
    
      if (isset($_POST['btn_submit']) && (substr($_POST['btn_submit'],0,8)=="Button 3"))
      {
      $check = substr($_REQUEST['btn_submit'],8,15);
      $_SESSION['carrycheck'] = $check;
      $path = "ProfileImages/";
      $dirr = "$path"."$check";
      $dir = str_replace(' ', '', $dirr);
          
        foreach(glob("{$dir}/*") as $file)
        {
            if(is_dir($file)) { 
                recursiveRemoveDirectory($file);
            } else {
                unlink($file);
            }
        }
          
          if (file_exists($dir))
          {
          rmdir($dir);    
          }
          else{  
          }
          
          $sql ="DELETE FROM comments WHERE id='$check'";
          mysqli_query($conn,$sql);
          
          ?> <script>
        if (alert("Also delete the pictures on the database")) { </script>
        <?php 
          $sql ="DELETE FROM image WHERE PID ='$check'";
          mysqli_query($conn,$sql); ?> <script>
        } else {
        }
        </script> <?php 
        header("Location: dashboard.php", true, 301);
        exit();  
      }
          
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
    
     if (isset($_POST['btn_submit']) && (substr($_POST['btn_submit'],0,8)=="Button 5")) //// FOCUS HERE
      {
      $check = substr($_REQUEST['btn_submit'],8,11);
          
      $sql = "SELECT * FROM comments WHERE id = '$check' ";
      $result = mysqli_query($conn, $sql);
      $row = mysqli_fetch_array($result);
      $_SESSION["ViewUser"] = $row['username'];
      header("Location: profile.php", true, 301);
      exit();
          
      }else{}
    
    if (isset($_POST['btn_submit']) && (substr($_POST['btn_submit'],0,8)=="Button 6")) //// FOCUS HERE
      {
      $_SESSION["JourneyID"] = substr($_REQUEST['btn_submit'],8,11);
      header("Location: Journey.php", true, 301);
      exit();
          
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
    <li data-target="#myCarousel" data-slide-to="5"></li>
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
      <h4>"A team stuff"<br><span style="font-style:normal;">Ralph, CEO @ Greenwich</span></h4>
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