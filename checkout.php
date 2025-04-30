<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['total_count'])) {
    header("Location: cart.php");
    exit();
}


include "db.php";

include "header.php";


                         
?>

<style>

.row-checkout {
  display: -ms-flexbox; /* IE10 */
  display: flex;
  -ms-flex-wrap: wrap; /* IE10 */
  flex-wrap: wrap;
  margin: 0 -16px;
}

.col-25 {
  -ms-flex: 25%; /* IE10 */
  flex: 25%;
}

.col-50 {
  -ms-flex: 50%; /* IE10 */
  flex: 50%;
}

.col-75 {
  -ms-flex: 75%; /* IE10 */
  flex: 75%;
}

.col-25,
.col-50,
.col-75 {
  padding: 0 16px;
}

body{
	overflow-x: hidden; 
}

.container-checkout {
  background-color: #f2f2f2;
  padding: 5px 20px 15px 20px;
  border: 1px solid lightgrey;
  border-radius: 6px;
}

input[type=text] {
  width: 100%;
  margin-bottom: 20px;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 3px;
}

label {
  margin-bottom: 10px;
  display: block;
}

.icon-container {
  margin-bottom: 20px;
  padding: 7px 0;
  font-size: 24px;
}

.checkout-btn {
  background-color: #4CAF50;
  color: white;
  padding: 12px;
  margin: 10px 0;
  border: none;
  width: 100%;
  border-radius: 3px;
  cursor: pointer;
  font-size: 17px;
}

.checkout-btn:hover {
  background-color: #45a049;
}



hr {
  border: 1px solid lightgrey;
}

span.price {
  float: right;
  color: grey;
}

@media (max-width: 800px) {
  .row-checkout {
    flex-direction: column-reverse;
  }
  .col-25 {
    margin-bottom: 20px;
  }
}
</style>

					
<section class="section">       
    <div class="container-fluid">
        <div class="row-checkout">
        <?php

	   if (isset($_SESSION["uid"])) {
		   $user_id = mysqli_real_escape_string($con, $_SESSION["uid"]);
		   $customer_query = mysqli_query($con, "SELECT * FROM customers WHERE cust_ID = '$user_id'");
		   $customer_row = mysqli_fetch_array($customer_query);
	   
		   $address_query = mysqli_query($con, "SELECT * FROM addresses WHERE cust_id = '$user_id'");
	   
		   echo '
		   <div class="col-75">
			   <div class="container-checkout">
			   <form id="checkout_form" action="checkout_process.php" method="POST" class="was-validated">
	   
				   <div class="row-checkout" style="margin-top: 15px; margin-bottom: 15px;">
				   
				   <div class="col-50">
					   <h3>Billing Address</h3>
					   <hr>
					   <label for="addressSelect"><i class="fa fa-map-marker"></i> Select Address</label>
					   <select id="addressSelect" style="margin-bottom:20px;" class="form-control" onchange="fillAddress()">
						   <option value="">Select Address</option>';
						   
						   while ($address_row = mysqli_fetch_array($address_query)) {
							$full_address = htmlspecialchars($address_row['address1']);
							$full_address2 = htmlspecialchars($address_row['address2']);
							$city = htmlspecialchars($address_row['city']);
							$state = htmlspecialchars($address_row['state']);
							$zip = htmlspecialchars($address_row['zip']);
						
							echo "<option 
									value='$full_address, $full_address2'
									data-address='$full_address, $full_address2'
									data-address1='$full_address'
									data-address2='$full_address2'
									data-city='$city'
									data-state='$state'
									data-zip='$zip'>
									$full_address, $city, $state $zip
								  </option>";
						}
						
	   
		   echo '
					   </select>

                        <label for="fname"><i class="fa fa-user"></i> Full Name</label>
                        <input type="text" id="fname" class="form-control" name="firstname" pattern="^[a-zA-Z ]+$" value="' . htmlspecialchars($customer_row["first_name"] . " " . $customer_row["last_name"]) . '" required>
                        
                        <label for="email"><i class="fa fa-envelope"></i> Email</label>
                        <input type="text" id="email" name="email" class="form-control" pattern="^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9]+(\.[a-z]{2,4})$" value="' . htmlspecialchars($customer_row["email"]) . '" required>

                        <label for="adr"><i class="fa fa-address-card-o"></i> Address</label>
                        <input type="hidden" id="adr" name="address" class="form-control">
						   <input type="text" id="adr1" name="address1" class="form-control" >
						      <input type="text" id="adr2" name="address2" class="form-control">

                        <label for="city"><i class="fa fa-institution"></i> City</label>
                        <input type="text" id="city" name="city" class="form-control" pattern="^[a-zA-Z ]+$" required>

                        <div class="row">
                        <div class="col-50">
                            <label for="state">State</label>
                            <input type="text" id="state" name="state" class="form-control" pattern="^[a-zA-Z ]+$" required>
                        </div>
                        <div class="col-50">
                            <label for="zip">Zip</label>
                            <input type="text" id="zip" name="zip" class="form-control" pattern="^\d{4,5}$" required>
                        </div>
                        </div>
                    </div>

                    <div class="col-50">
                        <h3>Payment</h3>
                        <hr>
						<div id="payment-error" style="color: red; margin-top: 10px;"></div>

                        <label for="fname">Accepted Cards</label>
                        <div class="icon-container">
                        <i class="fa fa-cc-visa" style="color:navy;"></i>
                        <i class="fa fa-cc-amex" style="color:blue;"></i>
                        <i class="fa fa-cc-mastercard" style="color:red;"></i>
                        <i class="fa fa-cc-discover" style="color:orange;"></i>
                        </div>
                        
                        <label for="cname">Name on Card</label>
                        <input type="text" id="cname" name="cardname" class="form-control" pattern="^[a-zA-Z ]+$" required>

                       <label for="cardnum">Card Number</label>
<input type="text" id="cardnum" name="cardNumber" class="form-control" required pattern="^\d{16}$" title="Card number must be exactly 16 digits and no space" maxlength="16">

                        <label for="expdate">Exp Date</label>
                      <input type="text" id="expdate" name="expdate" class="form-control" pattern="^(0[1-9]|1[0-2])\/\d{2}$" placeholder="MM/YY" required>


                        <label for="cvv">CVV</label>
                        <input type="text" id="cvv" name="cvv" class="form-control" required>
                    </div>
                    </div>

                    <label><input type="checkbox" name="same_address" required> Shipping address same as billing</label>';
				
                    // Product Loop
                    $i = 1;
                    $total = 0;
                    $total_count = $_POST['total_count'];
                    $total_price2 = $_POST['total_price'];
                    while ($i <= $total_count) {
                        $item_name = mysqli_real_escape_string($con, $_POST['item_name_' . $i]);
                        $amount = $_POST['amount_' . $i];
                        $quantity = $_POST['quantity_' . $i];

                        $productQuery = mysqli_query($con, "SELECT product_ID FROM products WHERE product_name = '$item_name'");
                        $productRow = mysqli_fetch_array($productQuery);
                        $product_id = $productRow["product_ID"];

                        echo "
                        <input type='hidden' name='prod_id_$i' value='$product_id'>
                        <input type='hidden' name='prod_price_$i' value='$amount'>
                        <input type='hidden' name='prod_qty_$i' value='$quantity'>
                        ";
                        $i++;
                    }

				      echo '
                    <input type="hidden" name="total_count" value="'.$total_count.'">
                    
                    <input type="hidden" name="total_price" value="'.$total_price2.'">

                    <input type="submit" id="submit" value="Proceed" class="checkout-btn">
                </form>
                </div>
            </div>';
        } else {
      
        
          echo '
           
          <div class="col-75">
            <div class="container-checkout">
            <form id="checkout_form" action="checkout_process.php" method="POST" class="was-validated">
        
              <div class="row-checkout" style="margin-top: 15px; margin-bottom: 15px;">
              
              <div class="col-50">
                <h3>Billing Address</h3>
                <hr>
          ';
               
        
          echo '
               
   
                           <label for="fname"><i class="fa fa-user"></i> Full Name</label>
                           <input type="text" id="fname" class="form-control" name="firstname" pattern="^[a-zA-Z ]+$" required>
                           
                           <label for="email"><i class="fa fa-envelope"></i> Email</label>
                           <input type="text" id="email" name="email" class="form-control" pattern="^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9]+(\.[a-z]{2,4})$" required>
   
                           <label for="adr"><i class="fa fa-address-card-o"></i> Address</label>
                           <input type="hidden" id="adr" name="address" class="form-control">
                  <input type="text" id="adr1" name="address1" class="form-control" >
                     <input type="text" id="adr2" name="address2" class="form-control">
   
                           <label for="city"><i class="fa fa-institution"></i> City</label>
                           <input type="text" id="city" name="city" class="form-control" pattern="^[a-zA-Z ]+$" required>
   
                           <div class="row">
                           <div class="col-50">
                               <label for="state">State</label>
                               <input type="text" id="state" name="state" class="form-control" pattern="^[a-zA-Z ]+$" required>
                           </div>
                           <div class="col-50">
                               <label for="zip">Zip</label>
                               <input type="text" id="zip" name="zip" class="form-control" pattern="^\d{4,5}$" required>
                           </div>
                           </div>
                       </div>
   
                       <div class="col-50">
                           <h3>Payment</h3>
                           <hr>
               <div id="payment-error" style="color: red; margin-top: 10px;"></div>
   
                           <label for="fname">Accepted Cards</label>
                           <div class="icon-container">
                           <i class="fa fa-cc-visa" style="color:navy;"></i>
                           <i class="fa fa-cc-amex" style="color:blue;"></i>
                           <i class="fa fa-cc-mastercard" style="color:red;"></i>
                           <i class="fa fa-cc-discover" style="color:orange;"></i>
                           </div>
                           
                           <label for="cname">Name on Card</label>
                           <input type="text" id="cname" name="cardname" class="form-control" pattern="^[a-zA-Z ]+$" required>
   
                          <label for="cardnum">Card Number</label>
   <input type="text" id="cardnum" name="cardNumber" class="form-control" required pattern="^\d{16}$" title="Card number must be exactly 16 digits and no space" maxlength="16">
   
                           <label for="expdate">Exp Date</label>
                         <input type="text" id="expdate" name="expdate" class="form-control" pattern="^(0[1-9]|1[0-2])\/\d{2}$" placeholder="MM/YY" required>
   
   
                           <label for="cvv">CVV</label>
                           <input type="text" id="cvv" name="cvv" class="form-control" required>
                       </div>
                       </div>
   
                       <label><input type="checkbox" name="same_address" required> Shipping address same as billing</label>
                     ';
                     
                       // Product Loop
                       $i = 1;
                       $total = 0;
                       $total_count = $_POST['total_count'];
                       $total_price2 = $_POST['total_price'];
                       while ($i <= $total_count) {
                           $item_name = mysqli_real_escape_string($con, $_POST['item_name_' . $i]);
                           $amount = $_POST['amount_' . $i];
                           $quantity = $_POST['quantity_' . $i];
   
                           $productQuery = mysqli_query($con, "SELECT product_ID FROM products WHERE product_name = '$item_name'");
                           $productRow = mysqli_fetch_array($productQuery);
                           $product_id = $productRow["product_ID"];
   
                           echo "
                           <input type='hidden' name='prod_id_$i' value='$product_id'>
                           <input type='hidden' name='prod_price_$i' value='$amount'>
                           <input type='hidden' name='prod_qty_$i' value='$quantity'>
                           ";
                           $i++;
                       }
   
                 echo '
                       <input type="hidden" name="total_count" value="'.$total_count.'">
                       <input type="hidden" name="total_price" value="'.$total_price2.'">
   
                       <input type="submit" id="submit" value="Proceed" class="checkout-btn">
                   </form>
                   </div>
               </div>';
        }
        ?>

			<div class="col-25">
				<div class="container-checkout">
				
				<?php
				if (isset($_POST["cmd"])) {
				
					$user_id = $_POST['custom'];
					
					
					$i=1;
					echo
					"
					<h4>Cart 
					<span class='price' style='color:black'>
					<i class='fa fa-shopping-cart'></i> 
					<b>$total_count</b>
					</span>
				</h4>

					<table class='table table-condensed'>
					<thead><tr>
					<th>No</th>
					<th>Product Name</th>
					<th>Qty</th>
					<th>Total(RM)</th></tr>
					</thead>
					<tbody>
					";
					$total_price=$_POST['total_price'];
					$stotal_price=$_POST['stotal'];
					$tax_price=$_POST['tax'];
					$total=0;
					while($i<=$total_count){
						$item_name_ = $_POST['item_name_'.$i];
						
						$item_number_ = $_POST['item_number_'.$i];
						
						$amount_ = $_POST['amount_'.$i];
						
						$quantity_ = $_POST['quantity_'.$i];
						$total=$total+$amount_ ;
						$sql = "SELECT product_ID FROM products WHERE product_name='$item_name_'";
						$query = mysqli_query($con,$sql);
						$row=mysqli_fetch_array($query);
						$product_id=$row["product_ID"];
					
						echo "	

						<tr><td><p>$item_number_</p></td><td><p>$item_name_</p></td><td ><p>$quantity_</p></td><td ><p>$amount_</p></td></tr>";
						
						$i++;
					}

				echo"

				</tbody>
				</table>
				<hr>
					<h4>Subtotal<span class='price' style='color:black'><b>RM $stotal_price</b></span></h4>
						<h4>Tax (6%)<span class='price' style='color:black'><b>RM $tax_price</b></span></h4>
				<h4>Total<span class='price' style='color:black'><b>RM $total_price</b></span></h4>";
					
				}
				?>
				</div>
			</div>
		</div>
	</div>
</section>
<script>
 
		
function fillAddress() {
    var select = document.getElementById('addressSelect');
    var selectedOption = select.options[select.selectedIndex];

    if (selectedOption.value) {
        document.getElementById('adr').value = selectedOption.getAttribute('data-address');
		document.getElementById('adr1').value = selectedOption.getAttribute('data-address1');
		document.getElementById('adr2').value = selectedOption.getAttribute('data-address2');
        document.getElementById('city').value = selectedOption.getAttribute('data-city');
        document.getElementById('state').value = selectedOption.getAttribute('data-state');
        document.getElementById('zip').value = selectedOption.getAttribute('data-zip');
    } else {
        document.getElementById('adr').value = "";
		document.getElementById('adr1').value  = "";
		document.getElementById('adr2').value = "";
        document.getElementById('city').value = "";
        document.getElementById('state').value = "";
        document.getElementById('zip').value = "";
    }
}


document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form'); 
    form.addEventListener('submit', function(event) {
        let isValid = true;
        let errorMessages = [];

        const cardNumber = document.getElementById('cardnum').value.trim();
        const cvv = document.getElementById('cvv').value.trim();
        const expdate = document.getElementById('expdate').value.trim();

       

        if (!/^\d{3,4}$/.test(cvv)) {
            isValid = false;
            errorMessages.push("CVV must be 3 or 4 digits.");
        }

        if (!/^(0[1-9]|1[0-2])\/\d{2}$/.test(expdate)) {
            isValid = false;
            errorMessages.push("Expiration date must be in MM/YY format.");
        }

        if (!isValid) {
            event.preventDefault();
            const errorDiv = document.getElementById('payment-error');
            errorDiv.innerHTML = errorMessages.join("<br>");

            errorDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
	 const expDateInput = document.getElementById('expdate');
    expDateInput.addEventListener('input', function() {
        let value = expDateInput.value.replace(/\D/g, '');  

        if (value.length >= 3) {
            value = value.substring(0, 2) + '/' + value.substring(2, 4);
        }

        expDateInput.value = value;
    });

	   const cardNumberInput = document.getElementById('cardnum');
    cardNumberInput.addEventListener('input', function() {
        let value = cardNumberInput.value.replace(/\D/g, ''); 

 
        cardNumberInput.value = value;
    });

	
    // // // Disable pasting into the card number input
    // cardNumberInput.addEventListener('paste', function(e) {
    //     e.preventDefault(); 
    //     alert("Pasting is disabled for card number input.");
    // });
});


</script>

<?php
include "footer.php";
?>