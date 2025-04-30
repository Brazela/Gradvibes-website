<?php
session_start();
$ip_add = getenv("REMOTE_ADDR");
include "db.php";

if(isset($_POST["categoryhome"])){
	$category_query = "SELECT * FROM categories WHERE cat_id!=1";
    
	$run_query = mysqli_query($con,$category_query) or die(mysqli_error($con));
	echo "
		
            
            
				<!-- responsive-nav -->
				<div id='responsive-nav'>
					<!-- NAV -->
					<ul class='main-nav nav navbar-nav'>
                    <li class='active'><a href='index.php'>Home</a></li>
                    <li><a href='store.php'>All</a></li>
	";
	if(mysqli_num_rows($run_query) > 0){
		while($row = mysqli_fetch_array($run_query)){
			$cid = $row["cat_ID"];
			$cat_name = $row["cat_title"];
            
			$sql = "SELECT COUNT(*) AS count_items FROM Products WHERE cat_ID = $cid"; 
            $query = mysqli_query($con, $sql);
            $row = mysqli_fetch_array($query);
            $count = $row["count_items"];
                 
			echo "    
                               <li class='categoryhome' cid='$cid'><a href='store.php'>$cat_name</a></li>
                    
			";
		}
        
		echo "</ul>
					<!-- /NAV -->
				</div>
				<!-- /responsive-nav -->
               
			";
	}
}


if(isset($_POST["page"])){
	$sql = "SELECT * FROM products";
	$run_query = mysqli_query($con,$sql);
	$count = mysqli_num_rows($run_query);
	$pageno = ceil($count/2);
	for($i=1;$i<=$pageno;$i++){
		echo "
			<li><a href='#product-row' page='$i' id='page'>$i</a></li>
            
            
		";
	}
}
if (isset($_POST["getProducthome"])) {
    $limit = 3;
    if (isset($_POST["setPage"])) {
        $pageno = $_POST["pageNumber"];
        $start = ($pageno * $limit) - $limit;
    } else {
        $start = 0;
    }

    $product_query = "SELECT * FROM Products INNER JOIN Categories ON Products.cat_id = Categories.cat_id LIMIT $start, $limit";
    $run_query = mysqli_query($con, $product_query);

    if (mysqli_num_rows($run_query) > 0) {
        while ($row = mysqli_fetch_array($run_query)) {
            $pro_id    = $row['product_ID']; // corrected
            $pro_title = $row['product_name']; // corrected
            $pro_price = $row['product_price'];
            $pro_image = $row['product_image'];
            $cat_name  = $row['cat_title'];

			echo "
				
                       <div class='product-widget'>
                                <a href='product.php?p=$pro_id'> 
									<div style='border-left:1px solid blue;' class='product-img'>
										<img src='product_images/$pro_image' alt=''>
									</div>
									<div class='product-body'>
										<p class='product-category'>$cat_name</p>
										<h3 class='product-name'><a href='product.php?p=$pro_id'>$pro_title</a></h3>
										<h4 style= 'color:rgb(222 124 0);' class='product-price'>RM $pro_price</h4>
									</div></a>
								</div>
                        
			";
		}
	}
}


if(isset($_POST["gethomeProduct"])){
	$limit = 9;
	if(isset($_POST["setPage"])){
		$pageno = $_POST["pageNumber"];
		$start = ($pageno * $limit) - $limit;
	}else{
		$start = 0;
	}
    
	$product_query = "SELECT * FROM Products INNER JOIN Categories ON Products.cat_id = Categories.cat_id BETWEEN 71 AND 74";
	$run_query = mysqli_query($con,$product_query);
	if(mysqli_num_rows($run_query) > 0){
        
		while($row = mysqli_fetch_array($run_query)){
			$pro_id    = $row['product_id'];
			$pro_cat   = $row['product_cat'];
			$pro_brand = $row['product_brand'];
			$pro_title = $row['product_title'];
			$pro_price = $row['product_price'];
			$pro_image = $row['product_image'];
            
            $cat_name = $row["cat_title"];
            
			echo "
					          
                        <div class='col-md-4 col-xs-6'>
								<a href='product.php?p=$pro_id'><div class='product' style='border-radius:11px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);'>
									<div class='product-img'>
										<img src='product_images/$pro_image' style='max-height: 170px; margin-top:15px;' alt=''>
										
									</div></a>
									<div class='product-body'>
										<p style='font-size: 10px !important;' class='product-category'>$cat_name</p>
										<h3 style='height:70px;'  class='product-name header-cart-item-name'><a href='product.php?p=$pro_id'>$pro_title</a></h3>
										<h4 style='color:rgb(222 124 0);' class='product-price header-cart-item-info'>RM $pro_price</h4>
									
										<div>

										</div>
										
								<!--		<div class='product-btns'>
											product-bt<button class='add-to-wishlist'><i class='fa fa-heart-o'></i><span class='tooltipp'>add to wishlist</span></button>
											<button class='add-to-compare'><i class='fa fa-exchange'></i><span class='tooltipp'>add to compare</span></button>
											<button class='quick-view'><i class='fa fa-eye'></i><span class='tooltipp'>quick view</span></button>
										</div> -->
									</div>
									
								<a id='view' style='border-radius:0px; width:100%; outline: none !important; border: none;' class='btn btn-primary' href='product.php?p=$pro_id'>
    <i class='fa fa-info'></i> View Details
</a>
<button pid='$pro_id' id='product' style='border-radius: 0px 0px 11px 11px; width:100%; outline: none !important; border: none;' class='btn btn-warning prevent-select' href='#'><i class='fa fa-shopping-cart'></i> Add To Cart</button>
								<!--	<div class='add-to-cart'>
										<button pid='$pro_id' id='product' class='add-to-cart-btn block2-btn-towishlist' href='#'><i class='fa fa-shopping-cart'></i> add to cart</button>
									</div> -->
								</div>
							</div>
                        
			";
		}
        ;
      
}
    
	}
    
if(isset($_POST["get_seleted_Category"])){
	   if (isset($_POST["get_seleted_Category"])) {
        $id = mysqli_real_escape_string($con, $_POST["cat_id"]);
        $sql = "SELECT * FROM products 
                INNER JOIN categories ON products.cat_ID = categories.cat_ID 
                WHERE products.cat_ID = '$id'";
                
    }
	
	$current_page = basename($_SERVER['PHP_SELF']);


	$run_query = mysqli_query($con,$sql);
	while($row=mysqli_fetch_array($run_query)){
		$pro_id = $row['product_ID'];
		$pro_title = $row['product_name']; 
		$pro_price = $row['product_price'];
		$pro_image = $row['product_image'];
		$cat_name = $row['cat_title'];
			echo "
					
                    	          
                        <div class='col-md-4 col-xs-6'>
								<a href='product.php?p=$pro_id'><div class='product' style='border-radius:11px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);'>
									<div class='product-img'>
										<img src='product_images/$pro_image' style='max-height: 170px; margin-top:15px;' alt=''>
										
									</div></a>
									<div class='product-body'>
										<p style='font-size: 10px !important;' class='product-category'>$cat_name</p>
										<h3 style='height:70px;'  class='product-name header-cart-item-name'><a href='product.php?p=$pro_id'>$pro_title</a></h3>
										<h4 style='color:rgb(222 124 0);' class='product-price header-cart-item-info'>RM $pro_price</h4>
									
										<div>

										</div>
										
								<!--		<div class='product-btns'>
											product-bt<button class='add-to-wishlist'><i class='fa fa-heart-o'></i><span class='tooltipp'>add to wishlist</span></button>
											<button class='add-to-compare'><i class='fa fa-exchange'></i><span class='tooltipp'>add to compare</span></button>
											<button class='quick-view'><i class='fa fa-eye'></i><span class='tooltipp'>quick view</span></button>
										</div> -->
									</div>
									
								<a id='view' style='border-radius:0px; width:100%; outline: none !important; border: none;' class='btn btn-primary' href='product.php?p=$pro_id'>
    <i class='fa fa-info'></i> View Details
</a>
<button pid='$pro_id' id='product' style='border-radius: 0px 0px 11px 11px; width:100%; outline: none !important; border: none;' class='btn btn-warning prevent-select' href='#'><i class='fa fa-shopping-cart'></i> Add To Cart</button>
								<!--	<div class='add-to-cart'>
										<button pid='$pro_id' id='product' class='add-to-cart-btn block2-btn-towishlist' href='#'><i class='fa fa-shopping-cart'></i> add to cart</button>
									</div> -->
								</div>
							</div>
                        
			";
		}
	}