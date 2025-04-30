<?php
include "db.php";
session_start();

if (isset($_POST["email"]) && isset($_POST["password"])) {
    $email = mysqli_real_escape_string($con, $_POST["email"]);
    $password = $_POST["password"];

    $sql = "SELECT * FROM customers WHERE email = '$email' AND password = '$password'";
    $run_query = mysqli_query($con, $sql);
    $count = mysqli_num_rows($run_query);
	if ($count == 1) {
		$row = mysqli_fetch_array($run_query);
	
		if ($row) {
			$_SESSION["uid"] = $row["cust_ID"];
			$_SESSION["name"] = $row["first_name"];
			$IP_Address = getenv("REMOTE_ADDR");
	
			$guest_cart_query = "SELECT * FROM carts WHERE cust_ID IS NULL AND IP_Address = '$IP_Address'";
			$guest_cart_result = mysqli_query($con, $guest_cart_query);
	
			if (mysqli_num_rows($guest_cart_result) > 0) {
				while ($item = mysqli_fetch_assoc($guest_cart_result)) {
					$product_id = $item["product_ID"];
	
					$verify_cart = "SELECT cart_ID FROM carts WHERE cust_ID = $_SESSION[uid] AND product_ID = $product_id";
					$result = mysqli_query($con, $verify_cart);
	
					if (mysqli_num_rows($result) < 1) {
						$update_cart = "UPDATE carts SET cust_ID = '$_SESSION[uid]' WHERE IP_Address = '$IP_Address' AND cust_ID IS NULL AND product_ID = $product_id";
						mysqli_query($con, $update_cart);
					} else {
						// If already exists, remove the guest one
						$delete_existing_product = "DELETE FROM carts WHERE cust_ID IS NULL AND IP_Address = '$IP_Address' AND product_ID = $product_id";
						mysqli_query($con, $delete_existing_product);
					}
				}
	
				echo "cart_login";
				exit();
			}
	
			echo "login_success";
			exit();
		}
	

    }  else {
            // Login failed
			echo "<div class='alert alert-danger alert-dismissible show' role='alert'>
			Invalid email or password!
		</div>";
		exit();
		
        }
    }

?>
