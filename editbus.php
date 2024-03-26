<?php
    include("../function.php");
    $objbooking  = new busapp();

    session_start();
    $id = $_SESSION['adminid'];
    $name = $_SESSION['adminname'];
    if($id == null)
    {
        header("location:../admin.php");
    }
    if(isset($_GET['status']))
    {
        if($_GET['status']='booking')
        {
            $busid = $_GET['id'];
            $recvdata=$objbooking->show_bus_id($busid);
        }
    }
    if(isset($_POST['edit_action']))
    {
      $objbooking->update_data($_POST,$busid);
    }

?>
<link rel="stylesheet" href="../adminstyle/editbus.css">
<?php include_once("../includes/link.php"); ?>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
<head><title>Edit Bus Deatails</title></head>
<body>
<div class="button" id="button">
    <a href="dashcondition.php"><i class="fa-2x fas fa-arrow-left"></i> </a>
  </div>
<div id="dashboard">
<div class="addbus">
<form action="" method="post" id="user_form" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-25">
                        <label for="busname">Bus Name</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="busname" name="busname" value="<?php echo $recvdata['bus_name']; ?>" required>
                    </div>
                </div>
                <div class="row">
    <div class="col-25">
        <label for="formroute">From</label>
    </div>
    <div class="col-75 searchbox">
        <!-- <input type="text" id="formroute" name="form" placeholder="From"> -->
        <select class="fromroute" name="fromroute" id="fromroutes" class="selectpicker" required>
        <option value="" selected ><?php echo $recvdata['from_route']; ?></option>
            <?php include_once("route.php") ?>
        </select>

    </div>
</div>
<div class="row">
    <div class="col-25">
        <label for="toroute">From</label>
    </div>
    <div class="col-75 searchbox">
        <!-- <input type="text" id="formroute" name="form" placeholder="From"> -->
        <select class="toroute" name="toroute" id="toroutes" class="selectpicker" required>
        <option value="" selected ><?php echo $recvdata['to_route']; ?></option>
            <?php include("route.php") ?>
        </select>
    </div>
</div>
                <?php #include_once("fromroute.php"); ?>
                <?php #include_once("toroute.php"); ?>
                <div class="row">
                    <div class="col-25">
                        <label for="dateroute">Travel Date</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="dateroute" name="dateroute" placeholder="Date" value="<?php echo $recvdata['bus_date']; ?>"
                            onfocus="(this.type='date')" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="timeroute">Departure Time</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="dtimeroute" name="dtimeroute" placeholder="Depature Time" value="<?php echo $recvdata['departure']; ?>"
                            onfocus="(this.type='time')" pattern="[0-9]{2}:[0-9]{2}" onchange="onTimeChange()" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="timeroute">Arrival Time</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="atimeroute" name="atimeroute" placeholder="Arrival Time" value="<?php echo $recvdata['arrival']; ?>"
                            onfocus="(this.type='time')" pattern="[0-9]{2}:[0-9]{2}" onchange="onTimeChange()" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="bustype">Bus Type</label>
                    </div>
                    <div class="col-75">
                        <select id="bustype" name="bustype" required>
                            <option value="AC">AC</option>
                            <option value="NonAc">Non-AC</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="picture">Picture</label>
                    </div>
                    <div class="col-75">
                        <input type="file" id="picture" name="picture"  required >
                        <input type="hidden" name="hidden_user_image" id="hidden_user_image" />
                        <span id="uploaded_image"></span>
                    </div>
                </div>
                <div class="row submitbtn">
                   
                    <input type="hidden" name="action" id="action" />
                    <input type="hidden" name="user_id" id="user_id" />
                    <input type="submit" name="edit_action" id="edit_action" value="Update">
                </div>
            </form>
</div>
</div>
</body>