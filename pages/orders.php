<?php 
ob_start();
include('../connection.php');
session_start();
include('../components/fetchdata.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Placed Orders</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

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
   </style>

</head>

<body>

   <?php include '../components/navbar.php' ?>
<div style="max-width:1280px;margin:0 auto;">
   <?php
   $select_orders_query = "SELECT * FROM `orderss`";
   $select_orders_result = mysqli_query($conn, $select_orders_query);

   if (mysqli_num_rows($select_orders_result) === 0) {
   ?>
      <div style="text-align:center;text-decoration:underline;margin-top:100px;">
         <h1>No orders yet</h1>
      </div>
   <?php
   } else {
   ?>
      <section class="orders">
         <h1 class="heading" style="margin:20px 0;text-decoration:underline" >My Orders</h1>
         <div class="table-responsive">
            <table class="order-table">
               <thead>
                  <tr>
                     <th>Placed On</th>
                     <th>Number</th>
                     <th>Address</th>
                     <th>Total Products</th>
                     <th>Total Price</th>
                     <th>Order Status</th>
                     <th>Payment Method</th>
                     <th>Action</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                  while ($fetch_orders = mysqli_fetch_assoc($select_orders_result)) {
                     $sql = mysqli_query($conn, "SELECT * FROM `paymentdetails` WHERE id='" . $fetch_orders['paymentId'] . "'");
                     $data = mysqli_fetch_assoc($sql);
                  ?>
                     <tr>
                        <td><?= $fetch_orders['createdAt']; ?></td>
                        <td><?= $fetch_orders['phoneNumber']; ?></td>
                        <td><?= $fetch_orders['shippingAddress']; ?></td>
                        <td><?= $fetch_orders['quantity']; ?></td>
                        <td>Rs<?= $fetch_orders['amount']; ?>/-</td>
                        <td><?= $fetch_orders['orderStatus']; ?></td>
                        <td><?= $data['paymentMethod']; ?> (<?= $data['paymentStatus']; ?>)</td>

                        <td>
                           <div style="display:flex;">
                              <form action="" method="POST" style="margin-right:5px;">
                                 <input type="hidden" value="<?= $fetch_orders['id']; ?>" name="orderId">
                                 <input type="submit" value="Cancel Order" class="btn" name="update_orderStatus">
                              </form>
                              <a href="./singleorder.php?orderId=<?= $fetch_orders['id']; ?>" class="delete-btn">See More</a>
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
</div>

</body>

</html>
<?php

if (!isset($_SESSION['user_data'])) {
   header('Location:home.php');
} else {
   $data = $_SESSION['user_data'];
   $userId = $data['id'];
}
$select_orders = mysqli_query($conn, "SELECT * FROM `orderss` WHERE userId = '$userId'");

$message =[]; 

if (isset($_POST['update_orderStatus'])) {
   $orderId = $_POST['orderId'];
   $result = mysqli_query($conn, "SELECT orderStatus FROM orderss WHERE id = '$orderId'");
   if ($result && mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      if ($row['orderStatus'] == 'pending') {
         if (mysqli_query($conn, "UPDATE orderss SET orderStatus = 'cancelled' WHERE id = '$orderId'")) {
            $message[] = 'Order status updated!';
         } else {
            $message[] = 'Error updating order status: ' . mysqli_error($conn);
         }
      } else {
         $message[] = 'Order can\'t be cancel!';
      }
   }
}
foreach ($message as $msg) {
   echo $msg . "<br>";
}
?>
