<?php
include("function.php");
$object = new busapp();

session_start();
if(isset($_SESSION['id']))
{
  $uid = $_SESSION['id'];
  $uname = $_SESSION['username'];
}
?>
<html>
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="style/feed.css">
  <title>Feedback</title>
</head>

<body>
    <header>
    <a class="navbar-brand" href="index.php"><img style="width:150px;" ; src="./image/logo black.png" alt=""></a>
    </header>
    <form method="post" action="">
    <h2>How would you rate your experience at BookMyBus</h2>
  <div class="rate">
    <input type="radio" id="star1" name="rate" value="1" />
    <label for="star1" title="text">1 star</label>
    <input type="radio" id="star2" name="rate" value="2" />
    <label for="star2" title="text">2 stars</label>
    <input type="radio" id="star3" name="rate" value="3" />
    <label for="star3" title="text">3 stars</label>
    <input type="radio" id="star4" name="rate" value="4" />
    <label for="star4" title="text">4 stars</label>
    <input type="radio" id="star5" name="rate" value="5" />
    <label for="star5" title="text">5 stars</label>
  </div>
  <br>
  <br>
  <div class="row">    
    <div class="col-25">    
      <label for="name"><h2>NAME</h2></label>    
    </div>    
    <div class="col-75">    
      <input type="text" id="name" name="name" readonly="readonly" value="<?php echo $uname?>">    
    </div>    
  </div>    
     
  <div class="row">    
      <div class="col-25">    
        <label for="email"><h2>EMAIL ID</h2></label>    
      </div>    
      <div class="col-75">    
        <input type="email" id="email" name="email" placeholder="Your registered email id..">    
      </div>    
  </div>    
  <div class="row">    
    <div class="col-25">    
      <label for="comment"><h2>COMMENTS</h2></label>    
    </div>    
    <div class="col-75">    
      <input class="comment" name="comment" id="comment" placeholder="Write something.." style="height:200px">   
    </div>    
  </div>    
  <div class="row">    
      <input style="font-weight: bold;cursor:pointer" type="submit" value="SUBMIT" class="button" name="submit" >  
  </div>
  

<?php 
if(isset($_POST['submit'])){
   // Set connection variables
   
   $server = "localhost";
   $username = "root";
   $password = "";
   $db = "bus_management";

   // Create a database connection
   $con = mysqli_connect($server, $username, $password,$db);

   // Check for connection success
   if(!$con){
       die("connection to this database failed due to" . mysqli_connect_error());
   }
   // echo "Success connecting to the db";
 $subject;
 $email;
 $name;
 $rate;
   // Collect post variables

   $subject = $_POST['comment'];
   $email = $_POST['email'];
   $name = $_POST['name'];
   $rate = $_POST['rate'];
//   if(isset($_POST['star5'])){
//       $rate="1";
//   } 
//    if(isset($_POST['star4'])){
//        $rate="2";
//    }
//    if(isset($_POST['star3'])){
//        $rate="3";
//    }
//    if(isset($_POST['star2'])){
//        $rate="4";
//    }
//    if(isset($_POST['star1'])){
//        $rate="5";
//    }
//    
//    
   
   $sql = "INSERT INTO `feedback` (`rate`, `name`,`user_id`, `email`, `comment`, `dt`) VALUES ( '$rate', '$name','$uid', '$email' , '$subject', current_timestamp());";
   // echo $sql;

   // Execute the query
   if($con->query($sql) == true){
       echo "<script>alert('Successfully submitted review');window.location.href='index.php'</script>";

       // Flag for successful insertion
   }
   else{
       echo "ERROR: $sql <br> $con->error";
   }

   // Close the database connection
   $con->close();
}
?>
</form>
</body>

</html>