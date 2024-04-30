<?php

include '../connection.php';
session_start();

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';

if (isset($_POST['send'])) {
   $name = $_POST['name'];
   $email = $_POST['email'];
   $number = $_POST['number'];
   $msg = $_POST['msg'];

   // Check if the message already exists
   $select_message_query = "SELECT * FROM `messages` WHERE name = '$name' AND email = '$email' AND number = '$number' AND message = '$msg'";
   $select_message_result = mysqli_query($conn, $select_message_query);

   if (mysqli_num_rows($select_message_result) > 0) {
      $message = 'Message already sent!';
   } else {
      // Insert the new message
      $insert_message_query = "INSERT INTO `messages` (user_id, name, email, number, message) VALUES ('$user_id', '$name', '$email', '$number', '$msg')";
      $insert_message_result = mysqli_query($conn, $insert_message_query);

      if ($insert_message_result) {
         $message = 'Message sent successfully!';
      } else {
         $message = 'Error sending message: ' . mysqli_error($conn);
      }
   }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Contact</title>

   <!-- Font Awesome CDN link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Custom CSS file link  -->
   <link rel="stylesheet" href="../css/style.css">
   <link rel="stylesheet" href="../css/contact.css">
</head>

<body>
   <!-- Header section -->
   <?php include '../components/navbar.php'; ?>

   <div class="heading">
      <h3>Contact Us</h3>
   </div>

   <!-- Contact section -->
   <section class="contact">
      <div class="row">
         <div class="image">
            <img src="../images/contact-img.svg" alt="">
         </div>
         <form action="" method="post">
            <h3>Tell us <span>something!</span></h3>
            <input type="text" name="name" maxlength="50" class="box" placeholder="Enter your name" required>
            <input type="number" name="number" min="0" max="9999999999" class="box" placeholder="Enter your number" required maxlength="10">
            <input type="email" name="email" maxlength="50" class="box" placeholder="Enter your email" required>
            <textarea name="msg" class="box" required placeholder="Enter your message" maxlength="500" cols="30" rows="10"></textarea>
            <input type="submit" value="Send Message" name="send" class="btn">
         </form>
      </div>
   </section>

   <!-- Footer section -->
   <?php include '../components/footer.php'; ?>

   <!-- Custom JavaScript file link  -->
   <script src="js/script.js"></script>
</body>

</html>