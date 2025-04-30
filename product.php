<?php
include "header.php";
?>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$(".scroll").click(function(event){		
					event.preventDefault();
					$('html,body').animate({scrollTop:$(this.hash).offset().top},900);
				});
			});
</script>
		<script>
    
    (function (global) {
	if(typeof (global) === "undefined")
	{
		throw new Error("window is undefined");
	}
    var _hash = "!";
    var noBackPlease = function () {
        global.location.href += "#";
        global.setTimeout(function () {
            global.location.href += "!";
        }, 50);
    };	
    global.onhashchange = function () {
        if (global.location.hash !== _hash) {
            global.location.hash = _hash;
        }
    };
    global.onload = function () {        
		noBackPlease();
		document.body.onkeydown = function (e) {
            var elm = e.target.nodeName.toLowerCase();
            if (e.which === 8 && (elm !== 'input' && elm  !== 'textarea')) {
                e.preventDefault();
            }
            e.stopPropagation();
        };		
    };
})(window);
</script>

		<!-- SECTION -->
		<div class="section main main-raised">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<!-- Product main img -->
					<div class="col-md-12 col-xs-12" id="product_msg">
					</div>
					<?php 
								include 'db.php';
								$product_ID = $_GET['p'];
								
								$sql = " SELECT * FROM products ";
								$sql = " SELECT * FROM products WHERE product_ID = $product_ID";
								if (!$con) {
									die("Connection failed: " . mysqli_connect_error());
								}
								$result = mysqli_query($con, $sql);
								if (mysqli_num_rows($result) > 0) 
								{
									while($row = mysqli_fetch_assoc($result)) 
									{
									echo '
									
                                    
                                
                                <div class="col-md-5 col-md-push-2">
                                <div id="product-main-img">
                                    <div class="product-preview">
                                        <img src="product_images/'.$row['product_image'].'" alt="">
                                    </div>

                                    <div class="product-preview">
                                        <img src="product_images/'.$row['product_image'].'" alt="">
                                    </div>

                                    <div class="product-preview">
                                        <img src="product_images/'.$row['product_image'].'" alt="">
                                    </div>

                                    <div class="product-preview">
                                        <img src="product_images/'.$row['product_image'].'" alt="">
                                    </div>
                                </div>
                            </div>
                                
                                <div class="col-md-2  col-md-pull-5">
                                <div id="product-imgs">
                                    <div class="product-preview">
                                        <img src="product_images/'.$row['product_image'].'" alt="">
                                    </div>

                                    <div class="product-preview">
                                        <img src="product_images/'.$row['product_image'].'" alt="">
                                    </div>

                                    <div class="product-preview">
                                        <img src="product_images/'.$row['product_image'].'g" alt="">
                                    </div>

                                    <div class="product-preview">
                                        <img src="product_images/'.$row['product_image'].'" alt="">
                                    </div>
                                </div>
                            </div>

                                 
									';
                                    
									?>
									<!-- FlexSlider -->
									
									<?php 
									echo '
									
                                    
                                   
                    <div class="col-md-5">
						<div class="product-details">
							<h2 class="product-name">'.$row['product_name'].'</h2>
							
							<div>
								<h3 class="product-price">RM '.$row['product_price'].'</h3>
								<span class="product-available">In Stock</span>
							</div>
							<p>'.$row['product_desc'].'</p>


							<div class="add-to-cart">
							
								<div class="btn-group" style=" margin-top: 105px">
								<button class="add-to-cart-btn" pid="'.$row['product_ID'].'"  id="product" ><i class="fa fa-shopping-cart"></i> add to cart</button>
                                </div>
								
								
							</div>


							<ul class="product-links">
								<li>Share:</li>
								<li><a href="#"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
								<li><a href="#"><i class="fa fa-envelope"></i></a></li>
							</ul>

						</div>
					</div>
									
				
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->

		<!-- Section -->
		<div class="section main main-raised">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
                    
					<div class="col-md-12">
						<div class="section-title text-center">
							<h3 class="title">Related Products</h3>
							
						</div>
					</div>
                    ';
									$_SESSION['product_ID'] = $row['product_ID'];
									}
								} 
								?>	
								<?php
                    include 'db.php';
								$product_ID = $_GET['p'];
                    
								$product_query = "SELECT * FROM Products 
								INNER JOIN Categories ON Products.cat_id = Categories.cat_id 
								WHERE Products.product_ID BETWEEN $product_ID AND ".($product_ID + 3);								
                $run_query = mysqli_query($con,$product_query);
                if(mysqli_num_rows($run_query) > 0){

                    while($row = mysqli_fetch_array($run_query)){
                        $pro_id = $row['product_ID'];
		$pro_title = $row['product_name']; 
		$pro_price = $row['product_price'];
		$pro_image = $row['product_image'];
		$cat_name = $row['cat_title'];

                        echo "
				
                        
                                <div class='col-md-3 col-xs-6'>
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
<button  pid='$pro_id' id='product' style='border-radius: 0px 0px 11px 11px; width:100%; outline: none !important; border: none;' class='btn btn-warning prevent-select' href='#'><i class='fa fa-shopping-cart'></i> Add To Cart</button>
								<!--	<div class='add-to-cart'>
										<button pid='$pro_id' id='product' class='add-to-cart-btn block2-btn-towishlist' href='#'><i class='fa fa-shopping-cart'></i> add to cart</button>
									</div> -->
								</div>
							</div>
							
                        
			";
		}
        ;
      
}
?>
					<!-- product -->
					
					<!-- /product -->

				</div>
				<!-- /row -->
                
			</div>
			<!-- /container -->
		</div>
		<!-- /Section -->

		<!-- NEWSLETTER -->
		
		<!-- /NEWSLETTER -->

		<!-- FOOTER -->
<?php
include "newslettter.php";
include "footer.php";

?>
