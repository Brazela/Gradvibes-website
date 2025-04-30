
   <div class="main main-raised">
        <div class="container mainn-raised" style="width:100%; background: gray;   border-bottom-left-radius: 0px; border-bottom-right-radius: 0px;">
  
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
   

    <!-- Wrapper for slides -->
    <div class="carousel-inner">

      <div class="item active">
        <img src="img/banner1.jpg" style="width:100%;">
        
      </div>

      <div class="item">
        <img src="img/banner2.jpg" style="width:100%;">
        
      </div>
    
      <div class="item">
        <img src="img/banner1.jpg" style="width:100%;">
        
      </div>
      <div class="item">
        <img src="img/banner2.jpg" style="width:100%;">
        
      </div>
      <div class="item">
        <img src="img/banner3.jpg" style="width:100%;">
        
      </div>
  
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control _26sdfg" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only" >Previous</span>
    </a>
    <a class="right carousel-control _26sdfg" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>
     

<!-- ABOUT US SECTION -->
<div class="container" style="background: linear-gradient(to right, #348AC7, #7474BF); width:100%;">
    <div class="row" style="margin-top: 40px;">
        <div class="col-md-12">
			<!-- section title -->
			<div class="col-md-12">
						<div class="section-title text-center">
							<h3 class="title">About Us</h3>
							<div class="section-nav">
							
							</div>
						</div>
					</div>
					<!-- /section title -->
            <p style="font-size: 16px; margin-top: 20px; margin-bottom: 40px;" class="text-center">
                Welcome to our online store, where passion meets quality!<br>
                We are dedicated to bringing you a wide range of premium products at unbeatable prices.<br>
                Our mission is to provide a smooth and satisfying shopping experience for every customer.<br>
                Thank you for being part of our growing community!
            </p>
        </div>
    </div>
</div>
<!-- /ABOUT US SECTION -->

<div class="container_trans">
  <div class="card">
   
      <?php
   include "db.php";
	  
// Check if the user is logged in
if (isset($_SESSION["uid"])) {
	?>

<div class="card-header">
      <h4>Transaction History</h4>
    </div>
    <div class="card-body">

	<?php
    $cust_id = $_SESSION["uid"];  // Get the customer ID from the session

    // Query to get payment details based on customer ID
    $payments_query = "SELECT payment_ID, trx_ID, payment_date, total_amt FROM payments WHERE cust_ID = ?";
    $stmt = $con->prepare($payments_query);
    $stmt->bind_param("i", $cust_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Loop through each payment record
    while ($payment = $result->fetch_assoc()) {
        $payment_id = $payment['payment_ID'];
        $trx_id = $payment['trx_ID'];
        $payment_date = $payment['payment_date'];
        $total_amt = $payment['total_amt'];

        // Query to get the item details for this payment ID
        $orders_query = "SELECT o.qty, o.totalPrice, p.product_name FROM orders o
                         JOIN products p ON o.product_ID = p.product_ID
                         WHERE o.cust_ID = ? AND o.payment_ID = ?";
        $stmt_orders = $con->prepare($orders_query);
        $stmt_orders->bind_param("ii", $cust_id, $payment_id);
        $stmt_orders->execute();
        $orders_result = $stmt_orders->get_result();

        // Calculate total price and tax
        $tax_rate = 0.06;
        $total_price_with_tax = $total_amt * (1 + $tax_rate);

        echo "<div class='transaction-details'>
                <p><strong>Transaction ID:</strong> $trx_id</p>
                <p><strong>Date:</strong> $payment_date</p>
                <button class='btn-toggle' onclick=\"toggleCollapse('itemDetails$payment_id')\">
                    View Items Purchased
                </button>
                <div class='collapse-content' id='itemDetails$payment_id'>
                    <ul>";
        
        // Loop through each order item and display the item details
        while ($order = $orders_result->fetch_assoc()) {
            $item_name = $order['product_name'];
            $quantity = $order['qty'];
            $price = $order['totalPrice'];
            echo "<li>$item_name - Quantity: $quantity - Price: RM $price</li>";
        }

        // Display tax and total amount with tax
        echo "  </ul>
                <p><strong>Tax (6%):</strong> RM " . number_format($total_amt * $tax_rate, 2) . "</p>
                <p><strong>Total Amount with Tax:</strong> RM " . number_format($total_price_with_tax, 2) . "</p>
                </div>
              </div><hr>";
    }
	echo"</div>";
} else {
		// If user is not logged in, show search box
		echo '
			
			
					<div class="card-header">
						<h4>Search Transaction by ID</h4>
					</div>
					<div class="card-body">
						<input type="text" id="transactionID" class="form-control" placeholder="Enter Transaction ID">
						<button style="margin-top:10px; width:100%;" class="btn btn-primary mt-3" onclick="searchTransaction()">Search</button>
	
						<div id="transactionResult" class="mt-3"></div>
					</div>

	
			<script>
			// Function to search for transaction ID
			function searchTransaction() {
				var trxID = document.getElementById("transactionID").value;
	
				if (trxID.trim() != "") {
					// Send AJAX request to fetch the transaction details
					var xhr = new XMLHttpRequest();
					xhr.open("POST", "search_transaction.php", true);
					xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
					xhr.onreadystatechange = function() {
						if (xhr.readyState == 4 && xhr.status == 200) {
							document.getElementById("transactionResult").innerHTML = xhr.responseText;
						}
					};
					xhr.send("trx_id=" + trxID);
				} else {
					alert("Please enter a Transaction ID.");
				}
			}
			</script>
		';
	}
  

?>
    </div>
  </div>


		<!-- SECTION -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">

					<!-- section title -->
					<div class="col-md-12">
						<div class="section-title">
							<h3 class="title">Featured Products</h3>
							<div class="section-nav">
							
							</div>
							<div class="col-md-12 col-xs-12" id="product_msg">
							</div>
						</div>
					</div>
					<!-- /section title -->

					<!-- Products tab & slick -->
					<div class="col-md-12">
						<div class="row">
							<div class="products-tabs">
								<!-- tab -->
								<div id="tab1" class="tab-pane active">
									<div class="products-slick" data-nav="#slick-nav-1" >
									
									<?php
                    include 'db.php';
					$product_query = "SELECT Products.*, Categories.cat_title AS cat_name 
					FROM Products 
					INNER JOIN Categories ON Products.cat_id = Categories.cat_id 
					ORDER BY RAND() LIMIT 6";
  
  $run_query = mysqli_query($con, $product_query);
  
  if(mysqli_num_rows($run_query) > 0) {
	  while($row = mysqli_fetch_array($run_query)) {
		  $pro_id    = $row['product_ID'];
		  $pro_name  = $row['product_name'];
		  $pro_price = $row['product_price'];
		  $pro_image = $row['product_image'];
		  $cat_name  = $row['cat_name']; 
                        echo "
				
                        
                                
								<div class='product'>
										<a href='product.php?p=$pro_id'><div class='product' style='border-radius:11px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);'>
										<div class='product-img'>
										<img src='product_images/$pro_image' style='max-height: 170px; margin-top:15px;' alt=''>
										
									</div></a>
									<div class='product-body'>
										<p style='font-size: 10px !important;' class='product-category'>$cat_name</p>
										<h3 style='height:70px;'  class='product-name header-cart-item-name'><a href='product.php?p=$pro_id'>$pro_name</a></h3>
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
<button pid='$pro_id' id='product' style='border-radius: 0px 0px 11px 11px; width:100%; outline: none !important; border: none;' class='btn btn-warning' href='#'><i class='fa fa-shopping-cart'></i> Add To Cart</button>
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
										
										
										<!-- /product -->
									</div>
									<div id="slick-nav-1" class="products-slick-nav"></div>
								</div>
								<!-- /tab -->
							</div>
						</div>
					</div>
					<!-- Products tab & slick -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->

		
		
</div>


<style>
    /* General Styles */


    .container_trans {
        font-family: Arial, sans-serif;
      max-width: 1200px;
      margin: 30px auto;
      padding: 20px;
    }

    .card {
      background-color: white;
      margin-bottom: 20px;
      border-radius: 8px;
	  border: 0.1px solid #D3D3D3; 
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      overflow: hidden;
    }

    .card-header {
      background-color: #007bff;
      color: white;
      padding: 10px;
      font-size: 18px;
    }

    .card-body {
      padding: 15px;
    }

    .transaction-details p {
      margin: 10px 0;
      font-size: 16px;
    }

    .btn-toggle {
      display: inline-block;
      padding: 10px 15px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
    }

    .collapse-content {
      margin-top: 10px;
      display: none;
      padding: 10px;
      background-color: #f9f9f9;
      border: 0.1px solid #D3D3D3; 
      border-radius: 10px;
    }

    .collapse-content ul {
      list-style: none;
      padding-left: 0;
    }

    .collapse-content li {
      padding: 5px 0;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .card-header {
        font-size: 16px;
      }

      .btn-toggle {
        width: 100%;
      }
    }
  </style>

  
<script>
  // Toggle function for the collapsible sections
  function toggleCollapse(id) {
    const content = document.getElementById(id);
    if (content.style.display === "none" || content.style.display === "") {
      content.style.display = "block";
    } else {
      content.style.display = "none";
    }
  }
</script>