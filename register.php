<?php
session_start();
include "db.php";

if (isset($_POST["f_name"])) {
    $f_name = $_POST["f_name"];
    $l_name = $_POST['l_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];
    $mobile = $_POST['mobile'];

    $name = "/^[a-zA-Z ]+$/";
    $emailValidation = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
    $number = "/^[0-9]+$/";

    if (empty($f_name) || empty($l_name) || empty($email) || empty($password) || empty($repassword) ||
        empty($mobile)) {
        echo "
            <div class='alert alert-warning'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill in all the fields!</b>
            </div>
        ";
        exit();
    } else {
        if (!preg_match($name, $f_name)) {
            echo "
                <div class='alert alert-warning'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <b>$f_name is not valid!</b>
                </div>
            ";
            exit();
        }
        if (!preg_match($name, $l_name)) {
            echo "
                <div class='alert alert-warning'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <b>$l_name is not valid!</b>
                </div>
            ";
            exit();
        }
        if (!preg_match($emailValidation, $email)) {
            echo "
                <div class='alert alert-warning'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <b>$email is not valid!</b>
                </div>
            ";
            exit();
        }
        if (strlen($password) < 9 || strlen($repassword) < 9) {
            echo "
                <div class='alert alert-warning'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <b>Password is weak (must be at least 9 characters)!</b>
                </div>
            ";
            exit();
        }
        if ($password != $repassword) {
            echo "
                <div class='alert alert-warning'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <b>Passwords do not match!</b>
                </div>
            ";
            exit();
        }
        if (!preg_match($number, $mobile)) {
            echo "
                <div class='alert alert-warning'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <b>Mobile number $mobile is not valid!</b>
                </div>
            ";
            exit();
        }
        if (!(strlen($mobile) == 10 || strlen($mobile) == 11)) {
            echo "
                <div class='alert alert-warning'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <b>Mobile number must be 10 or 11 digits!</b>
                </div>
            ";
            exit();
        }

        // Check if email already exists
        $sql = "SELECT cust_ID FROM customers WHERE email = '$email' LIMIT 1";
        $check_query = mysqli_query($con, $sql);
        $count_email = mysqli_num_rows($check_query);
        if ($count_email > 0) {
            echo "
                <div class='alert alert-danger'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <b>Email address already exists! Try another email.</b>
                </div>
            ";
            exit();
        } else {
            $sql = "INSERT INTO customers (first_name, last_name, email, password, mobile) 
                    VALUES ('$f_name', '$l_name', '$email', '$password', '$mobile')";
            $run_query = mysqli_query($con, $sql);

            if ($run_query) {
                $cust_ID = mysqli_insert_id($con);

                $_SESSION["uid"] = $cust_ID;
                $_SESSION["name"] = $f_name;
                $ip_add = getenv("REMOTE_ADDR");

                $sql = "UPDATE carts SET cust_ID = '$_SESSION[uid]' WHERE IP_Address='$ip_add' AND cust_ID IS NULL";
                if (mysqli_query($con, $sql)) {
                    echo "register_success";
                    echo "<script> location.href='store.php'; </script>";
                    exit();
                }
            } else {
                echo "Failed to register customer!";
                exit();
            }
        }
    }
}
?>
