<?php
session_start();
include_once('includes/dbconnection.php');
if(isset($_POST['addcart']))
{
$itemid=$_POST['itemid'];
$itemqty=$_POST['itemqty'];
$userid= $_SESSION['fosuid'];
$query=mysqli_query($con,"insert into tblorders(UserId,ItemId,ItemQty) values('$userid','$itemid','$itemqty') ");
if($query)
{
 echo "<script>alert('Item has been added in to the cart');</script>";   
} else {
 echo "<script>alert('Something went wrong.');</script>";      
}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Gadgets.Shop | Shop by Category</title>
    <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon">
    

    <link rel="stylesheet" href="assets/css/icons.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/red-color.css">
    <link rel="stylesheet" href="assets/css/yellow-color.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
</head>
<body itemscope>
<?php include_once('includes/header.php');?>

<center><h1 style="font-size: 45px;">Shop by Category</h1></center>
        <section>
            <div class="block less-spacing gray-bg top-padd30">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-lg-12">
                            <div class="sec-box">
                                <div class="remove-ext">
                                    <div class="row">

<?php
 $cid=$_GET['catid'];
if (isset($_GET['page_no']) && $_GET['page_no']!="") {
    $page_no = $_GET['page_no'];
    } else {
        $page_no = 1;
        }

    $total_records_per_page = 12;
    $offset = ($page_no-1) * $total_records_per_page;
    $previous_page = $page_no - 1;
    $next_page = $page_no + 1;
    $adjacents = "2"; 
    $result_count = mysqli_query($con,"SELECT COUNT(*) As total_records FROM tblitem where CategoryName='$cid'");
    $total_records = mysqli_fetch_array($result_count);
    $total_records = $total_records['total_records'];
  $total_no_of_pages = ceil($total_records / $total_records_per_page);
    $second_last = $total_no_of_pages - 1; // total page minus 1
      $result = mysqli_query($con,"SELECT * FROM tblitem where CategoryName='$cid' LIMIT $offset, $total_records_per_page");
      $num=mysqli_num_rows($result);
      if($num>0){
    while($row = mysqli_fetch_array($result)){
    ?>


                                        <div class="col-md-4 col-sm-6 col-lg-4">
                                        <div class="popular-dish-box style2 wow fadeIn">
                                            <div class="popular-dish-thumb">
                                                <a href="item-detail.php?fid=<?php echo $row['ID'];?>" title="" itemprop="url"><img src="admin/itemimages/<?php echo $row['Image'];?>" alt="<?php echo $row['ItemName'];?>"  style="display: block; margin-left: auto; margin-right: auto; width: 48%;"></a>
                                            </div>
                                            <div class="popular-dish-info">
                                                <h4 itemprop="headline"><a href="item-detail.php?fid=<?php echo $row['ID'];?>" title="" itemprop="url"><?php echo $row['ItemName'];?></a></h4>
                                            <form method="post">    
                                                   <p itemprop="description">
    <input type="hidden" name="itemid" value="<?php echo $row['ID'];?>"> 
    <input class="qty" name="itemqty" type="text" value="1">
                                               </p>
                                                <span class="price">Rs. <?php echo $row['ItemPrice'];?></span>

                                      <?php if($_SESSION['fosuid']==""){?>
  <a class="log-popup-btn btn  pull-right red-bg brd-rd3" href="#" title="Login" >Buy Now</a>
<?php } else {?>
<button type="submit" name="addcart" class="btn  pull-right red-bg brd-rd3">Buy Now</button>
                                                <?php } ?>
                                        </form>
                                            </div>
                                        </div><!-- Popular Dish Box -->
                                    </div>
                              <?php } } else { ?>
<h3 style="color:red;" align="center">No Record Found</h3>

                                                <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
      <?php include_once('includes/footer.php');
include_once('includes/signin.php');
include_once('includes/signup.php');
      ?>
    </main><!-- Main Wrapper -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/main.js"></script>
</body> 

</html>