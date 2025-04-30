<?php
session_start();
include "db.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['total_count'])) {
    header("Location: cart.php");
    exit();
}

if (isset($_SESSION["uid"])) {


    $cust_ID = $_SESSION["uid"];
    $firstname = $_POST["firstname"];
    $email = $_POST['email'];
    $address1 = $_POST['address1'];
    $address2 = $_POST['address2'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $cardname = $_POST['cardname'];
    $cardnumber = $_POST['cardNumber'];
    $expdate = $_POST['expdate'];
    $cvv = $_POST['cvv'];
    $total_count = $_POST['total_count'];
    $prod_total = $_POST['total_price'];

    $current_date = date("Ymd");
    $random_digits = str_pad(rand(0, 999999), 6, "0", STR_PAD_LEFT);
    $trx_ID = "TRX" . $current_date . $random_digits;

    $check_address = "SELECT address_ID FROM addresses 
                      WHERE cust_ID = '$cust_ID' 
                      AND address1 = '$address1' 
                      AND address2 = '$address2' 
                      AND city = '$city' 
                      AND state = '$state' 
                      AND zip = '$zip' 
                      LIMIT 1";

    $result = mysqli_query($con, $check_address);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $address_ID = $row['address_ID'];

        echo "Address already exists with Address ID: $address_ID";
    } else {
        $insert_address = "INSERT INTO addresses (cust_ID, address1, address2, city, state, zip) 
                           VALUES ('$cust_ID', '$address1', '$address2', '$city', '$state', '$zip')";
        if (mysqli_query($con, $insert_address)) {
            $address_ID = mysqli_insert_id($con);
        } else {
            die("Failed to insert address: " . mysqli_error($con));
        }
    }

    $check_payment_method = "SELECT payment_mtd_id FROM paymentmethod 
WHERE cardnumber = '$cardnumber' 
LIMIT 1";
    $payment_method_result = mysqli_query($con, $check_payment_method);

    if (mysqli_num_rows($payment_method_result) > 0) {
        $row = mysqli_fetch_assoc($payment_method_result);
        $payment_mtd_id = $row['payment_mtd_id'];
    } else {
        $insert_payment_method = "INSERT INTO paymentmethod (cardname, cardnumber, expdate, cvv) 
     VALUES ('$cardname', '$cardnumber', '$expdate', '$cvv')";
        if (mysqli_query($con, $insert_payment_method)) {
            $payment_mtd_id = mysqli_insert_id($con);
        } else {
            die("Failed to insert payment method: " . mysqli_error($con));
        }
    }

    // Prepare the insert query for payments
    $insert_payment = "INSERT INTO payments (cust_ID, address_ID, prod_count, total_amt, payment_mtd_ID, trx_ID, p_status)
                   VALUES (?, ?, ?, ?, ?, ?, 'Completed')";

    $stmt = mysqli_prepare($con, $insert_payment);
    if ($stmt === false) {
        die("Failed to prepare payment insert query: " . mysqli_error($con));
    }

    // Bind the parameters
    mysqli_stmt_bind_param($stmt, "isidss", $cust_ID, $address_ID, $total_count, $prod_total, $payment_mtd_id, $trx_ID);

    if (mysqli_stmt_execute($stmt)) {
        $payment_ID = mysqli_insert_id($con);
    } else {
        die("Failed to insert payment: " . mysqli_error($con));
    }


    $get_cart = "SELECT * FROM carts WHERE cust_ID = $cust_ID";
    $cart_result = mysqli_query($con, $get_cart);

    $order_ID = null;

    if (mysqli_num_rows($cart_result) > 0) {
        while ($cart_row = mysqli_fetch_assoc($cart_result)) {
            $product_ID = $cart_row['product_ID'];
            $qty = $cart_row['qty'];


            $get_product = "SELECT product_price FROM products WHERE product_ID = ? LIMIT 1";
            $product_stmt = mysqli_prepare($con, $get_product);
            if ($product_stmt === false) {
                die("Failed to prepare product query: " . mysqli_error($con));
            }

            mysqli_stmt_bind_param($product_stmt, "i", $product_ID);
            mysqli_stmt_execute($product_stmt);
            mysqli_stmt_bind_result($product_stmt, $price);
            mysqli_stmt_fetch($product_stmt);

            mysqli_stmt_free_result($product_stmt);

            $totalPrice = $price * $qty;


            $insert_order = "INSERT INTO orders (cust_ID, product_ID, qty, totalPrice, payment_ID)
                         VALUES (?, ?, ?, ?, ?)";
            $order_stmt = mysqli_prepare($con, $insert_order);
            if ($order_stmt === false) {
                die("Failed to prepare order insert query: " . mysqli_error($con));
            }


            mysqli_stmt_bind_param($order_stmt, "iiidi", $cust_ID, $product_ID, $qty, $totalPrice, $payment_ID);
            if (mysqli_stmt_execute($order_stmt)) {
                // Get the order ID after successful insert
                $order_ID = mysqli_insert_id($con);
            } else {
                die("Failed to insert order: " . mysqli_error($con));
            }
        }
    } else {
        die("No cart items found, cannot proceed with order creation.");
    }

    // Check if an order was created successfully
    if ($order_ID !== null) {
        echo "Order created successfully, Payment ID: $payment_ID";
    } else {
        die("No order was created, cannot proceed with payment.");
    }


    $del_cart = "DELETE FROM carts WHERE cust_ID = '$cust_ID'";
    mysqli_query($con, $del_cart);

    header("Location: payment_success.php?trx_id=$trx_ID");
    exit();

} else {

    $firstname = $_POST["firstname"];
    $email = $_POST['email'];
    $address1 = $_POST['address1'];
    $address2 = $_POST['address2'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $cardname = $_POST['cardname'];
    $cardnumber = $_POST['cardNumber'];
    $expdate = $_POST['expdate'];
    $cvv = $_POST['cvv'];
    $total_count = $_POST['total_count'];
    $prod_total = $_POST['total_price'];

    $current_date = date("Ymd");
    $random_digits = str_pad(rand(0, 999999), 6, "0", STR_PAD_LEFT);
    $trx_ID = "TRX" . $current_date . $random_digits;


    $insert_address = "INSERT INTO addresses (cust_ID, address1, address2, city, state, zip) 
                           VALUES (NULL, '$address1', '$address2', '$city', '$state', '$zip')";
    if (mysqli_query($con, $insert_address)) {
        $address_ID = mysqli_insert_id($con);
    } else {
        die("Failed to insert address: " . mysqli_error($con));
    }


    $check_payment_method = "SELECT payment_mtd_id FROM paymentmethod 
WHERE cardnumber = '$cardnumber' 
LIMIT 1";
    $payment_method_result = mysqli_query($con, $check_payment_method);

    if (mysqli_num_rows($payment_method_result) > 0) {
        $row = mysqli_fetch_assoc($payment_method_result);
        $payment_mtd_id = $row['payment_mtd_id'];
    } else {
        $insert_payment_method = "INSERT INTO paymentmethod (cardname, cardnumber, expdate, cvv) 
     VALUES ('$cardname', '$cardnumber', '$expdate', '$cvv')";
        if (mysqli_query($con, $insert_payment_method)) {
            $payment_mtd_id = mysqli_insert_id($con);
        } else {
            die("Failed to insert payment method: " . mysqli_error($con));
        }
    }


    $insert_payment = "INSERT INTO payments (cust_ID, address_ID, prod_count, total_amt, payment_mtd_ID, trx_ID, p_status)
                   VALUES (NULL, '$address_ID', '$total_count', '$prod_total', '$payment_mtd_id', '$trx_ID', 'Completed')";

    if (mysqli_query($con, $insert_payment)) {

        $payment_ID = mysqli_insert_id($con);
    } else {
        die("Failed to insert payment: " . mysqli_error($con));
    }

    $get_cart = "SELECT * FROM carts WHERE cust_ID IS NULL";
    $cart_result = mysqli_query($con, $get_cart);

    $order_ID = null;

    if (mysqli_num_rows($cart_result) > 0) {
        while ($cart_row = mysqli_fetch_assoc($cart_result)) {
            $product_ID = $cart_row['product_ID'];
            $qty = $cart_row['qty'];


            $get_product = "SELECT product_price FROM products WHERE product_ID = '$product_ID' LIMIT 1";
            $product_result = mysqli_query($con, $get_product);
            $product = mysqli_fetch_assoc($product_result);
            $price = $product['product_price'];


            $totalPrice = $price * $qty;

            $insert_order = "INSERT INTO orders (cust_ID, product_ID, qty, totalPrice, payment_ID)
                         VALUES (NULL, '$product_ID', '$qty', '$totalPrice', '$payment_ID')";
            if (mysqli_query($con, $insert_order)) {
                // Optionally, get the order ID
                $order_ID = mysqli_insert_id($con);
            } else {
                die("Failed to insert order: " . mysqli_error($con));
            }
        }
    }

    if ($order_ID !== null) {
        echo "Order created successfully, Payment ID: $payment_ID";
    } else {
        die("No order was created, cannot proceed with payment.");
    }



    $del_cart = "DELETE FROM carts WHERE cust_ID IS NULL";
    mysqli_query($con, $del_cart);

    header("Location: payment_success.php?trx_id=$trx_ID");
    exit();
}
?>