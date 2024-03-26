<?php 
include("function.php");
$objindex = new busapp();
session_start();
if(isset($_SESSION['id']))
{
  $uid = $_SESSION['id'];
  $uname = $_SESSION['username'];
}

if(isset($_GET['userlogout']))
    {
        if($_GET['userlogout']=='logout')
        {
          $objindex->user_logout();
        }
    }
?>
<!doctype html>
<html lang="en">

<head>
  <title>BookMyBus</title>
  <?php include_once("includes/link.php"); ?>
  <!-- External CSS -->
  <link rel="stylesheet" href="style/style.css">
  <link rel="stylesheet" href="adminstyle/dashboard.css">
  <style>
      .image {
  height: 30vh;
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  background-color: #e7e8eb;
}
  </style>
</head>

<body onload="myfunction()">

  <div id="loading">

  </div>
  <!-- navbar start .....................-->
  <nav class="navbar navbar-expand-md navbar-light fixed-top scroll-color">
    <a class="navbar-brand" href="index.php"><img style="width:150px;" ; src="./image/logo black.png" alt=""></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#nav"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav mr-auto mx-auto text-center ">
        <li class="nav-item mx-4 my-2">
          <a class="nav-link text-uppercase font-weight-bold" href="index.php">Home</a>
        </li>
        <li class="nav-item mx-4 my-2">
          <a class="nav-link text-uppercase font-weight-bold" href="feed.php">Reviews</a>
        </li>
        <li class="nav-item mx-4 my-2">
          <a class="nav-link text-uppercase font-weight-bold" href="#">Team</a>
        </li>
      </ul>
      <?php 
      
      if(isset($uid) == null)
        { ?>
      <div class="signinsignup text-center" id="hello">
        <a class="btn signninbtn px-3 py-2 my-2" href="signinsignup.php">JOIN US !</a>
      </div>
      <?php         
        }
        else{ ?>
      <div class="dropdown">
        <button class="btn dropdown-toggle my-2" type="button" id="dropdownMenuButton"
          data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <img style="width:30px" src="image/usericon.png" alt="usericon"> <?php echo($uname); ?>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <a class="dropdown-item" href="?userlogout=logout">Logout</a>
          <a class="dropdown-item" href="view.php">View Bookings</a>
        </div>
      </div>
      <?php
      }?>
    </div>
  </nav>
  <!-- end of navbar -->


  <!-- welcome part start -->
  <section class="image">
    <h1>Your Reservations</h1>    
  </section>
  <?php
  $dbhost = "localhost";
  $dbuser = "root";
  $dbpassword = "";
  $dbname = "bus_management";
  $conn = mysqli_connect($dbhost,$dbuser,$dbpassword,$dbname);

  $query = "SELECT * FROM booking where uid='$uid'";
        $output = ''; 
        if(mysqli_query($conn,$query))
        {
            $result = mysqli_query($conn,$query);
            echo"
            <table id='user_table3'>
            <tr>
                <th>Booking ID</th>
                <th>Bus ID</th>
                <th>Bus Name</th>
                <th>Boarding Point</th>
                <th>Seat no</th>
                <th>Amount</th>
            </tr>";
            while($row=mysqli_fetch_object($result))
            {
                echo
                "<tr>
                <td>$row->id</td>
                <td>$row->bid</td>
                <td>$row->bname</td>
                <td>$row->bpoint</td>
                <td>$row->seats</td>
                <td>$row->amount</td>
            </tr> ";
            }
        }
  ?>
  <!-- welcome part end -->

  

  
  <!--link start-->
  <?php include_once("includes/script.php"); ?>

  <!-- jquery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <!-- dynamic date -->
  <script src="js/date.js"></script>

  <!-- swiper js-->
  <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
  <script>
  var swiper = new Swiper(".mySwiper", {
    effect: "coverflow",
    grabCursor: true,
    centeredSlides: true,
    autoplay: {
      delay: 2500,
      disableOnInteraction: false,
    },
    slidesPerView: "auto",
    coverflowEffect: {
      rotate: 0,
      stretch: 0,
      depth: 100,
      modifier: 1,
      slideShadows: true,
    },
    loop: true,
  });
  </script>

  <!-- waypoint jquery -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.0/jquery.waypoints.min.js"
    integrity="sha512-oy0NXKQt2trzxMo6JXDYvDcqNJRQPnL56ABDoPdC+vsIOJnU+OLuc3QP3TJAnsNKXUXVpit5xRYKTiij3ov9Qg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <!-- counter up -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Counter-Up/1.0.0/jquery.counterup.min.js"
    integrity="sha512-d8F1J2kyiRowBB/8/pAWsqUl0wSEOkG5KATkVV4slfblq9VRQ6MyDZVxWl2tWd+mPhuCbpTB4M7uU/x9FlgQ9Q=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
  $('.count').counterUp({
    delay: 10,
    time: 2000
  });
  </script>

  <!-- external js -->
  <script src="js/autocompleteajax.js"></script>


</body>

</html>