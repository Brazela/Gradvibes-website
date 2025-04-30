<?php
session_start();
include('db.php');

$ip_add = getenv("REMOTE_ADDR"); 


if (isset($_SESSION['cart_expiration']) && time() > $_SESSION['cart_expiration']) {

    if (isset($_SESSION['guest_cart'])) {
        foreach ($_SESSION['guest_cart'] as $product_id) {
            $remove_query = "DELETE FROM Carts WHERE product_ID = '$product_id' AND IP_Address = '$ip_add' AND cust_ID IS NULL";
            mysqli_query($con, $remove_query);
        }
        unset($_SESSION['guest_cart']);
        unset($_SESSION['cart_expiration']);
     
        echo 'expired';
    }
} else {
 
    echo 'active';
}
?>
