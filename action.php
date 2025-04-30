<?php
session_start();
$ip_add = getenv("REMOTE_ADDR");
include "db.php";
if (isset($_POST["category"])) {
    $category_query = "SELECT * FROM categories";

    $run_query = mysqli_query($con, $category_query) or die(mysqli_error($con));
    echo "
		
            
            <div class='aside'>
							<h3 style='text-align:left; justify-content:center;' class='aside-title'>Categories</h3>
							<div class = 'btn-group-vertical'>
	";
    if (mysqli_num_rows($run_query) > 0) {
        $i = 1;
        while ($row = mysqli_fetch_array($run_query)) {

            $cid = $row["cat_ID"];
            $cat_name = $row["cat_title"];
            $sql = "SELECT COUNT(*) AS count_items FROM products WHERE cat_ID=$i";
            $query = mysqli_query($con, $sql);
            $row = mysqli_fetch_array($query);
            $count = $row["count_items"];
            $i++;


            echo "
					
                    <div style='text-align:left; border-left:1px solid blue;' class='btn navbar-btn category' cid='$cid' >
									
									<a href='#'>
										<span  ></span>
										$cat_name
										<small class='qty'>($count)</small>
									
								</div>
								</a>
                    
			";

        }


        echo "</div>";
    }
}

if (isset($_POST["page"])) {
    $sql = "SELECT * FROM products";
    $run_query = mysqli_query($con, $sql);
    $count = mysqli_num_rows($run_query);
    $pageno = ceil($count / 9);
    for ($i = 1; $i <= $pageno; $i++) {
        echo "
			<li><a href='#product-row' page='$i' id='page' class='active'>$i</a></li>
            
            
		";
    }
}
if (isset($_POST["getProduct"])) {
    $limit = 9;
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
            $pro_id = $row['product_ID'];
            $pro_title = $row['product_name'];
            $pro_price = $row['product_price'];
            $pro_image = $row['product_image'];
            $cat_name = $row['cat_title'];

            echo "
                <div class='col-md-4 col-xs-6'>
                    <div class='product' style='border-radius:11px; box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);'>
                        <a href='product.php?p=$pro_id'>
                            <div class='product-img'>
                                <img src='product_images/$pro_image' style='max-height:170px; margin-top:15px;' alt=''>
                            </div>
                        </a>
                        <div class='product-body'>
                            <p style='font-size:10px;' class='product-category'>$cat_name</p>
                            <h3 style='height:70px;' class='product-name header-cart-item-name'>
                                <a href='product.php?p=$pro_id'>$pro_title</a>
                            </h3>
                            <h4 style='color:rgb(222,124,0);' class='product-price header-cart-item-info'>RM $pro_price</h4>
                        </div>
                        <a id='view' style='border-radius:0px; width:100%; outline:none; border:none;' class='btn btn-primary' href='product.php?p=$pro_id'>
                            <i class='fa fa-info'></i> View Details
                        </a>
                        <button pid='$pro_id' id='product' style='border-radius:0px 0px 11px 11px; width:100%; outline:none; border:none;' class='btn btn-warning prevent-select'>
                            <i class='fa fa-shopping-cart'></i> Add To Cart
                        </button>
                    </div>
                </div>
            ";
        }
    }
}


if (isset($_POST["get_seleted_Category"])) {
    if (isset($_POST["get_seleted_Category"])) {
        $id = mysqli_real_escape_string($con, $_POST["cat_id"]);
        $sql = "SELECT * FROM products 
             INNER JOIN categories ON products.cat_ID = categories.cat_ID 
             WHERE products.cat_ID = '$id'";

    }



    $run_query = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_array($run_query)) {
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
if (isset($_POST["addToCart"])) {
    $p_id = intval($_POST["proId"]);
    $ip_add = getenv("REMOTE_ADDR");

    if (!isset($_SESSION)) {
        session_start();
    }
    if (isset($_POST["addToCart"])) {
        $p_id = intval($_POST["proId"]);
        $ip_add = getenv("REMOTE_ADDR");

        if (!isset($_SESSION)) {
            session_start();
        }

        if (isset($_SESSION["uid"])) {
            // For logged-in users
            $user_id = intval($_SESSION["uid"]);

            $check_query = "SELECT * FROM Carts WHERE product_ID = '$p_id' AND cust_ID = '$user_id'";
            $run_query = mysqli_query($con, $check_query);

            if (mysqli_num_rows($run_query) > 0) {
                alertMessage('warning', 'Product is already added into the cart!');
            } else {
                $insert_query = "INSERT INTO Carts (product_ID, IP_Address, cust_ID, qty) 
                                 VALUES ('$p_id', '$ip_add', '$user_id', 1)";
                if (mysqli_query($con, $insert_query)) {
                    alertMessage('success', 'Product is added into your cart successfully!');
                }
            }

        } else {

            if (!isset($_SESSION['guest_cart'])) {
                $_SESSION['guest_cart'] = array();
            }

            if (in_array($p_id, $_SESSION['guest_cart'])) {
                alertMessage('warning', 'Product is already added into the cart!');
            } else {
                $_SESSION['guest_cart'][] = $p_id;
                $_SESSION['cart_expiration'] = time() + 1800;


                $insert_query = "INSERT INTO Carts (product_ID, IP_Address, cust_ID, qty) 
                                 VALUES ('$p_id', '$ip_add', NULL, 1)";
                if (mysqli_query($con, $insert_query)) {
                    alertMessage('success', 'Product is added into your cart successfully!');
                }
            }
        }



    }
}
function alertMessage($type, $message)
{
    echo "
        <script>
const targetElement = document.getElementById('product_msg');


targetElement.scrollIntoView({ behavior: 'smooth' });

const targetOffset = targetElement.getBoundingClientRect().top + window.scrollY;


window.scrollTo({
  top: targetOffset - 50, 
  behavior: 'smooth'      
});


        </script>
        <div class='alert alert-$type'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <b>$message</b>
        </div>
    ";
}

if (isset($_POST["count_item"])) {
    if (isset($_SESSION["uid"])) {
        $uid = intval($_SESSION["uid"]);
        $sql = "SELECT COUNT(*) AS count_item FROM carts WHERE cust_ID = $uid";
    } else {
        $ip_add = mysqli_real_escape_string($con, $ip_add);
        $sql = "SELECT COUNT(*) AS count_item FROM carts WHERE IP_Address = '$ip_add' AND cust_ID IS NULL";
    }

    $query = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($query);
    echo $row["count_item"];
    exit();
}



if (isset($_POST["Common"])) {

    $ip_add = getenv("REMOTE_ADDR");

    if (isset($_SESSION["uid"])) {
        $user_id = $_SESSION["uid"];
        $sql = "SELECT p.product_ID, p.product_name, p.product_price, p.product_desc, p.product_image, c.cart_ID, c.qty 
                FROM Products p
                JOIN Carts c ON p.product_ID = c.product_ID
                WHERE c.cust_ID = '$user_id'";
    } else {
        $sql = "SELECT p.product_ID, p.product_name, p.product_price, p.product_desc, p.product_image, c.cart_ID, c.qty 
                FROM Products p
                JOIN Carts c ON p.product_ID = c.product_ID
                WHERE c.IP_Address = '$ip_add' AND c.cust_ID IS NULL";
    }

    $query = mysqli_query($con, $sql);

    if (isset($_POST["getCartItem"])) {
        if (mysqli_num_rows($query) > 0) {
            $n = 0;
            $total_price = 0;

            while ($row = mysqli_fetch_array($query)) {
                $n++;
                $product_id = $row["product_ID"];
                $product_title = $row["product_name"];
                $product_price = $row["product_price"];
                $product_image = $row["product_image"];
                $cart_item_id = $row["cart_ID"];
                $qty = $row["qty"];
                $total_price += ($product_price * $qty);

                echo '
                <div class="product-widget justify-content-between align-items-center" style="display: flex; align-items: center;">
                    <div class="product-img prevent-select" style="margin-top: 10px; flex-shrink: 0;">
                        <img src="product_images/' . $product_image . '" alt="" style="width: 50px; height: 50px;">
                    </div>
                    <div class="product-body prevent-select">
                        <h3 class="product-name"><a href="product.php?p=' . $product_id . '">' . $product_title . '</a></h3>
                        <h4 class="product-price"><span class="qty">' . $qty . '</span> x RM ' . number_format($product_price, 2) . '</h4>
                    </div>
                    <form action="action.php" method="POST" style="display:inline;">
                        <input type="hidden" name="rid" value="' . $product_id . '">
                        <input type="hidden" name="referrer" value="' . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '') . '">
                        <button type="submit" class="product-price remove2" id="remove2" style="background: none; border: none; font-size: 20px; color: red;">×</button>
                    </form>
                </div>
                <hr>
                ';
            }

            echo '
            <div class="cart-summary align-items-center">
                <small class="qty">' . $n . ' Item(s) selected</small>
                <h5>Total: RM ' . number_format($total_price, 2) . '</h5>
            </div>';
            exit();
        } else {
            echo '
            <div class="cart-summary align-items-center">
                <small class="qty">0 Item selected</small>
                <h5>Total: RM 0.00</h5>
            </div>';
            exit();
        }
    }







    if (isset($_POST["checkOutDetails"])) {
        if (mysqli_num_rows($query) > 0) {



            echo '
			
			<div class="shopping-cart">
			 <div class="title">Shopping Cart</div>
			<form method="post" action="login_form.php">
			
	
                    ';
            $n = 0;
            while ($row = mysqli_fetch_array($query)) {


                $n++;
                $product_id = $row["product_ID"];
                $product_title = $row["product_name"];
                $product_desc = $row["product_desc"];
                $product_price = $row["product_price"];
                $product_image = $row["product_image"];
                $cart_item_id = $row["cart_ID"];
                $qty = $row["qty"];


                echo '
						<div class="item">
							 <input type="hidden" class="price" value="' . $product_price . '">
							<div class="image">
								<a href="product.php?p=' . $product_id . '"><img src="product_images/' . $product_image . '" width="80" height="80" alt="' . $product_title . '" /></a>
							</div>
					
							<div class="description product-name">
								<a href="product.php?p=' . $product_id . '">' . $product_title . '</a>
								<span style="font-size:10px;">' . $product_desc . '</span>
							</div>
					
							<div class="quantity">
								<button class="plus-btn update" update_id="' . $product_id . '" type="button">+</button>
								<input type="text" class="qty" value="' . $qty . '" />
								<button class="minus-btn update" update_id="' . $product_id . '"  type="button">-</button>
							</div>
				
							    <div class="total-price">
            <span class="currency">RM</span>
            <span class="item-price">' . number_format($product_price, 2) . '</span>
        </div>
        
        <div class="total-price">
            <span class="currency">RM</span>
            <span class="item-total">' . number_format($product_price * $qty, 2) . '</span>
        </div>
					
							<div class="buttons">
								<a class="delete-btn update" style="color:black; margin-right:15px;" update_id="' . $product_id . '"><i class="fa fa-refresh"></i></a>
								<a class="delete-btn remove" remove_id="' . $product_id . '"><i class="fa fa-trash-o"></i></a>
							</div>
						</div>
						
						';



            }




            echo '
			</div>	

<div class="shopping-cart">
  <div class="subtotal">
    <span class="subtotal-label">Subtotal</span>
	  <span class="subtotal-amount">
	  <span class="currency">RM</span>
    <span id="subtotal_display"  class="value"></span>
	</span>
  </div>
  <div class="subtotal">
    <span class="subtotal-label">Tax (6%)</span>
	  <span class="subtotal-amount">
	  <span class="currency">RM</span>
    <span id="tax_display"  class="value prevent-select"></span>
	</span>
  </div>
  <hr style="border:1px solid black;">
  <div class="subtotal">
    <span class="subtotal-label">Total</span>
	<span class="subtotal-amount">
	  <span class="currency">RM</span>
    <span id="total_display" class="value"></span>
	</span>
  </div>
</div>

		
			    </form>				
							';
            if (!isset($_SESSION["uid"])) {
                echo '
            
<form action="checkout.php" id="checkoutForm" method="post">
							<input type="hidden" name="cmd" value="_cart">
							<input type="hidden" name="business" value="shoppingcart@gradvibes.com">
							<input type="hidden" name="upload" value="1">';

                $x = 0;
                $sql = "SELECT a.product_ID, a.product_name, a.product_price, a.product_image, b.cart_ID, b.qty 
                            FROM products a, carts b 
                            WHERE a.product_ID = b.product_ID AND b.cust_ID IS NULL";

                $query = mysqli_query($con, $sql);
                while ($row = mysqli_fetch_array($query)) {
                    $x++;
                    echo '
                                    <input type="hidden" name="total_count" value="' . $x . '">
                                    <input type="hidden" name="item_name_' . $x . '" value="' . $row["product_name"] . '">
                                    <input type="hidden" name="item_number_' . $x . '" value="' . $x . '">
                                    <input type="hidden" name="amount_' . $x . '" value="' . $row["product_price"] . '">
                                    <input type="hidden" name="quantity_' . $x . '" value="' . $row["qty"] . '">';
                }

                echo
                    '<input type="hidden" id="stotal_input" name="stotal">
							 <input type="hidden" id="total_input" name="total_price">
							<input type="hidden" id="totaltax_input" name="tax">
							
								<input type="hidden" name="return" value="http://localhost/myfiles/public_html/payment_success.php"/>
					                <input type="hidden" name="notify_url" value="http://localhost/myfiles/public_html/payment_success.php">
									<input type="hidden" name="cancel_return" value="http://localhost/myfiles/public_html/cancel.php"/>
									<input type="hidden" name="currency_code" value="MYR"/>
									<input type="hidden" name="custom" value="Guest"/>
									<div class="shopping-cart buttoncheckout" style="margin-top:-50px; display: flex; justify-content: space-between; align-items: center;">
  <a href="store.php" class="btn btn-warning">
    <i class="fa fa-angle-left"></i> Continue Shopping
  </a>
  <button type="submit" id="submit" name="submit"  name="login_user_with_product" class="btn btn-success btnready">
  Ready to Checkout <i class="fa fa-angle-right"></i>
</button>

</div>

				</form>	';
            } else if (isset($_SESSION["uid"])) {
                //Paypal checkout form
                echo '
					
					
						<form action="checkout.php" id="checkoutForm" method="post">
							<input type="hidden" name="cmd" value="_cart">
							<input type="hidden" name="business" value="shoppingcart@gradvibes.com">
							<input type="hidden" name="upload" value="1">';

                $x = 0;
                $sql = "SELECT a.product_ID, a.product_name, a.product_price, a.product_image, b.cart_ID, b.qty 
                                    FROM products a, carts b 
                                    WHERE a.product_ID = b.product_ID AND b.cust_ID = '$_SESSION[uid]'";
                $query = mysqli_query($con, $sql);
                while ($row = mysqli_fetch_array($query)) {
                    $x++;
                    echo '
                                    <input type="hidden" name="total_count" value="' . $x . '">
                                    <input type="hidden" name="item_name_' . $x . '" value="' . $row["product_name"] . '">
                                    <input type="hidden" name="item_number_' . $x . '" value="' . $x . '">
                                    <input type="hidden" name="amount_' . $x . '" value="' . $row["product_price"] . '">
                                    <input type="hidden" name="quantity_' . $x . '" value="' . $row["qty"] . '">';
                }

                echo
                    '<input type="hidden" id="stotal_input" name="stotal">
							 <input type="hidden" id="total_input" name="total_price">
							<input type="hidden" id="totaltax_input" name="tax">
							
								<input type="hidden" name="return" value="http://localhost/myfiles/public_html/payment_success.php"/>
					                <input type="hidden" name="notify_url" value="http://localhost/myfiles/public_html/payment_success.php">
									<input type="hidden" name="cancel_return" value="http://localhost/myfiles/public_html/cancel.php"/>
									<input type="hidden" name="currency_code" value="MYR"/>
									<input type="hidden" name="custom" value="' . $_SESSION["uid"] . '"/>
									<div class="shopping-cart buttoncheckout" style="margin-top:-50px; display: flex; justify-content: space-between; align-items: center;">
  <a href="store.php" class="btn btn-warning">
    <i class="fa fa-angle-left"></i> Continue Shopping
  </a>
  <button type="submit" id="submit" name="submit"  name="login_user_with_product" class="btn btn-success btnready">
  Ready to Checkout <i class="fa fa-angle-right"></i>
</button>

</div>
									</form>
									

								';
            }
        } else {
            echo '
<div class="shopping-cart">
 Your cart is empty!<br><br><br>
  <a href="store.php" class="btn btn-warning">
    <i class="fa fa-angle-left"></i> Continue Shopping
  </a>
</div>';
        }
    }


}
if (isset($_POST["rid"])) {
    $referrer = isset($_POST["referrer"]) ? $_POST["referrer"] : 'store.php';
    $remove_id = (int) $_POST["rid"];

    $ip_add = $_SERVER['REMOTE_ADDR'];

    if (isset($_SESSION["uid"])) {
        // Logged-in user
        $stmt = mysqli_prepare($con, "DELETE FROM carts WHERE product_ID = ? AND cust_ID = ?");
        mysqli_stmt_bind_param($stmt, "ii", $remove_id, $_SESSION["uid"]);
    } else {
        // Guest user
        $stmt = mysqli_prepare($con, "DELETE FROM carts WHERE product_ID = ? AND IP_Address = ? AND cust_ID IS NULL");
        mysqli_stmt_bind_param($stmt, "is", $remove_id, $ip_add);
    }

    if ($stmt && mysqli_stmt_execute($stmt)) {
        header("Location: " . $referrer);
        exit();
    } else {
        header("Location: cart.php?error=true");
        exit();
    }
}



if (isset($_POST["removeItemFromCart"])) {
    $remove_id = (int) $_POST["rid"];

    if (isset($_SESSION["uid"])) {
        $stmt = mysqli_prepare($con, "DELETE FROM Carts WHERE product_ID = ? AND cust_ID = ?");
        mysqli_stmt_bind_param($stmt, "ii", $remove_id, $_SESSION["uid"]);
    } else {
        $stmt = mysqli_prepare($con, "DELETE FROM Carts WHERE product_ID = ? AND IP_Address = ? AND cust_ID IS NULL");
        mysqli_stmt_bind_param($stmt, "is", $remove_id, $ip_add);
    }

    if ($stmt && mysqli_stmt_execute($stmt)) {
        echo "<div class='alert alert-danger'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <b>Product is removed from cart</b>
              </div>";
        exit();
    }
}

if (isset($_POST["updateCartItem"])) {
    $update_id = (int) $_POST["update_id"];
    $qty = (int) $_POST["qty"];

    if ($qty > 0 && $qty <= 99) {
        if (isset($_SESSION["uid"])) {
            $stmt = mysqli_prepare($con, "UPDATE carts SET qty = ? WHERE product_ID = ? AND cust_ID = ?");
            mysqli_stmt_bind_param($stmt, "iii", $qty, $update_id, $_SESSION["uid"]);
        } else {
            $stmt = mysqli_prepare($con, "UPDATE carts SET qty = ? WHERE product_ID = ? AND IP_Address = ? AND cust_ID IS NULL");
            mysqli_stmt_bind_param($stmt, "iis", $qty, $update_id, $ip_add);
        }

        if ($stmt && mysqli_stmt_execute($stmt)) {
            echo "<div class='alert alert-info'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <b>Product is updated</b>
                  </div>";
            exit();
        }
    }
}


// Update Multiple Quantities In Cart
if (isset($_POST["updateQuantities"])) {
    $updatedQuantities = json_decode($_POST["updatedQuantities"], true);

    foreach ($updatedQuantities as $item) {
        $productId = (int) $item['productId'];
        $quantity = (int) $item['quantity'];

        if ($quantity > 0 && $quantity <= 99) {
            if (isset($_SESSION["uid"])) {
                $stmt = mysqli_prepare($con, "UPDATE Carts SET qty = ? WHERE product_ID = ? AND cust_ID = ?");
                mysqli_stmt_bind_param($stmt, "iii", $quantity, $productId, $_SESSION["uid"]);
            } else {
                $stmt = mysqli_prepare($con, "UPDATE Carts SET qty = ? WHERE product_ID = ? AND IP_Address = ? AND cust_ID IS NULL");
                mysqli_stmt_bind_param($stmt, "iis", $quantity, $productId, $ip_add);
            }

            if (!$stmt || !mysqli_stmt_execute($stmt)) {
                echo "Error updating cart item with ID: $productId";
                exit();
            }
        }
    }

    echo "update_success";
}
?>
