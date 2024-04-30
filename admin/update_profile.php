<?php
include '../connection.php';
session_start();
$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
   header('location:admin_login.php');
   exit;
}
$message = []; // Initialize message array for error/success messages
if(isset($_POST['submit'])){
   $name = $_POST['name'];
   $old_pass=$_POST['old_pass'];
   $new_pass=$_POST['new_pass'];
   $confirm_pass=$_POST['confirm_pass'];
   
   if($confirm_pass != $new_pass){
      $message[]='Password and confirm password do not match';
   }
   if(empty($old_pass) || empty($new_pass) || empty($confirm_pass)){
      $message[]='Please enter the old, new, and confirm password';
   }
   $sql=mysqli_query($conn,"SELECT * FROM `admins` WHERE id='$admin_id'");
   $data=mysqli_fetch_assoc($sql);
   $adminName=$data['name'];
   $adminPass=$data['password'];
   if(!password_verify($old_pass,$adminPass)){
      $message[]='Old password does not match';
   }
   if(empty($message)){
      $hash=password_hash($new_pass,PASSWORD_DEFAULT);
      if(empty($name)){
         $sql=mysqli_query($conn,"UPDATE `admins` SET password='$hash' WHERE id='$admin_id'");
      } else {
         $sql=mysqli_query($conn,"UPDATE `admins` SET name='$name', password='$hash' WHERE id='$admin_id'");
      }
      // Redirect to dashboard after update
      echo "<script>alert('Update successful'); window.location='./dashboard.php';</script>";
      exit;
   }
}
 else {
   // Debugging: Check if data is fetched from database
   $sql=mysqli_query($conn,"SELECT * FROM `admins` WHERE id='$admin_id'");
   $data=mysqli_fetch_assoc($sql);
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>profile update</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

 
</head>
<body>

<?php include './admin_header.php' ?>

<!-- admin profile update section starts  -->

<section class="update-container">

<div class="form">
  
   <form action="" method="POST" class="update-form">
   <div class="image">
      <img src="updatee.png" alt=""></div>
      <h3>Update Profile</h3>
      <?php if (!empty($message)): ?>
                <ul>
                    <?php foreach ($message as $err): ?>
                        <li style="color:red;list-style:none;"><?php echo $err; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?> 
            <input type="text" name="name" class="box" value="<?php echo isset($data['name']) ? $data['name'] : ''; ?>" >
      <input type="password" name="old_pass" placeholder="Enter your old password" class="box" >
      <input type="password" name="new_pass" placeholder="Enter your new password" class="box" >
      <input type="password" name="confirm_pass" placeholder="Confirm your new password" class="box" >
      <input type="submit" value="Update Now" name="submit" class="button">
   </form>
</div>
   
</section>


<!-- admin profile update section ends -->









<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>
<style>
   .update-container {
   display: flex;
   justify-content: center;
   align-items: center;
}

.update-form {
   max-width: 400px;
   padding: 20px;
   border: 1px solid #ccc;
   border-radius: 10px;
   text-align: center;
}
.image img {
   width: 240px; 
   height: auto;
   margin-bottom: 20px;
}

.box {
   width: 100%;
   padding: 10px;
   margin-bottom: 15px;
   border: 1px solid #ccc;
   border-radius: 5px;
   box-sizing: border-box; /* Ensure padding is included in width */
}

.button {
   width: 100%;
   padding: 10px;
   background-color: #007bff;
   color: #fff;
   border: none;
   border-radius: 5px;
   cursor: pointer;
}
h3{
   margin-bottom: 3rem;
   font-size: 2rem;
}

@media (max-width: 576px) {
   .update-form {
      max-width: 300px;
   }
}

</style>
</body>
</html>