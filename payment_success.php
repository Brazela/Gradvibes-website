<?php
include "db.php";


if (isset($_GET['trx_id'])) {
    $trx_id = $_GET['trx_id'];

    $sql = "SELECT * FROM payments WHERE trx_ID = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "s", $trx_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($orderRow = mysqli_fetch_array($result)) {
        $user_id = $orderRow['cust_ID'];

        $infoSql = "SELECT * FROM payments WHERE trx_id = ?";
        $infoStmt = mysqli_prepare($con, $infoSql);
        mysqli_stmt_bind_param($infoStmt, "s", $trx_id);
        mysqli_stmt_execute($infoStmt);
        $infoResult = mysqli_stmt_get_result($infoStmt);

        if ($infoRow = mysqli_fetch_array($infoResult)) {
            $order_total = $infoRow['total_amt'];

            $userSql = "SELECT first_name, last_name FROM customers WHERE cust_ID = ?";
            $userStmt = mysqli_prepare($con, $userSql);
            mysqli_stmt_bind_param($userStmt, "i", $user_id);
            mysqli_stmt_execute($userStmt);
            $userResult = mysqli_stmt_get_result($userStmt);

            if ($userRow = mysqli_fetch_array($userResult)) {
                $user_name = $userRow['first_name'] . ' ' . $userRow['last_name'];
            } else {
                $user_name = "Guest";
            }


        } else {
            header("Location: index.php");
            exit();
        }

    } else {
        header("Location: index.php");
        exit();
    }

} else {
    header("Location: index.php");
    exit();
}
include "header.php";

?>


<div class="container-fluid" style="margin-top: 80px;">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color:white;"></div>
                <div class="panel-body">
                    <h1>Thank you for your purchase!</h1>
                    <hr />
                    <?php
                    // Check if the session has a user ID
                    if (isset($_SESSION['uid'])) {
                        // User is logged in, display their name and payment details
                        echo "<p>Hello <b>" . htmlspecialchars($user_name) . "</b>, your payment has been successfully completed.  <br/><br/>Your Transaction ID is <b>" . htmlspecialchars($trx_id) . "</b></p>";
                    } else {
                        // User is not logged in, show a textbox and copy button
                        echo '
    <p>Your payment has been successfully completed. <br/><br/>Your Transaction ID is:</p>
   
 <div class="input-group mb-3">
    <input type="text" class="form-control" id="trxID" name="trxID" value="' . htmlspecialchars($trx_id) . '" readonly required>
    <div class="input-group-append">
        <!-- Bootstrap button with Font Awesome icon -->
        <button class="btn btn-outline-secondary" style="margin-top:10px; margin-bottom:5px; border:0.5px solid #808080;" type="button" id="copyButton" onclick="copyToClipboard()">
            <i class="fa fa-copy"></i> Copy <!-- Copy icon only -->
        </button>
    </div>
</div>


    <script>
      
        function copyToClipboard() {
            var copyText = document.getElementById("trxID");
            
            // Select the text field
            copyText.select();
            copyText.setSelectionRange(0, 99999); // For mobile devices
            
     
            document.execCommand("copy");

           
            alert("Transaction ID copied to clipboard!");
        }
    </script>';
                    }
                    ?>

                    Your total amount was: <b>RM <?php echo number_format($order_total, 2); ?></b><br /><br />
                    <?php if (!isset($_SESSION['uid'])) { ?>
                        <div class="mb-3">
                            <p style="color:#FF474C;"><strong>Important:</strong> Please keep the transaction ID for your
                                reference. You will need it for any future inquiries or support requests.</p>
                        </div>
                    <?php } ?>
                    <a href="index.php" class="btn btn-success btn-lg">Continue Shopping</a>
                </div>
                <div class="panel-footer" style="background-color:white;"></div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
</div>

<?php
include "footer.php";
?>