<?php
session_start();
include("../components/fetchdata.php");
include('../connection.php');

if(isset($_GET['orderId'])){
    $id=$_GET['orderId'];
}
if(!isset($userId)){
header('Location:home.php');
}
$sql = mysqli_query($conn, "SELECT * FROM `orderss` WHERE id='$id'");
$result = mysqli_fetch_assoc($sql);
$paymentId = $result['paymentId'];
$userId = $result['userId'];
$fetchUser= mysqli_query($conn, "SELECT * FROM `users` WHERE id='$userId'");
$userDetail=mysqli_fetch_assoc($fetchUser);
$fetchpaymentDetails = mysqli_query($conn, "SELECT * FROM `paymentdetails` WHERE id='$paymentId'");
$paymentDetails = mysqli_fetch_assoc($fetchpaymentDetails);

if (isset($_POST['update_orderStatus'])) {
    $order_status = $_POST['order_status'];
    $update_status_query = "UPDATE `orderss` SET orderStatus = '$order_status' WHERE id = '$id'";
    $update_status_result = mysqli_query($conn, $update_status_query);
 
    if ($update_status_result) {
       $message[] = 'order status updated!';
    } else {
       $message[] = 'Error updating order status: ' . mysqli_error($conn);
    }
 }
 
 if(isset($_POST['update_paymentStatus'])){
    $payment_status = $_POST['payment_status'];
    $update =mysqli_query($conn,"UPDATE `paymentDetails` set paymentStatus= '$payment_status' WHERE id='$paymentId'");
    if(!$update){
       $message[] = 'Error updating payment status';
    }
    $message[] = 'payment status updated!';
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* CSS styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 20px;
        }

        .flex-container {
            display: flex;
            justify-content: space-between;
        }

        .section {
            margin-top: 20px;
        }

        .product-info {
            background: orange;
            width: 400px;
            display: flex;
            justify-content: space-between;
            height: 50px;
            align-items: center;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .product-image {
            height: 40px;
            width: auto;
        }

        .product-text {
            font-size: 15px;
        }

        .summary-section {
            margin-bottom: 20px;
        }

        .summary-heading {
            font-size: 30px;
            text-decoration: underline;
        }

        .order-details-info h2,
        .order-details-info h3 {
            margin: 5px 0;
        }

        .update-section {
            display: flex;
            margin-top: 20px;
        }

        .update-form {
            margin-right: 5px;
        }

        .drop-down {
            margin-right: 5px;
        }

        .btn {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <?php include('../components/navbar.php');?>
    <div class="container">
        <h1 style="text-decoration:underline">#orderId <?php echo $id?></h1>
        <div class="flex-container">
            <section class="section">
                <?php 
                $fetchorderDetails = mysqli_query($conn, "SELECT * FROM `orderdetails` WHERE orderId='$id'");
                $totalPrice = 0;
                $totalQuantity = 0;
                while($orderDetails = mysqli_fetch_assoc($fetchorderDetails)){
                    $productId = $orderDetails['productId'];
                    $price = $orderDetails['price'];
                    $quantity = $orderDetails['quantity'];
                    $fetchproduct = mysqli_query($conn, "SELECT * FROM `products` WHERE id='$productId'");
                    $product = mysqli_fetch_assoc($fetchproduct);
                    $totalPrice += $price;
                    $totalQuantity += $quantity;
                ?>
                <div class="product-info">
                    <img src="../uploaded_img/<?= $product['image'] ?>" alt="" class="product-image">
                    <span class="product-text"><?= $product['name'] ?></span>
                    <span class="product-text">Price: Rs. <?= $price ?></span>
                    <span class="product-text">Qty: <?= $quantity ?></span>
                </div>
                <?php } ?>
            </section>
            <section class="section">
                <div class="summary-section">
                    <h1 class="summary-heading">Order Details</h1>
                    <div class="order-details-info">
                        <h2>Order Status: <?php echo $result['orderStatus']?></h2>
                        <h2>Payment Method: <?php echo $paymentDetails['paymentMethod']?></h2>
                        <h2>Payment Status: <?php echo $paymentDetails['paymentStatus']?></h2>
                        <h3>Total Price: Rs <?= $totalPrice ?>/-</h3>
                        <h3>Total Quantity: <?= $totalQuantity ?></h3>
                    </div>
                </div>
                <div class="summary-section">
                    <h1 class="summary-heading">Contact Details</h1>
                    <h2>Name: <?php echo $userDetail['name'] ?></h2>
                    <h2>Shipping Address: <?= $result['shippingAddress']?></h2>
                    <h2>Phone Number: <?= $result['phoneNumber']?></h2>
                </div>
                <div class="summary-section update-section">
                    <form action="" method="POST" class="update-form">
                        <input type="submit" value="cancel Order" class="btn" name="update_orderStatus">
                    </form>
                </div>
            </section>
        </div>
    </div>
</body>
</html>
