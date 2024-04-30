<?php

include '../connection.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:admin_login.php');
   exit();
}

if (isset($_POST['update_orderStatus'])) {
   $order_id = $_POST['order_id'];
   $order_status = $_POST['order_status'];
   $update_status_query = "UPDATE `orderss` SET orderStatus = '$order_status' WHERE id = '$order_id'";
   $update_status_result = mysqli_query($conn, $update_status_query);

   if ($update_status_result) {
      $message[] = 'order status updated!';
   } else {
      $message[] = 'Error updating order status: ' . mysqli_error($conn);
   }
}

if(isset($_POST['update_paymentStatus'])){
   $payment_id = $_POST['payment_id'];
   $payment_status = $_POST['payment_status'];

   $update =mysqli_query($conn,"UPDATE `paymentDetails` set paymentStatus= '$payment_status' WHERE id='$payment_id'");
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
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>placed orders</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

</head>

<body>

   <?php include './admin_header.php' ?>

<?php
$select_orders_query = "SELECT * FROM `orderss`";
$select_orders_result = mysqli_query($conn, $select_orders_query);

if (mysqli_num_rows($select_orders_result) === 0) {
?>
   <div style="text-align:center;text-decoration:underline;margin-top:100px;"><h1>No orders yet</h1></div>
<?php
} else {
?>
   <section class="orders">
      <h1 class="heading">Placed Orders</h1>
      <div class="table-responsive">
         <table class="order-table">
            <thead>
               <tr>
                  <th>Placed On</th>
                  <th>Number</th>
                  <th>Address</th>
                  <th>Total Products</th>
                  <th>Total Price</th>
                  <th>order Staus</th>
                  <th>Payment Method</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tbody>
               <?php
               while ($fetch_orders = mysqli_fetch_assoc($select_orders_result)) {
                  $sql=mysqli_query($conn,"SELECT * FROM `paymentdetails` WHERE id='". $fetch_orders['paymentId']."'");
                  $data=mysqli_fetch_assoc($sql);
               ?>
                  <tr>
                     <td><?= $fetch_orders['createdAt']; ?></td>
                     <td><?= $fetch_orders['phoneNumber']; ?></td>
                     <td><?= $fetch_orders['shippingAddress']; ?></td>
                     <td><?= $fetch_orders['quantity']; ?></td>
                     <td>Rs<?= $fetch_orders['amount']; ?>/-</td>
                     <td><?= $fetch_orders['orderStatus']; ?></td>
                     <td><?= $data['paymentMethod']; ?>  (<?= $data['paymentStatus']; ?> )</td>
                       
                     <td>
                        <div style="display:flex;">
                        <form action="" method="POST" style="margin-right:5px;">
      <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
    <select name="order_status" class="drop-down" id="order_status">
        <option value="" selected disabled><?= $fetch_orders['orderStatus']; ?></option>
        <option value="pending">Pending</option>
        <option value="confirm">Confirm</option>
        <option value="ontheway">On the Way</option>
        <option value="delivered">Delivered</option>
        <option value="returned">Returned</option>
    </select>
    <div class="flex-btn">
        <input type="submit" value="Update" class="btn" name="update_orderStatus">
    </div>
</form>

<form action="" method="POST">
    <input type="hidden" name="payment_id" value="<?= $fetch_orders['paymentId']; ?>">
    <select name="payment_status" class="drop-down" id="payment">
        <option value="" selected disabled><?= $data['paymentStatus']; ?></option>
        <option value="paid">Paid</option>
        <option value="unpaid">Unpaid</option>
        <option value="refund">Refund</option>
    </select>
    <div class="flex-btn">
        <input type="submit" value="Update" class="btn" name="update_paymentStatus">
        <!-- <a href="placed_orders.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('Delete this order?');">Delete</a> -->
        <a href="./orderdetails.php?orderId=<?= $fetch_orders['id']; ?>" class="delete-btn">see more</a>
    </div>
</form>
 </div>
 </td>
 </tr>
<?php
               }
               ?>
            </tbody>
         </table>
      </div>
   </section>
<?php
}
?>

   <style>
      .header,
      .flex {
         background-color: white;
      }

      .drop-down {
         padding: 5px;
         box-shadow: 0 2px 4px rgba(0, 0, 0, 0.6);
         border-radius: 4px;
      }

      .table-responsive {
         overflow-x: auto;
      }

      .order-table {
         width: 100%;
         border-collapse: collapse;
      }

      .order-table th,
      .order-table td {
         padding: 8px;
         border: 1px solid #ddd;
         text-align: left;
      }

      .order-table th {
         background-color: #f2f2f2;
      }

      .order-table .empty {
         text-align: center;
      }

      .flex-btn {
         display: flex;
         gap: 10px;
      }

      .btn {
         padding: 8px 16px;
         background-color: #007bff;
         color: #fff;
         border: none;
         border-radius: 5px;
         cursor: pointer;
      }

      .delete-btn {
         padding: 8px 16px;
         background-color: #dc3545;
         color: #fff;
         border: none;
         border-radius: 5px;
         text-decoration: none;
         cursor: pointer;
      }

      .delete-btn:hover {
         background-color: #c82333;
      }


      @media (max-width: 768px) {

         .order-table th,
         .order-table td {
            padding: 6px;
         }
      }

      @media (max-width: 576px) {

         .order-table th,
         .order-table td {
            padding: 4px;
         }
      }

      /* Flex button styles */
      .flex-btn {
         display: flex;
         gap: 10px;
      }

      .btn,
      .delete-btn {
         padding: 8px 16px;
         border-radius: 5px;
         cursor: pointer;
      }

      .btn {
         background-color: #007bff;
         color: #fff;
         border: none;
      }

      .delete-btn {
         background-color: #dc3545;
         color: #fff;
         border: none;
         text-decoration: none;
      }

      .delete-btn:hover {
         background-color: #c82333;
      }
   </style>

   <script src="../js/admin_script.js"></script>

</body>

</html>