<?php
session_start(); // Start the session if not already started
include('../connection.php');

if(isset($_GET['orderId'])){
    $id=$_GET['orderId'];
}

if(!isset($_SESSION['admin_id'])){
    header('Location: dashboard.php');
    exit; // Stop further execution
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
    $id=$_GET['orderId'];
   $order_status = $_POST['order_status'];
   
   // Update order status
   $update_status_query = "UPDATE `orderss` SET orderStatus = '$order_status' WHERE id = '$id'";
   $update_status_result = mysqli_query($conn, $update_status_query);
   
   if ($update_status_result) {
      $message[] = 'Order status updated!';
      
      // Fetch user ID
      $select_order_query = "SELECT * FROM `orderss` WHERE id = '$id'";
      $select_order_result = mysqli_query($conn, $select_order_query);
      $order = mysqli_fetch_assoc($select_order_result);
      $userId = $order['userId'];

      // Notification message
      $notification_message = "Your order (ID: $id) is $order_status.";
      
      // Insert notification
      $insert_notification_query = "INSERT INTO `notifications` (message, userId) VALUES ('$notification_message', '$userId')";
      $insert_notification_result = mysqli_query($conn, $insert_notification_query);
      
      if (!$insert_notification_result) {
         $message[] = 'Error inserting notification: ' . mysqli_error($conn);
      }
   } else {
      $message[] = 'Error updating order status: ' . mysqli_error($conn);
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php include('./admin_header.php');?>
 <div style="max-width:1280px; margin:0 auto; display:flex;flex-direction:column">
    <h1 style="text-decoration:underline">#orderId <?php echo $id?></h1>
    <div style="display:flex">
    <section>
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
<div style="background: orange; width: 400px; display: flex; justify-content: space-between; height:50px; align-items:center;padding:20px;border-radius:10px;">
<img src="../uploaded_img/<?= $product['image'] ?>" alt="" style="height: 40px; width: auto;">
   <span style="font-size:15px"><?= $product['name'] ?></span>
    <span  style="font-size:15px">price:Rs. <?= $price ?></span>
    <span  style="font-size:15px">qty: <?= $quantity ?></span>
</div>

            <?php
        }
        ?>

    </section>
    <section>
     <div>
           <h1 style="font-size:30px;text-decoration:underline;">order Details</h1>
            <div>
            <h1> Order Status:<?php echo $result['orderStatus']?></h1>
                <h1> payment Method:<?php echo $paymentDetails['paymentMethod']?></h1>
                <h1> payment Status:<?php echo $paymentDetails['paymentStatus']?></h1>
                <h2>Total Price: Rs<?= $totalPrice ?>/-</h2>
            <h2>Total Quantity: <?= $totalQuantity ?></h2>
            </div>
        </div>

        <div style="margin-top:20px">
        <h1 style="font-size:30px;text-decoration:underline;">Contact Details</h1>
        <h1>Name:<?php echo $userDetail['name'] ?></h1>
        <h1>Shipping Address: <?= $result['shippingAddress']?></h1>
        <h1>phone Number:<?= $result['phoneNumber']?></h1>
        </div>
        <div style="display:flex;margin-top:20px;">
     <form action="" method="POST" style="margin-right:5px;">
    <select name="order_status" class="drop-down" id="order_status">
        <option value="" selected disabled><?= $result['orderStatus']; ?></option>
        <option value="pending">Pending</option>
        <option value="confirm">Confirm</option>
        <option value="ontheway">On the Way</option>
        <option value="delivered">Delivered</option>
        <option value="returned">Returned</option>
    </select>
        <input type="submit" value="Update" class="btn" name="update_orderStatus">
</form>

<form action="" method="POST">
    <select name="payment_status" class="drop-down" id="payment">
        <option value="" selected disabled><?= $paymentDetails['paymentStatus'] ?></option>
        <option value="paid">Paid</option>
        <option value="unpaid">Unpaid</option>
        <option value="refund">Refund</option>
    </select>
    <input type="submit" value="Update" class="btn" name="update_paymentStatus">    
</form>
    </div>
    </section>
    </div>
    </div>

</body>
</html>
