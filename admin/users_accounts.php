<?php

include '../connection.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:admin_login.php');
   exit();
}

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];

   // Delete user
   $delete_users_query = "DELETE FROM `users` WHERE id = '$delete_id'";
   $delete_users_result = mysqli_query($conn, $delete_users_query);

   if ($delete_users_result) {
      // Delete orders associated with the user
      $delete_order_query = "DELETE FROM `orders` WHERE user_id = '$delete_id'";
      mysqli_query($conn, $delete_order_query);

      // Delete cart items associated with the user
      $delete_cart_query = "DELETE FROM `cart` WHERE user_id = '$delete_id'";
      mysqli_query($conn, $delete_cart_query);

      header('location:users_accounts.php');
      exit();
   } else {
      echo 'Error deleting user: ' . mysqli_error($conn);
   }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>users accounts</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">


</head>

<body>

   <?php include './admin_header.php' ?>

   <section class="accounts">

<?php
$select_account_query = "SELECT * FROM `users`";
$select_account_result = mysqli_query($conn, $select_account_query);
if (mysqli_num_rows($select_account_result) > 0) {
?>
   <h1 class="heading">Users Account</h1>
   <div class="table-container">
      <table class="user-table">
         <thead>
            <tr>
               <th>User ID</th>
               <th>Username</th>
               <th>Email</th>
               <th>Action</th>
            </tr>
         </thead>
         <tbody>
            <?php
            while ($fetch_accounts = mysqli_fetch_assoc($select_account_result)) {
            ?>
               <tr>
                  <td><?= $fetch_accounts['id']; ?></td>
                  <td><?= $fetch_accounts['name']; ?></td>
                  <td><?= $fetch_accounts['email']; ?></td>
                  <td><a href="users_accounts.php?delete=<?= $fetch_accounts['id']; ?>" class="delete" onclick="return confirm('Delete this account?');">Delete</a></td>
               </tr>
            <?php
            }
            ?>
         </tbody>
      </table>
   </div>
<?php
} else {
   echo '<h1 class="empty" style="margin-top: 100px; text-align: center; text-decoration: underline;">No accounts available</h1>';
}
?>
</section>



   <style>
      .accounts {
         text-align: center;
         margin-bottom: 50px;
      }

      .heading {
         font-size: 2rem;
         margin-bottom: 20px;
      }

      .table-container {
         overflow-x: auto;
      }

      .user-table {
         width: 100%;
         border-collapse: collapse;
      }

      .user-table th,
      .user-table td {
         padding: 10px;
         border-bottom: 1px solid #ccc;
      }

      .user-table th {
         background-color: #f2f2f2;
         font-weight: bold;
         font-size: 15px;
      }

      .user-table td {
         background-color: #fff;
         font-size: 10px;
      }

      .user-table tbody tr:nth-child(even) {
         background-color: #f9f9f9;
      }

      .user-table tbody tr:hover {
         background-color: #f0f0f0;
      }

      .empty {
         font-style: italic;
         color: #999;
      }

      .delete {
         color: white;
         padding: 8px;
         font-size: 20px;
         border-radius: 5px;

         /* margin-left: -1rem; */

         background-color: red;
      }

      h1 {
         text-decoration: underline;
      }

      .accounts .box-container .box {
         background-color: var(--white);
         border-radius: 0.5rem;
         box-shadow: 0.3px 0.3px 1px 2px;

         padding: 2rem;
         padding-top: 1rem;
         text-align: center;
      }
   </style>

   <!-- custom js file link  -->
   <script src="../js/admin_script.js"></script>

</body>

</html>