<?php
ob_start();
include('../connection.php');
session_start();
include('../components/fetchdata.php');

if (!isset($userId)) {
   header('Location:home.php');
}

if (isset($_POST['submit'])) {
   header('Lodation:update_profile.php');
}
?>
<?php
// Fetch user data
$sql = "SELECT * FROM users WHERE id='$userId'";
$query = mysqli_query($conn, $sql);

if ($query && mysqli_num_rows($query) > 0) {
   $userData = mysqli_fetch_assoc($query);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>User Profile</title>
   <style>
      .userProfile {
         max-width: 600px;
         margin: 20px auto;
         padding: 20px;
         background-color: #fff;
         border-radius: 8px;
         box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      }

      .profile {
         text-align: center;
         margin-bottom: 20px;
      }

      .profile h1 {
         margin-bottom: 10px;
         color: #333;
      }

      .form-group {
         margin-bottom: 20px;
         display: flex;
         flex-direction: column;
      }

      .form-group label {
         color: #666;
         margin-bottom: 5px;
      }

      .form-group input[type="text"],
      .form-group input[type="email"],
      .form-group input[type="number"],
      .form-group input[type="date"],
      .form-group select {
         width: 100%;
         padding: 10px;
         border: 1px solid #ccc;
         border-radius: 4px;
         transition: border-color 0.3s ease;
         box-sizing: border-box;
      }

      .emailnum {
         display: flex;
         gap: 10px;
      }

      .emailnum .email,
      .emailnum .number {
         flex: 1;
      }

      .emailnum .email label,
      .emailnum .number label {
         display: block;
         margin-bottom: 5px;
         color: #666;
      }

      .emailnum .email input,
      .emailnum .number input {
         width: 100%;
         padding: 10px;
         border: 1px solid #ccc;
         border-radius: 4px;
         transition: border-color 0.3s ease;
         box-sizing: border-box;
      }

      .form-submit a {
         text-decoration: none;
         margin-top: 10px;
         padding: 10px 5px;
         border: none;
         outline: none;
         color: white;
         background-color: #FF2700;
      }


      @media screen and (max-width: 768px) {
         .userProfile {
            width: 90%;
         }
      }
   </style>
</head>

<body>
   <?php include('../components/navbar.php'); ?>
   <div class="userProfile">
      <section class="profile">
         <h1>User Profile</h1>
         <form action="" method="post">
            <div class="form-group">
               <label for="name">Name</label>
               <input type="text" id="name" name="name" value="<?php echo isset($userData['name']) ? $userData['name'] : ''; ?>" disabled>
            </div>
            <div class="form-group">
               <div class="emailnum">
                  <div class="email">
                     <label for="email">Email</label>
                     <input type="email" id="email" name="email" value="<?php echo isset($userData['email']) ? $userData['email'] : ''; ?>" disabled>
                  </div>
                  <div class="number">
                     <label for="number">Number</label>
                     <input type="tel" id="number" name="number" value="<?php echo isset($userData['number']) ? $userData['number'] : ''; ?>" disabled>
                  </div>
               </div>
            </div>
            <div class="form-group">
               <label for="gender">Gender</label>
               <select name="gender" id="gender" disabled>
                  <option value="" <?php echo !isset($userData['gender']) ? 'selected' : ''; ?>>Select Gender</option>
                  <option value="male" <?php echo isset($userData['gender']) && $userData['gender'] == 'male' ? 'selected' : ''; ?>>Male</option>
                  <option value="female" <?php echo isset($userData['gender']) && $userData['gender'] == 'female' ? 'selected' : ''; ?>>Female</option>
                  <option value="other" <?php echo isset($userData['gender']) && $userData['gender'] == 'other' ? 'selected' : ''; ?>>Other</option>
               </select>
            </div>
            <div class="form-group">
               <label for="date">Date of Birth</label>
               <input type="date" id="date" name="dob" value="<?php echo isset($userData['dob']) ? $userData['dob'] : ''; ?>" disabled>
            </div>
            <div class="form-group">
               <label for="address">Address</label>
               <input type="text" id="address" name="address" value="<?php echo isset($userData['address']) ? $userData['address'] : ''; ?>" disabled>
            </div>
            <div class="form-submit">
               <a href="../services/changepassword.php">Change Password</a>
               <a href="update_profile.php">Edit Profile</a>
            </div>
         </form>
      </section>
   </div>
   <?php include('../components/footer.php'); ?>

</body>

</html>