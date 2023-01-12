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
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Lato">
        <script src="js/jquery-3.2.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>

    </head>

    <body id="Main" data-spy="scroll" data-target=".navbar" data-offset="60">

        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="login.php">Greenwich Car Pool</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav navbar-right">

                        <?php  // if logged in remove tabs and show username
        if(!isset($_COOKIE["user"]))
        {
        ?>
                        <li><a href="Register.php">Register</a></li>
                        <li><a href="login.php">LOGIN</a></li>
                        <?php
        }
        else ?> 
       <li><a href="dashboard.php">Dashboard</a></li>
       <li><a href="ReturnPost.php">Post</a></li>
       <li><a style="margin-right: 50px;" href="profile.php">Profile</a></li>
       </ul>
        <?php
        { ?>
        <p>
        Welcome Back <b><?php echo $_COOKIE["user"]; ?> <a href="logout.php" >Logout</a> <?php
        }
        ?>
        </b></p>

                </div>
            </div>

        </nav>
        <div id="login" class="container-fluid text-center">
            <div class="jumbotron text-center" style="padding-bottom: 100px;">
                <h1>Greenwich Car Pool</h1>
                <p> Transporting around Greenwich was never this easy. </p>
                
                <?php
                if(isset($_SESSION["editid"]))
                {
                    $check = $_SESSION["editid"];
                    $sql = "SELECT * FROM comments WHERE id = '$check' ";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_array($result);
                    echo "<h2>Edit a Commute Journey</h2>";
                    echo "You are Currently Editing a Commute Journey ID : " , $row['id']; ?> <a href="ReturnPost.php" >Click here to return to Post.</a> <?php
                }
                else
                {
                echo "<h2>Post a Commute Journey</h2>";
                }
                ?>
                <form class="form-inline" method="post" enctype="multipart/form-data">
                    <div class="input-group">
                        <fieldset style="margin-top: 100pxs">
                            <legend>Location From - To</legend>
                        <div>
                            <label>Location Start:</label>
                            <select name="formTo">
                                
                            <?php
                
                                if(!isset($_SESSION["editid"]))
                                { ?>    
                            <option value="">Select...</option>
                            <?php } else{ ?> 
                            <option value="<?php echo $row['Start'] ;?>"><?php echo $row['Start'] ;?></option>    
                             <?php   }  ?>
                            <option value="Greenwich">Greenwich</option>
                            <option value="Hackney">Hackney</option>
                            </select>
                        </div>
                        <div>
                            <label>Location Towards:</label>
                            <select name="formFrom">
                            <?php
                
                                if(!isset($_SESSION["editid"]))
                                { ?>    
                            <option value="">Select...</option>
                            <?php } else{ ?> 
                            <option value="<?php echo $row['Destination'] ;?>"><?php echo $row['Destination'] ;?></option>    
                             <?php   }  ?>
                            <option value="Greenwich">Greenwich</option>
                            <option value="Hackney">Hackney</option>
                            </select>
                        </div>
                        </fieldset>
                        
                         <fieldset>
                             <legend>Service you are Requesting</legend>
                        <div>
                            <label>Service :</label>
                            <select name="formService">
                                <?php
                                if(!isset($_SESSION["editid"]))
                                { ?>
                            <option value="">Select...</option>
                                <?php } else{ ?> 
                            <option value="<?php echo $row['Service']; ?>"><?php echo $row['Service']; ?></option>
                            <?php   }  ?>
                            <option value="Provide a Lift">Provide a Lift</option>
                            <option value="Obtain a Lift">Obtain a Lift</option>
                            </select>
                        </div>
                        </fieldset>
                        <fieldset>
                        <legend>Time Of Travel</legend>
                        <div>
                        <label>Date for Commute Journey:</label>
                        <?php
                                if(!isset($_SESSION["editid"]))
                                { ?>
                        <input type="date" name="date">
                            <?php } else { ?>
                            <input type="date" name="date" id="setDate">        
                            <script>
                                    document.getElementById("setDate").value = "<?php echo $row['Day']; ?>";
                            </script> 
                            <?php  }  ?>
                        </div>
                        <div>
                         <label>Time for Commute Journey:</label>
                             <?php
                                if(!isset($_SESSION["editid"]))
                                { ?>
                            <input type="time" name="time">
                            <?php } else { ?>
                            <input type="time" name="time" id="setTime">
                            <script>
                                    document.getElementById("setTime").value = "<?php echo $row['Time']; ?>";
                            </script> 
                             <?php  }  ?>
                        </div>
                        </fieldset>
                        <fieldset>
                            <legend>Car & Insurance </legend>
                         <div>
                         <label>Car Model:</label>
                             <?php
                                if(!isset($_SESSION["editid"]))
                                { ?>
                             <input type="text" name="car">
                             <?php } else { ?>
                             <input type="text" name="car" id="setCar" >
                             <script>
                                    document.getElementById("setCar").value = "<?php echo $row['Car']; ?>";
                            </script> 
                            <?php } ?>
                        </div>
                        <div>
                         <label>Licence Type:</label>
                        <select name="formLicence">
                            <?php
                                if(!isset($_SESSION["editid"]))
                                {  ?>
                             <option value="">Select...</option> <?php
                                }else { ?>
                                    <option value="<?php echo $row['Licence']; ?>"><?php echo $row['Licence']; ?></option>    
                                    <?php } ?>
                            <option value="Full UK">Full UK</option>
                            <option value="Automatic Licence UK">Automatic Licence UK</option>
                            <option value="Licence EU">Licence EU</option>
                            <option value="Other">Other</option>
                            <option value="None">None</option>
                            </select>
                        </div>
                        <div>
                         <label>Insurance:</label>
                        <select name="formInsurance">
                            <?php
                                if(!isset($_SESSION["editid"]))
                                {  ?>
                            <option value="">Select...</option>
                            <?php } else { ?>
                               <option value="<?php echo $row['Insurance']; ?>"><?php echo $row['Insurance']; ?></option>     
                            <?php } ?> 
                            <option value="Fully Comprehensive">Fully Comprehensive</option>
                            <option value="Third Party Fire and theft Cover">Third Party Fire and theft Cover</option>
                            <option value="Third Party Cover">Third Party Cover</option>
                            <option value="None">None</option>
                            </select>
                        </div>
                            </fieldset>
                        
                        <fieldset>
                            <div>
                            <label>Seats:</label>
                            <select name="formSeats">
                                 <?php
                                if(!isset($_SESSION["editid"]))
                                {  ?>
                            <option value="">Select...</option>
                                <?php }else { ?>
                            <option value="<?php echo $row['seats']; ?>"><?php echo $row['seats']; ?></option>   
                            <?php  } ?>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            </select>
                            </div>
                            <legend>Payments and Seats!</legend>
                         <div>
                             
                         <label>Journey Cost / Willing to Pay:</label>
                             <?php
                                if(!isset($_SESSION["editid"]))
                                {  ?> 
                        <input type="text" size="5" name="cost" value="£">
                             <?php } else { ?>
                             <input type="text" size="5" name="cost" value="£" id="setCost">
                             <script>
                                    document.getElementById("setCost").value = "<?php echo $row['Cost']; ?>";
                            </script> 
                              <?php  } ?>
                             <label>/Per Person</label>
                        </div>                            
                            </fieldset>
                        
                        <fieldset>
                             <legend>Extra comments..</legend>
                        <div>
                            <label>Description :</label>
                             <?php
                                if(!isset($_SESSION["editid"]))
                                {  ?> 
                            <input type="area" size="30" name="comment">
                            <?php }else { ?>
                                <input type="area" size="30" name="comment" id="setComment">    
                            <script>
                                    document.getElementById("setComment").value = "<?php echo $row['comment']; ?>";
                            </script> 
                            <?php  }  ?>                             
                        </div>            
                        </fieldset>
                        
                        <fieldset>
                        <legend>Upload Image</legend>
                        <div>
                        <input type="file" name="file_img[]" multiple />
                        <?php
                        if(isset($_SESSION["editid"]))
                         { ?>
                           <button id="btn5" value="Button 5" class="btn btn-danger" name='btn_submit' type="submit">Upload</button> 
                        <?php }
                        ?></div>
                        <legend></legend>
                        <div id="keepimage">
                        <?php
                        if(isset($_SESSION["editid"]))
                         {
        $journeyID = $row['id'];
                            
        $sql = "SELECT * FROM image WHERE PID = '$journeyID'";
                            
        if($result = mysqli_query($conn, $sql))
        {
        
          if(mysqli_num_rows($result) > 0)
          { ?>
      <table>
          <tr> 
              <th>ID</th>
              <th>Name</th>
              <th>Image</th>
              <th>Delete</th>
          </tr><?php
        while($row = mysqli_fetch_array($result))
        {     
            ?> <tr> <?php 
            echo "<td><taid>" . $row['ID'] . "</taid></td>";
            echo "<td><ta>" . $row['img_name'] . "</ta></td>";
            
            $takeid = $row['ID'];
          ?> <td><ta> <img src="<?php echo $row['img_path']; ?>" style="width:45%;"> </ta></td>
            <td> <ta> <button id="btn4" value="Button 4 <?php echo $takeid; ?>" class="btn btn-danger" name='btn_submit' type="submit">Delete Comment!</button></ta></td>
            </tr> <?php
        }}
        ?></table> <?php
        }
                        } ?>
                            </div>
                        </fieldset>
                        
                        <fieldset>
                           <?php
                                if(!isset($_SESSION["editid"]))
                                {  ?>  
                        <legend> Submit, You can edit or delete after! </legend>
                        <button id="btn1" value="Button 1" class="btn btn-success" name='btn_submit' type="submit">Submit!</button> 
                            <?php }else { ?>
                         <legend> Edit, Delete! You can edit </legend>
                        <button id="btn2" value="Button 2" class="btn btn-warning" name='btn_submit' type="submit">Update Content!</button>
                        <button id="btn3" value="Button 3" class="btn btn-danger" name='btn_submit' type="submit">Delete Content!</button>
                             <?php   } ?>
                        </fieldset>
                    </div>
                </form>
            </div>
        </div>
        
        <?php 
        
   if (isset($_POST['btn_submit']) && $_POST['btn_submit'] == 'Button 5')
   {
       
   }
        
   if (isset($_POST['btn_submit']) && (substr($_POST['btn_submit'],0,8)=="Button 4"))
   {
       $check = substr($_REQUEST['btn_submit'],8,11);
       $sql = "DELETE FROM image WHERE ID='$check'";
      mysqli_query($conn,$sql);
      header("Location: Post.php", true, 301);
      exit(); 
   }
        
        
   if (isset($_POST['btn_submit']) && $_POST['btn_submit'] == 'Button 1')
   {
          $usernamee = $_COOKIE["user"]; 
          $comment = $_POST['comment'];
          $Formto = $_POST['formTo'];
          $FormFrom = $_POST['formFrom'];
          $Service = $_POST['formService'];
          $dateJourney = $_POST['date'];
          $timeJourney = $_POST['time'];
          $car = $_POST['car'];
          $Licence = $_POST['formLicence'];
          $insurance = $_POST['formInsurance'];
          $cost = $_POST['cost'];
          $seats = $_POST['formSeats'];
          $comment = stripslashes($comment);
          $date = date("d-m-y");
     $sql = "INSERT INTO comments (username, comment, Start, Destination, Service, Day, Time, seats, Cost, Car, Licence, Insurance, date) VALUES ('$usernamee', '$comment', '$Formto', '$FormFrom', '$Service', '$dateJourney', '$timeJourney', '$seats', '$cost', '$car', '$Licence', '$insurance', '$date')";
        
    mysqli_query($conn,$sql);
        
    $result = mysqli_query($conn, "select * from comments order by id desc limit 1;");
    $findID = mysqli_fetch_array($result);
    $PostID = $findID['id'];
    
    if (!file_exists('ProfileImages/'.$PostID)) {
    mkdir('ProfileImages/'.$PostID, 0777, true);
    }
       
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
      
    for($i = 0; $i < count($_FILES['file_img']['name']); $i++)
	{
        
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
        }
        
        $usernamee = $_COOKIE["user"];
		$filetmp = $_FILES["file_img"]["tmp_name"][$i];
		$filename = $_FILES["file_img"]["name"][$i];
		$filetype = $_FILES["file_img"]["type"][$i];
		$filepath = "ProfileImages/".$PostID."/".$filename;
	
	move_uploaded_file($filetmp,$filepath);
	
	$sql = "INSERT INTO image (PID, username, img_name,img_path,img_type) VALUES ('$PostID','$usernamee','$filename','$filepath','$filetype')";
	$result = mysqli_query($conn,$sql);
	}   
       
    header("Location: dashboard.php", true, 301);
    exit();
    }
        
        if (isset($_POST['btn_submit']) && (substr($_POST['btn_submit'],0,8)=="Button 2"))
        {
          $check = $_SESSION["editid"]; 
          $usernamee = $_COOKIE["user"]; 
          $comment = $_POST['comment'];
          $Formto = $_POST['formTo'];
          $FormFrom = $_POST['formFrom'];
          $Service = $_POST['formService'];
          $dateJourney = $_POST['date'];
          $timeJourney = $_POST['time'];
          $car = $_POST['car'];
          $Licence = $_POST['formLicence'];
          $insurance = $_POST['formInsurance'];
          $cost = $_POST['cost'];
          $seats = $_POST['formSeats'];
          $comment = stripslashes($comment);
          $date = date("d-m-y");
            
            $sql = "UPDATE comments SET comment='$comment', Start = '$Formto', Destination = '$FormFrom', Service = '$Service', Day = '$dateJourney', Time = '$timeJourney', seats = '$seats', Cost = '$cost', Car = '$car', Licence = '$Licence', Insurance = '$insurance', date = '$date' WHERE id = '$check'";
            
            $sql = "UPDATE comments SET comment='$comment', Start= '$Formto', Destination = '$FormFrom', Service = '$Service', Day = '$dateJourney', Time = '$timeJourney', seats = '$seats', Cost = '$cost', Car = '$car', Licence = '$Licence', Insurance = '$insurance', date = '$date' WHERE id = '$check'";
            
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
    }else{}
        
     

      if (isset($_POST['btn_submit']) && (substr($_POST['btn_submit'],0,8)=="Button 3"))
      {
      $check = $_SESSION["editid"];
      $sql = "DELETE FROM comments WHERE id='$check'";
      mysqli_query($conn,$sql);
      header("Location: dashboard.php", true, 301);
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
            <a href="#main" title="To Top">
                <span class="glyphicon glyphicon-chevron-up"></span>
            </a>
            <p>Greenwich Car Pool ¦ Onur & Co</p>
        </footer>

        <!-- Smooth Scroll Script -->
        <script>
            $(document).ready(function() {
                $(".navbar a, footer a[href='#Main']").on('click', function(event) {
                    if (this.hash !== "") {
                        event.preventDefault();

                        var hash = this.hash;

                        $('html, body').animate({
                            scrollTop: $(hash).offset().top
                        }, 900, function() {

                            window.location.hash = hash;
                        });
                    }
                });

                $(window).scroll(function() {
                    $(".slideanim").each(function() {
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
