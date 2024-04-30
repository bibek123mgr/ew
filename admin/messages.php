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

   // Delete message
   $delete_message_query = "DELETE FROM `messages` WHERE id = '$delete_id'";
   $delete_message_result = mysqli_query($conn, $delete_message_query);

   if ($delete_message_result) {
      header('location:messages.php');
      exit();
   } else {
      echo 'Error deleting message: ' . mysqli_error($conn);
   }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>messages</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">


</head>

<body>

   <?php include './admin_header.php' ?>

   <!-- messages section starts  -->
   <?php
$select_messages_query = "SELECT * FROM `messages`";
$select_messages_result = mysqli_query($conn, $select_messages_query);
if (mysqli_num_rows($select_messages_result) > 0) {
?>
   <section class="messages">
      <h1 class="heading">Messages</h1>
      <div class="box-container">
         <?php
         while ($fetch_messages = mysqli_fetch_assoc($select_messages_result)) {
         ?>
            <div class="box">
               <p> Name : <span><?= $fetch_messages['name']; ?></span> </p>
               <p> Number : <span><?= $fetch_messages['number']; ?></span> </p>
               <p> Email : <span><?= $fetch_messages['email']; ?></span> </p>
               <p> Message : <span><?= $fetch_messages['message']; ?></span> </p>
               <a href="messages.php?delete=<?= $fetch_messages['id']; ?>" class="delete-btn" onclick="return confirm('Delete this message?');">Delete</a>
            </div>
         <?php
         }
         ?>
      </div>
   </section>
<?php
} else {
   echo '<div style="text-align:center;text-decoration:underline;margin-top:100px;"><h1>No messages found.</h1></div>';
}
?>


   <!-- messages section ends -->

   <style>
      .messages {
         padding: 20px;
      }

      .heading {
         text-align: center;
         font-size: 25px;
         text-decoration: underline;

      }

      .box-container {
         display: grid;
         grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
         gap: 20px;
      }

      .box {
         background-color: #f9f9f9;
         padding: 20px;
         border-radius: 10px;
         width: 30rem;
         font-size: 15px;
         box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      }

      .box p {
         margin: 0;
      }

      .box p span {
         font-weight: bold;
      }

      .delete-btn {
         display: block;
         margin-top: 10px;
         text-align: right;
         color: white;
         text-align: center;
         width: fit-content;
         padding: 5px;
         border-radius: 2px;
         text-decoration: none;
         transition: color 0.3s ease;
         background-color: red;

      }

      .delete-btn:hover {
         color: #b71c1c;
      }
   </style>

   <!-- custom js file link  -->
   <script src="../js/admin_script.js"></script>

</body>

</html>