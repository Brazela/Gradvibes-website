<?php
include "db.php";

if (isset($_POST['trx_id'])) {
    $trx_id = $_POST['trx_id'];

    // Query to fetch payment details by transaction ID
    $query = "SELECT payment_ID, trx_ID, payment_date, total_amt FROM payments WHERE trx_ID = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $trx_id);  // Bind the transaction ID as a string
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any record was found
    if ($result->num_rows > 0) {
        $payment = $result->fetch_assoc();
        $payment_id = $payment['payment_ID'];
        $trx_id = $payment['trx_ID'];
        $payment_date = $payment['payment_date'];
        $total_amt = $payment['total_amt'];

        // Query to get items associated with the payment
        $orders_query = "SELECT o.qty, o.totalPrice, p.product_name FROM orders o
                         JOIN products p ON o.product_ID = p.product_ID
                         WHERE o.payment_ID = ?";
        $stmt_orders = $con->prepare($orders_query);
        $stmt_orders->bind_param("i", $payment_id);
        $stmt_orders->execute();
        $orders_result = $stmt_orders->get_result();

        // Output the transaction details and items
        $output = "
        <div class='transaction-details card' style='margin-top:30px;'>
            <div class='card-header'>
                <h5>Transaction ID: $trx_id</h5>
            </div>
            <div class='card-body'>
                <p><strong>Date:</strong> $payment_date</p>
                <ul class='list-group mb-3'>";

        while ($order = $orders_result->fetch_assoc()) {
            $item_name = $order['product_name'];
            $quantity = $order['qty'];
            $price = $order['totalPrice'];
            $output .= "<li class='list-group-item'>
                            $item_name - Quantity: $quantity - Price: RM $price
                         </li>";
        }

        $tax_rate = 0.06;
        $tax = $total_amt * $tax_rate;
        $total_with_tax = $total_amt + $tax;

        $output .= "</ul>
                    <p><strong>Tax (6%):</strong> RM " . number_format($tax, 2) . "</p>
                    <p><strong>Total Amount with Tax:</strong> RM " . number_format($total_with_tax, 2) . "</p>
                </div>
            </div>";

        echo $output;
    } else {
        echo "<div class='alert alert-danger' role='alert'>
                No transaction found with that ID.
              </div>";
    }
}
?>
