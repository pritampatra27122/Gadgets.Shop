<?php
session_start();
error_reporting(0);
include_once('includes/dbconnection.php');
   if (strlen($_SESSION['fosuid']==0)) {
  header('location:logout.php');
  } else{
?>
<!DOCTYPE html>
<head>
    <title>Gadgets.Shop | Order Details</title>
    <link rel="stylesheet" href="assets/css/icons.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/red-color.css">
    <link rel="stylesheet" href="assets/css/yellow-color.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
             <script language="javascript" type="text/javascript">
var popUpWin=0;
function popUpWindow(URLStr, left, top, width, height)
{
 if(popUpWin)
{
if(!popUpWin.closed) popUpWin.close();
}
popUpWin = open(URLStr,'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width='+600+',height='+600+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
}

</script>
</head>
<body itemscope>
<?php include_once('includes/header.php');?>
<center>
		<h1 style="font-size: 45px;">Order #<?php echo $_GET['onumber'];?> Details</h1></center>
        <div class="bread-crumbs-wrapper">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php" title="" itemprop="url">Home</a></li>
                    <li class="breadcrumb-item active">Order Details</li>
                </ol>
            </div>
        </div>

        <section>
            <div class="block gray-bg bottom-padd210 top-padd30">
                
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                            <div class="sec-box">
    							<div class="sec-wrapper">

    							



    <div class="col-md-12 col-sm-12 col-lg-12" > 
<div class="booking-table">
 <?php
$userid= $_SESSION['fosuid'];
$oid=$_GET['onumber'];
      $query=mysqli_query($con,"select * from  tblorderaddresses  where UserId='$userid' and Ordernumber='$oid'");
      $count=1;
              while($row=mysqli_fetch_array($query))
              { ?>     
                <h3 align="center">Order #<?php echo $oid;?> Details</h3>
<table border="1" style="padding-left:10%">
<tr>
<th>Order Number#</th> 
<td><?php echo $row['Ordernumber'];?></td>   
<th>Order Date/Time</th>
<td><?php echo $row['OrderTime']?></td>
</tr>
<tr>
<th>Order Status</th> 
<td colspan="3"><?php $status=$row['OrderFinalStatus'];
if($status==''){
 echo "Waiting for Vendor confirmation";   
} else{
echo $status;
}

?> (<a href="javascript:void(0);" onClick="popUpWindow('trackorder.php?oid=<?php echo htmlentities($row['Ordernumber']);?>');" title="Track order" style="color:red;"><i class="flaticon-transport"></i> Track Order</a>)</td>   
</tr>
<tr>
    <th colspan="4" style="text-align:center;color:blue; font-size:20px;">Delivery Address</th>
</tr>
<tr>
<th>Flat No / Building No.:</th>
<td><?php echo $row['Flatnobuldngno']?></td> 
<th>Street Name:</th>
<td> <?php echo $row['StreetName']?></td>    
</tr>

<tr>
<th>Area :</th>
<td><?php echo $row['Area']?></td> 
<th>Landmark:</th>
<td><?php echo $row['Landmark']?></td>    
</tr>

<tr>
<th>City :</th>
<td><?php echo $row['City']?></td> 
   
</tr>

</table>
<?php } ?>
<hr />
</div>
                                    </div>

    							</div>
                            </div>
                        </div>
                    </div>
                </div><!-- Section Box -->
            </div>
        </section>

    <!-- red section -->
    <?php include_once('includes/footer.php');
include_once('includes/signin.php');
include_once('includes/signup.php');
      ?>
    </main><!-- Main Wrapper -->

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
    <script src="assets/js/google-map-int2.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/main.js"></script>

</body>	

</html>
<?php } ?>
