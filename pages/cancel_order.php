<?php
include('../connection.php');
session_start();

if (!isset($_SESSION['user_data'])) {
   echo 'User not logged in';
   exit;
}

$data = $_SESSION['user_data'];
$userId = $data['id'];

if (isset($_POST['orderId'])) {
   $orderId = $_POST['orderId'];
   $result = mysqli_query($conn, "SELECT orderStatus FROM orderss WHERE id = '$orderId' AND userId = '$userId'");
   if ($result && mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      if ($row['orderStatus'] == 'pending') {
         if (mysqli_query($conn, "UPDATE orderss SET orderStatus = 'cancelled' WHERE id = '$orderId'")) {
            // Notify admin dashboard (e.g., by writing to a log, sending a message, etc.)
            echo 'Order status updated!';
         } else {
            echo 'Error updating order status: ' . mysqli_error($conn);
         }
      } else {
         echo 'Order can\'t be canceled!';
      }
   } else {
      echo 'Order not found';
   }
}
?>
