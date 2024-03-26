<?php
include("function.php");
$object = new busapp();

session_start();
if(isset($_SESSION['id']))
{
  $uid = $_SESSION['id'];
  $uname = $_SESSION['username'];
}

if(isset($_GET['status']))
{
    if($_GET['status']='viewseats')
    {
        $busid = $_GET['id'];
        // $busname = $_GET['bus_name'];
        $returnvalue=$object->view_seats($busid);

    }
}



if(isset($_GET['userlogout']))
    {
        if($_GET['userlogout']=='logout')
        {
          $object->user_logout();
        }
    }
?>
<html>
<head>
<?php include_once("includes/link.php"); ?>
<link rel="stylesheet" href="style/style.css">
<link rel="stylesheet" href="style/viewseats.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<title>Select Seats</title>	
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript">

			$(document).ready(function(){
				$(".reserved input").prop('checked', true);
				$(".reserved input").prop('disabled', true);
				$("label").click(function(){
					if(!$(this).hasClass("reserved")){
						if($(this).find("input").is(":checked")){
						$(this).addClass("selected");
						}else{
							console.log("selected");
							$(this).removeClass("selected");
						}
					}
					else{
						alert("Already booked");
					}
				})
			});
		
		var x=0;
		var text="";
		var text1="";
		var res;
		var seat=["A1","B1","C1","D1","E1","F1","G1","H1","I1","J1",
				  "A2","B2","C2","D2","E2","F2","G2","H2","I2","J2",
				  "A3","B3","C3","D3","E3","F3","G3","H3","I3","J3",
				  "A4","B4","C4","D4","E4","F4","G4","H4","I4","J4"];
				
			$(document).ready(function(){
				
				if(x==0)
				{
					
						$('.cust-checkbox').click(function(){
						$('.cust-checkbox:checked' && '.cust-checkbox:disabled').each(function(){
							text+=$(this).val()+' ';
						});
						
						res=text.split(" ");
						
						text=" ";
						for(var i=0;i<res.length;i++)
						{
							for(var j=0;j<seat.length;j++)
							{
								if(res[i]==seat[j])seat[j]=" ";
								break;
							}
						}
						
					});
					x=1;
				}
				else
				{
					
					$('.cust-checkbox').click(function(){
						$('.cust-checkbox:checked').each(function(){
							var i,f=1;
							for (i = 0; i < res.length; i++) {
								if($(this).val()==res[i])
								{
									
									f=0;
									break;
								}
							}
							if(f==1)
							{
								text+=$(this).val()+'\n';
							}
							else f=1;
						});
						
						text=text.substring(0,text.length-1);
						$('#selectedtext').val(text);
						var count = $("[type='checkbox']:checked").length-1;
						$('#count').val(count);
						$("#fare").val("100");
					});
				}
			});
		</script>
		<style>
			label{
				display: block;
			}
			.cust-checkbox {
				display: none;
			}
			.cust-checkbox + span{
				background-image:url(image/seat_empty.png);
				height: 30px;
				width: 30px;
				border:1px solid #f2f2f2;
				border-radius:4px;
				display:block;
			}
			.cust-checkbox + span:hover{
				background-image:url(image/seat_selected.png);
				
			}
			.reserved .cust-checkbox + span{
				background-image:url(image/booked.png);
				color:white;
			}
            .reserved .cust-checkbox:checked + span{
				background-image:url(image/booked.png);
				color:white;
			}

			.selected .cust-checkbox + span{
				background-image:url(image/seat_selected.png);
				color:white;
			}
			span{
				color:white;
				text-align:center;
			}
			.cust-checkbox:checked + span{
				height: 30px;
				width: 30px;
				display:block;
                background-image: url(image/seat_selected.png);

                
			}
			.cust-checkbox:disabled + span{
				height: 30px;
				width: 30px;
				display:block;
                
			}
			.seats{
				border: px solid #ccc;
				padding: 0 5px;max-width: 550px;
				margin: 50px auto 0;
			}
			.info{ 	
				padding: 0 5px;
				max-width: 530px;
				margin: 50px auto 0;
			}
			.col-sm-4{text-align:center;font-size:12px;margin-left:auto;margin-right:auto;}
		</style>
		
</head>
<body>
<?php
if(isset($returnvalue))
{
    $row = $returnvalue -> fetch_assoc();
}
$bid = $row['bus_id'];
$boarding = $object->boardingpoint($bid);
$row2=$object->show_bus_id($bid);
$row3 = $object->displayseat($bid);
$sql = "select * from add_bus where bus_id=$bid";
#$result = mysqli_query($connect,$sql);
$response = "<div>";
#while( $row = mysqli_fetch_array($result) ){
	# $trip_no = $row['trip_no'];
	 $bus_company = $row['bus_name'];
	 $bus_no = $row['bus_id'];
	 $time = $row2['departure'];
	 $date = $row2['bus_date'];
	 $start = $row2['from_route'];
	 $end = $row2['to_route'];
	 $fare = $row['price'];
	 $booked_seat = $row['booked'];
	 $i=0;
	 $book_seat_no=str_split($booked_seat);
	 $seat=array();
	 $check=array('0','1','2','3','4','5','6','7','8','9',
				  '10','11','12','13','14','15','16','17','18','19',
				  '20','21','22','23','24','25','26','27','28','29',
				  '30','31','32','33','34','35','36','37','38','39');
	 $disabled=array('enabled','enabled','enabled','enabled','enabled','enabled','enabled','enabled','enabled','enabled',
				     'enabled','enabled','enabled','enabled','enabled','enabled','enabled','enabled','enabled','enabled',
				     'enabled','enabled','enabled','enabled','enabled','enabled','enabled','enabled','enabled','enabled',
				     'enabled','enabled','enabled','enabled','enabled','enabled','enabled','enabled','enabled','enabled');
	 $seat_name=array("a1","b1","c1","d1","e1","f1","g1","h1","i1","j1",
					  "a2","b2","c2","d2","e2","f2","g2","h2","i2","j2",
					  "a3","b3","c3","d3","e3","f3","g3","h3","i3","j3",
					  "a4","b4","c4","d4","e4","f4","g4","h4","i4","j4");
	 $l=count($book_seat_no);
	 for($x=0;$x<$l;$x+=2)
	 { 
		 $seat[$i]=$book_seat_no[$x].$book_seat_no[$x+1];
		 for($j=0;$j<40;$j++)
		 {
			 if($seat[$i]==$seat_name[$j])
			 {
				 $check[$j]="reserved";
				 $disabled[$j]="disabled";
				 break;
			 }
		 }
		 $i++;
	 }
	 $available_seat=40-count($seat);
	$response .="<form action='' name='seats' method='POST'>
				<div class='container-fluid' style='position:absolute;top:40px'>
					<div class='row'>
						<div class='col-lg-3' style='padding-left:2%;padding-bottom:2%;list-style:none;'>
							<h5 class='card-title'>".$bus_company."</h5>
							<li class='text-muted'>Time: ".$time."</li>
							<li class='text-muted'>Date: ".$date."</li>
							<li class='card-text'><small class='text-muted'>Coach No: ".$bus_no."</small></li>
							<li class='card-text' style='margin-top:2%' name='start' id='start'>".$start." - ".$end."</li>
							<li class='card-text' style='margin-top:2%'>Fare(per seat): ".$fare."/-</li>
							<li class='card-text' style='margin-top:2%'>No. available seats: ".$available_seat."</li>
						</div>
						<div class='col-lg-4' style='border:px solid #079d49;background-color:;border:2px solid #cccccc;border-radius:6px;padding:0;margin:0'>
							<div class='container-fluid' id='seat_block' style='margin-top:5%;margin-bottom:5%;color:;'>
								<div class='row info' style='margin-top:5%'>
									<div class='col-sm-4'><label class='reserved'><input type='checkbox' class='cust-checkbox' value='' disabled><span></span>Reserve Seat </label></div>
									<div class='col-sm-4'><label class='selected'><input type='checkbox' class='cust-checkbox'  value='' disabled><span></span>Selected Seat </label></div>
									<div class='col-sm-4'><label ><input type='checkbox' class='cust-checkbox' value=''  disabled><span></span>Empty Seat </label></div>
									<i style='float:right;margin-left:86%'><img src='image/wheel.png' style='width:30px;height:30px;'/></i>
								</div>
								<div class='container-fluid seats' style='margin-top:5%'>
									<div class='row'>
										<div class='col'>
											<label class=".$check[0]."><input type='checkbox' class='cust-checkbox ".$disabled[0]."' value='A1' name='a1' id='a1'><span>A1</span></label>
											<label class=".$check[1]."><input type='checkbox' class='cust-checkbox ".$disabled[1]."' value='B1' name='b1' id='b1'><span>B1</span></label>
											<label class=".$check[2]."><input type='checkbox' class='cust-checkbox ".$disabled[2]."' value='C1' name='c1' id='c1'><span>C1</span></label>	
											<label class=".$check[3]."><input type='checkbox' class='cust-checkbox ".$disabled[3]."' value='D1' name='d1' id='d1'><span>D1</span></label>	
											<label class=".$check[4]."><input type='checkbox' class='cust-checkbox ".$disabled[4]."' value='E1' name='e1' id='e1'><span>E1</span></label>
											<label class=".$check[5]."><input type='checkbox' class='cust-checkbox ".$disabled[5]."' value='F1' name='f1' id='f1'><span>F1</span></label>
											<label class=".$check[6]."><input type='checkbox' class='cust-checkbox ".$disabled[6]."' value='G1' name='g1' id='g1'><span>G1</span></label>
											<label class=".$check[7]."><input type='checkbox' class='cust-checkbox ".$disabled[7]."' value='H1' name='h1' id='h1'><span>H1</span></label>
											<label class=".$check[8]."><input type='checkbox' class='cust-checkbox ".$disabled[8]."' value='I1' name='i1' id='i1'><span>I1</span></label>
											<label class=".$check[9]."><input type='checkbox' class='cust-checkbox ".$disabled[9]."' value='J1' name='j1' id='j1'><span>J1</span></label>
										</div>
										<div class='col'>
											<label class=".$check[10]."><input type='checkbox' class='cust-checkbox ".$disabled[10]."' value='A2' name='a2' id='a2'><span>A2</span></label>
											<label class=".$check[11]."><input type='checkbox' class='cust-checkbox ".$disabled[11]."' value='B2' name='b2' id='b2'><span>B2</span></label>
											<label class=".$check[12]."><input type='checkbox' class='cust-checkbox ".$disabled[12]."' value='C2' name='c2' id='c2'><span>C2</span></label>	
											<label class=".$check[13]."><input type='checkbox' class='cust-checkbox ".$disabled[13]."' value='D2' name='d2' id='d2'><span>D2</span></label>
											<label class=".$check[14]."><input type='checkbox' class='cust-checkbox ".$disabled[14]."' value='E2' name='e2' id='e2'><span>E2</span></label>
											<label class=".$check[15]."><input type='checkbox' class='cust-checkbox ".$disabled[15]."' value='F2' name='f2' id='f2'><span>F2</span></label>
											<label class=".$check[16]."><input type='checkbox' class='cust-checkbox ".$disabled[16]."' value='G2' name='g2' id='g2'><span>G2</span></label>
											<label class=".$check[17]."><input type='checkbox' class='cust-checkbox ".$disabled[17]."' value='H2' name='h2' id='h2'><span>H2</span></label>
											<label class=".$check[18]."><input type='checkbox' class='cust-checkbox ".$disabled[18]."' value='I2' name='i2' id='i2'><span>I2</span></label>
											<label class=".$check[19]."><input type='checkbox' class='cust-checkbox ".$disabled[19]."' value='J2' name='j2' id='j2'><span>J2</span></label>					
										</div>
										<div class='col'>
										</div>
										<div class='col'>
											<label class=".$check[20]."><input type='checkbox' class='cust-checkbox ".$disabled[20]."' value='A3' name='a3' id='a3'><span>A3</span></label>
											<label class=".$check[21]."><input type='checkbox' class='cust-checkbox ".$disabled[21]."' value='B3' name='b3' id='b3'><span>B3</span></label>
											<label class=".$check[22]."><input type='checkbox' class='cust-checkbox ".$disabled[22]."' value='C3' name='c3' id='c3'><span>C3</span></label>	
											<label class=".$check[23]."><input type='checkbox' class='cust-checkbox ".$disabled[23]."' value='D3' name='d3' id='d3'><span>D3</span></label>
											<label class=".$check[24]."><input type='checkbox' class='cust-checkbox ".$disabled[24]."' value='E3' name='e3' id='e3'><span>E3</span></label>
											<label class=".$check[25]."><input type='checkbox' class='cust-checkbox ".$disabled[25]."' value='F3' name='f3' id='f3'><span>F3</span></label>
											<label class=".$check[26]."><input type='checkbox' class='cust-checkbox ".$disabled[26]."' value='G3' name='g3' id='g3'><span>G3</span></label>
											<label class=".$check[27]."><input type='checkbox' class='cust-checkbox ".$disabled[27]."' value='H3' name='h3' id='h3'><span>H3</span></label>
											<label class=".$check[28]."><input type='checkbox' class='cust-checkbox ".$disabled[28]."' value='I3' name='i3' id='i3'><span>I3</span></label>
											<label class=".$check[29]."><input type='checkbox' class='cust-checkbox ".$disabled[29]."' value='J3' name='j3' id='j3'><span>J3</span></label>					
										</div>
										<div class='col'>
											<label class=".$check[30]."><input type='checkbox' class='cust-checkbox ".$disabled[30]."' value='A4' name='a4' id='a4'><span>A4</span></label>
											<label class=".$check[31]."><input type='checkbox' class='cust-checkbox ".$disabled[31]."' value='B4' name='b4' id='b4'><span>B4</span></label>
											<label class=".$check[32]."><input type='checkbox' class='cust-checkbox ".$disabled[32]."' value='C4' name='c4' id='c4'><span>C4</span></label>	
											<label class=".$check[33]."><input type='checkbox' class='cust-checkbox ".$disabled[33]."' value='D4' name='d4' id='d4'><span>D4</span></label>
											<label class=".$check[34]."><input type='checkbox' class='cust-checkbox ".$disabled[34]."' value='E4' name='e4' id='e4'><span>E4</span></label>
											<label class=".$check[35]."><input type='checkbox' class='cust-checkbox ".$disabled[35]."' value='F4' name='f4' id='f4'><span>F4</span></label>
											<label class=".$check[36]."><input type='checkbox' class='cust-checkbox ".$disabled[36]."' value='G4' name='g4' id='g4'><span>G4</span></label>
											<label class=".$check[37]."><input type='checkbox' class='cust-checkbox ".$disabled[37]."' value='H4' name='h4' id='h4'><span>H4</span></label>
											<label class=".$check[38]."><input type='checkbox' class='cust-checkbox ".$disabled[38]."' value='I4' name='i4' id='i4'><span>I4</span></label>
											<label class=".$check[39]."><input type='checkbox' class='cust-checkbox ".$disabled[39]."' value='J4' name='j4' id='j4'><span>J4</span></label>					
										</div>
									</div>
								</div>
						</div>
						</div>
                        
					</div>
				</div>
			</form>";
#}
$response .= "</div>";?>
<div style="position: fixed; left:30px;top:300px;z-index:100;">
<form action="" method="POST">
<?php if(isset($return))
        {
            echo "Success";
        } ?>
      <div id="msg" name="msg"></div>
      <input name="busidno" id="busidno" type="hidden" value="<?php echo $row['bus_id'] ?>">
      <p>Bus Name: </p>
      <input class="form-control disabled" id="busname" name="busname" type="text" value="<?php echo $row['bus_name'] ?>" readonly="readonly" required >
      <p>Customer User Name: </p>
<?php if(isset($uid))
{?>
	  <input name="useridno" id="useridno" type="hidden" value="<?php echo $uid ?>">
      <input class="form-control disabled" id="uname" name="uname" type="text" value="<?php echo $uname ?>" disabled required >
<?php }
else
{ ?>
      <input class="form-control" type="text" value="Sign In First" disabled>
<?php }
?>
      <p>Ticket no: </p>
      <input class="form-control" type="text" name="seatno" id="seatno"  required >
      <!-- <p>Amount:</p>
      <input class="form-control" type="text" name="seatamount" id="fare"   required> -->
<p>Choose Boarding Point:</p>
<select class='form-control' id='busboarding' name='busboarding' required>
<?php while($point = mysqli_fetch_assoc($boarding))
{ ?>
<option><?php echo $point['boarding_pnt'];?></option>
<?php }
?>
</select>
<div class='col-lg-5' style='padding-left:5%;'>
<button class='btn btn-sm' style='margin-top:5%;background-color:#079d49;color:white;' name="book" id="book" >Book Seat</button>
<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpassword = "";
$dbname = "bus_management";
$conn = mysqli_connect($dbhost,$dbuser,$dbpassword,$dbname);
if(isset($_POST['book'])){
	$bid=$_POST['busidno'];
	$bname=$_POST['busname'];
	$uid=$_POST['useridno'];
	$seat=$_POST['seatno'];
	$bpoint=$_POST['busboarding'];
    $result= $object->view_cost($bid);
	$row=mysqli_fetch_assoc($result);
	$cost=intval($row['price']);
    $seat_no=explode (",", $seat); 
	$l=count($seat_no);
	$amount=$cost*$l;
	$query="INSERT INTO booking(bid,bname,uid,uname,seats,bpoint,amount) VALUES('$bid','$bname','$uid','$uname','$seat','$bpoint','$amount')";
	$q1=mysqli_query($conn,"SELECT * FROM bus_inside WHERE bus_id='$bid'");
	$row2=mysqli_fetch_assoc($q1);
	$new=$row2['booked'];
	$snew=str_replace(',', '', $seat);
	$new .=$snew; 
	$q2=mysqli_query($conn,"UPDATE bus_inside SET booked='$new' WHERE bus_id='$bid'");
	if((mysqli_query($conn , $query))){
		echo "<script>alert('seats ".$seat." booked for amount: Rs.".$amount." /-.');
		window.location.href='thankyou.php'</script>";
		// $query1= "SELECT * FROM booking WHERE bid='$busid' AND uid='$uid' ";
        // if(mysqli_query($conn,$query1)){
		// 	$info = mysqli_query($conn,$query1);
        //             if($info)
        //             {
		// 					$seatinfo = mysqli_fetch_assoc($info);
		// 					$_SESSION['bid'] = $seatinfo['bid'];
        //                     $_SESSION['bname'] = $seatinfo['bname'];
		// 					$_SESSION['uid'] = $seatinfo['uid'];
        //                     $_SESSION['uname'] = $seatinfo['uname'];
        //                     $_SESSION['bpoint'] = $seatinfo['bpoint'];
        //                     $_SESSION['seats'] = $seatinfo['seats'];
		// 					$_SESSION['amount'] = $seatinfo['amount'];
                    
		// 			}
		// }
	}
}
?>
</div>
</form>
</div>
<?php
echo $response;
exit;
?>
</body>
</html>

