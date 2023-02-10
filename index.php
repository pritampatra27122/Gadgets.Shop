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
    <title>Gadgets.Shop</title>
    <link rel = "icon" href = "https://cdn-icons-png.flaticon.com/512/5381/5381388.png">
    <link rel="stylesheet" href="assets/css/icons.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/red-color.css">
    <link rel="stylesheet" href="assets/css/yellow-color.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <script src="https://kit.fontawesome.com/7ef9c0db1d.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</head>
<body>
<?php include_once('includes/header.php');?>
        <section>
            <div class="block blackish opac50">
                <div class="fixed-bg" style="background-image: url(assets/images/main.jpg);"></div>
                <div class="restaurant-searching style2 text-center">
                    <div class="restaurant-searching-inner">
						<span style="font-family: 'Ubuntu', sans-serif;">Exciting <i>Deals</i> </span>
                        <h2 style="font-family: 'Ubuntu', sans-serif;">One Shop for Everything</h2>
                        <form class="restaurant-search-form2 brd-rd30" method="post" action="search-result.php">
           <input class="brd-rd30" type="text" placeholder="Product Name" required="true"  name="searchdata">
                            <button class="brd-rd30 red-bg" type="submit" name="search" style="font-family: 'Ubuntu', sans-serif;"><i class="fa-solid fa-magnifying-glass"></i>  SEARCH</button>
                        </form>
                    </div>
                </div><!-- Restaurant Searching -->
            </div>
        </section>
          <!-- Features -->
          <?php include_once('includes/features.php');?>
        <section>
        <div class="block less-spacing gray-bg top-padd30">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-lg-12">
                        <div class="sec-box">
                            <div class="remove-ext">
                                <div class="row">
                                <?php
                                if (isset($_GET['page_no']) && $_GET['page_no']!="") {
                                $page_no = $_GET['page_no'];
                                } else 
                                {
                                    $page_no = 1;
                                }

                                $total_records_per_page = 12;
                                $offset = ($page_no-1) * $total_records_per_page;
                                $previous_page = $page_no - 1;
                                $next_page = $page_no + 1;
                                $adjacents = "2"; 
                                $result_count = mysqli_query($con,"SELECT COUNT(*) As total_records FROM tblitem");
                                $total_records = mysqli_fetch_array($result_count);
                                $total_records = $total_records['total_records'];
                                $total_no_of_pages = ceil($total_records / $total_records_per_page);
                                $second_last = $total_no_of_pages - 1; // total page minus 1
                                $result = mysqli_query($con,"SELECT * FROM tblitem LIMIT $offset, $total_records_per_page");
                                while($row = mysqli_fetch_array($result))
                                {
                                ?>
                                    <div class="col-md-4 col-sm-6 col-lg-4">
                                        <div class="popular-dish-box style2 wow fadeIn" data-wow-delay="0.2s">
                                            <div class="popular-dish-thumb">
                                            <center>
                                                <a href="item-detail.php?fid=<?php echo $row['ID'];?>"><img src="admin/itemimages/<?php echo $row['Image'];?>" alt="<?php echo $row['ItemName'];?>" style="display: block; margin-left: auto; margin-right: auto; width: 53%;"></a>
                                            </center>
                                    </div>
                                    <div class="popular-dish-info">
                                    <h4 itemprop="headline"><a href="item-detail.php?fid=<?php echo $row['ID'];?>"><?php echo $row['ItemName'];?></a></h4>
                                    <form method="post">    
                                    <p>
                                    <input type="hidden" name="itemid" value="<?php echo $row['ID'];?>"> 
                                    <input class="qty" name="itemqty" type="text" value="1">
                                    </p>
                                    <span class="price">Rs. <?php echo $row['ItemPrice'];?></span>

                                    <?php if($_SESSION['fosuid']==""){?>
                                    <a class="log-popup-btn btn  pull-right red-bg brd-rd3" href="#" title="Login">Buy Now</a>
                                    <?php } else {?>
                                    <button type="submit" name="addcart" class="btn  pull-right red-bg brd-rd3"><i class="fa-solid fa-cart-arrow-down"></i> Add to Cart</button>
                                    <?php } ?>
                                    </form>
                                    </div>
                                    </div><!-- Popular Dish Box -->
                                    </div>
                                    <?php 
                                } 
                                ?>
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