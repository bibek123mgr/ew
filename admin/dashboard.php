<?php
session_start();
include('../connection.php');
if (!isset($_SESSION['admin_id'])) {
   header('location:admin_login.php');
}else{
   $admin_id = $_SESSION['admin_id'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>dashboard</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

</head>

<body>

   <?php include('./admin_header.php') ?>
   <!-- admin dashboard section starts  -->

   <section class="dash">

      <h1 class="heading">Dashboard</h1>

      <div class="box-container">
         <div class="box">
            <h3>welcome!<p>
                  <?php
                     $query = mysqli_query($conn,"SELECT * FROM `admins` WHERE id ='$admin_id' LIMIT 1");
                           $admin_data = mysqli_fetch_assoc($query);
                           echo $admin_data['name'];
                  ?>
               </p>
            </h3>
            <a href="update_profile.php" class="btn">update profile</a>
         </div>

         <div class="box">
            <?php
            $total_pendings = 0;
$select_pendings = mysqli_query($conn, "SELECT o.amount, pd.* 
                                         FROM `orderss` AS o 
                                         INNER JOIN `paymentdetails` AS pd 
                                         ON o.paymentId = pd.id 
                                         WHERE o.orderStatus != 'delivered' 
                                         AND pd.paymentStatus = 'unpaid'");
            while ($fetch_pendings = mysqli_fetch_assoc($select_pendings)) {
               $total_pendings += $fetch_pendings['amount'];
            }
            ?>
            <h3><span>Rs</span><?= $total_pendings; ?><span>/-</span></h3>
            <p>total pendings</p>
            <a href="placed_orders.php" class="btn">see orders</a>
         </div>

         <div class="box">
            <?php
            $total_completes = 0;
            $select_completes = mysqli_query($conn, "SELECT o.amount, pd.* 
                                         FROM `orderss` AS o 
                                         INNER JOIN `paymentdetails` AS pd 
                                         ON o.paymentId = pd.id 
                                         WHERE o.orderStatus = 'delivered' 
                                         AND pd.paymentStatus = 'paid'");
            while ($fetch_completes = mysqli_fetch_assoc($select_completes)) {
               $total_completes += $fetch_completes['amount'];
            }
            ?>
            <h3><span>Rs</span><?= $total_completes; ?><span>/-</span></h3>
            <p>total completes</p>
            <a href="placed_orders.php" class="btn">see orders</a>
         </div>

         <div class="box">
            <?php
            $select_orders = mysqli_query($conn, "SELECT * FROM `orderss`");
            $numbers_of_orders = mysqli_num_rows($select_orders);
            ?>
            <h3><?= $numbers_of_orders; ?></h3>
            <p>total orders</p>
            <a href="placed_orders.php" class="btn">see orders</a>
         </div>

         <div class="box">
            <?php
            $select_products = mysqli_query($conn, "SELECT * FROM `products`");
            $numbers_of_products = mysqli_num_rows($select_products);
            ?>
            <h3><?= $numbers_of_products; ?></h3>
            <p>products added</p>
            <a href="products.php" class="btn">see products</a>
         </div>

         <div class="box">
            <?php
            $select_users = mysqli_query($conn, "SELECT * FROM `users`");
            $numbers_of_users = mysqli_num_rows($select_users);
            ?>
            <h3><?= $numbers_of_users; ?></h3>
            <p>users accounts</p>
            <a href="users_accounts.php" class="btn">see users</a>
         </div>

         <div class="box">
            <?php
            $select_admins = mysqli_query($conn, "SELECT * FROM `admins`");
            $numbers_of_admins = mysqli_num_rows($select_admins);
            ?>
            <h3><?= $numbers_of_admins; ?></h3>
            <p>admins</p>
            <a href="admin_accounts.php" class="btn">see admins</a>
         </div>

         <div class="box">
            <?php
            $select_messages = mysqli_query($conn, "SELECT * FROM `messages`");
            $numbers_of_messages = mysqli_num_rows($select_messages);
            ?>
            <h3><?= $numbers_of_messages; ?></h3>
            <p>new messages</p>
            <a href="messages.php" class="btn">see messages</a>
         </div>

      </div>

   </section>

   <!-- admin dashboard section ends -->

   <style>
      .dash {
         padding: 20px;
         text-align: center;
      }

      .heading {
         font-size: 2rem;
         margin-bottom: 20px;

      }

      .box-container {
         display: flex;
         flex-wrap: wrap;
         justify-content: center;
      }

      .box {
         background-color: #f0f0f0;
         border-radius: 10px;
         padding: 20px;
         margin: 10px;
         width: 250px;
         transition: transform 0.3s ease-in-out;
      }

      .box:hover {
         transform: translateY(-5px);
      }

      .box h3 {
         font-size: 1.5rem;
         margin-bottom: 10px;
      }

      .box p {
         margin-bottom: 15px;
      }

      .box a.btn {
         display: inline-block;
         background-color: #007bff;
         color: #fff;
         text-decoration: none;
         padding: 8px 16px;
         border-radius: 5px;
         transition: background-color 0.3s ease-in-out;
      }

      .box a.btn:hover {
         background-color: #0056b3;
      }

      @media (max-width: 768px) {
         .box {
            width: calc(50% - 20px);
         }
      }

      @media (max-width: 576px) {
         .box {
            width: calc(100% - 20px);
         }
      }
   </style>
   </style>

   <!-- custom js file link  -->
   <script src="../js/admin_script.js"></script>

</body>

</html>