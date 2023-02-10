<?php
session_start();
error_reporting(0);
include_once('includes/dbconnection.php');
   if (strlen($_SESSION['fosuid']==0)) 
   {
        header('location:logout.php');
  } else{

if(isset($_POST['placeorder'])){
//getting address
$fnaobno=$_POST['flatbldgnumber'];
$street=$_POST['streename'];
$area=$_POST['area'];
$lndmark=$_POST['landmark'];
$city=$_POST['city'];
$userid=$_SESSION['fosuid'];
//genrating order number
$orderno= mt_rand(100000000, 999999999);
$query="update tblorders set OrderNumber='$orderno',IsOrderPlaced='1' where UserId='$userid' and IsOrderPlaced is null;";
$query.="insert into tblorderaddresses(UserId,Ordernumber,Flatnobuldngno,StreetName,Area,Landmark,City) values('$userid','$orderno','$fnaobno','$street','$area','$lndmark','$city');";

$result = mysqli_multi_query($con, $query);
if ($result) {
    //Code for email
    $toemail=$_SESSION['uemail'];
    $subj="Order Confirmation";       
    $heade .= "MIME-Version: 1.0"."\r\n";
    $heade .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
    $heade .= 'From:FOS<noreply@yourdomain.com>'."\r\n";    // Put your sender email here
    $msgec.="<html></body><div><div>Hello,</div></br></br>";
    $msgec.="<div style='padding-top:8px;'> Your order has been placed successfully <br />
    <strong> Order Number: </strong> $orderno </br>
    </div><div></div></body></html>";
    mail($toemail,$subj,$msgec,$heade);
    echo '<script>alert("Your order placed successfully. Order number is "+"'.$orderno.'")</script>';
    echo "<script>window.location.href='my-account.php'</script>";
    
    }
}   

//Code deletion
if(isset($_GET['delid'])) {
$rid=$_GET['delid'];
$query=mysqli_query($con,"delete from tblorders where ID='$rid'");
echo '<script>alert("Product deleted")</script>';
echo "<script>window.location.href='cart.php'</script>";

}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Gadgets.Shop | Cart</title>
    <link rel = "icon" href = "https://cdn-icons-png.flaticon.com/512/5381/5381388.png">

    <link rel="stylesheet" href="assets/css/icons.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/red-color.css">
    <link rel="stylesheet" href="assets/css/yellow-color.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
</head>
<body itemscope>
<?php include_once('includes/header.php');?>
        <center><h1 style="font-size: 45px;">My Cart</h1></center>
        <div class="bread-crumbs-wrapper">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">My Cart</li>
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
    <div class="col-md-12 col-sm-12 col-lg-12">

<div class="booking-table">
<table>
<thead>
<tr>
    <th>#</th>
    <th>Item Name</th>
    <th>Price</th>
    <th>Total</th>
    <th>Action</th>
</tr>
</thead>
<tbody>
    <?php 
$userid= $_SESSION['fosuid'];
$query=mysqli_query($con,"select tblorders.id as frid,tblitem.image,tblitem.ItemName,tblitem.ItemDes,tblitem.ItemPrice,tblitem.ItemQty,tblorders.itemId,tblorders.itemQty from tblorders join tblitem on tblitem.id=tblorders.itemId where tblorders.UserId='$userid' and tblorders.IsOrderPlaced is null");
$num=mysqli_num_rows($query);
if($num>0){
while ($row=mysqli_fetch_array($query)) 
{
?>
<tr>
    <td><img src="admin/itemimages/<?php echo $row['Image']?>" width="120" height="100" alt="<?php echo $row['ItemName']?>"></td>
<td>
    <a href="item-detail.php?fid=<?php echo $row['itemId'];?>" title="" ><?php echo $row['ItemName']?></a>
</td>
<td><?php echo $ppu=$row['ItemPrice']?></td>
<td><?php echo $ppu=$row['ItemPrice']?></td>
<?php echo $total = $ppu;?>
<td><a href="cart.php?delid=<?php echo $row['frid'];?>" onclick="return confirm('Do you really want to delete?');";><i class="fa fa-trash" aria-hidden="true" title="Delete this product"></i><a/></span></td>
</tr>

<?php $grandtotal += $total;}?>
<thead>
<tr>
    <th colspan="3" style="text-align:center;">Grand Total</th>
<th style="text-align:center;"><?php echo $grandtotal;?></th>
<th></th>
</tr>
</thead>
<form method="post">
<tr>                            
<td colspan="3">
<input type="text" name="flatbldgnumber"  placeholder="Flat or Building Number" class="form-control" required="true">
</td>
<td colspan="3">
<input type="text" name="streename" placeholder="Street Name" class="form-control" required="true">      
</td>
</tr>
<tr>
<td colspan="3"> 
<input type="text" name="area"  placeholder="Area" class="form-control" required="true">
</td>
<td colspan="3">
<input type="text" name="landmark" placeholder="Landmark if any" class="form-control">
</td>
</tr>
<tr>
<td colspan="3"> 
<input type="text" name="city" placeholder="City" class="form-control">  
</td>
</tr>
<tr>
    <td colspan="3">
       <button   type="submit" name="placeorder" class="btn theme-btn btn-lg">Place order</button>
   </td></tr>
   </form>

<?php } else {?>
    <tr>
        <td colspan="6" style="color:red">You cart is empty</td>
    </tr>
<?php } ?>
</tbody>
</table>
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