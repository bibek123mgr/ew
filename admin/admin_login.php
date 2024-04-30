<?php
session_start();
include("../connection.php");

if (isset($_POST['submit'])) {
   $name = $_POST['name'];
   $password = $_POST['password'];
   $errors=[];
   if (empty($name) && empty($password)) {
      $errors[]="please enter the credentials";
   }
   $query = mysqli_query($conn,"SELECT * FROM `admins` WHERE name ='$name'");
   if (mysqli_num_rows($query) == '0') {
            $errors[]="invalid credentials";
         }
            $admin_data = mysqli_fetch_assoc($query);
            if (!password_verify($password,$admin_data['password'])) {
               $errors[]="please enter credentials valid password";
            }
            if(empty($errors)){
               $_SESSION['admin_id'] = $admin_data['id'];
               echo "<script>alert('successfully login to admin account');window.location='./dashboard.php'</script>";
               exit;
            }
         }
?>


<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>
   <style>
      * {
         margin: 0;
         padding: 0;

      }

      .container {
         max-width: 1280px;
         margin: 0 auto;
         padding: 0 15px;
      }

      .login {

         margin: 100px auto 0;
         width: 400px;
         font-family: Arial, sans-serif;
         border: 1px solid #ccc;
         border-radius: 7px;
         max-width: 100%;
         padding: 20px 15px;
         background-color: #f9f9f9;

      }

      .login h1 {
         text-align: center;
      }

      .login form {
         margin-top: 20px;
      }

      .email_div,
      .pass_div {
         margin-bottom: 10px;
      }

      .name,
      .password {
         width: 100%;
         padding: 10px;
         border: none;
         outline: none;

      }

      .submit_btn {
         width: 100%;
         padding: 10px;
         border: none;
         border-radius: 5px;
         background-color: #007bff;
         color: #fff;
         cursor: pointer;
      }

      .submit_btn:hover {
         background-color: #0056b3;
      }

      .show_password {
         cursor: pointer;
      }

      .toggler_password {
         color: black;
         margin-right: 3px;
         height: 18px;
      }

      .password_field,
      .email_field {
         margin-top: 5px;
         display: flex;
         align-items: center;
         border: 1px solid #ccc;
         border-radius: 3px;
         /* flex-direction: column; */
      }

      .reg_link {
         margin: 10px 0 0 0;
         font-size: 14px;
         text-align: center;
      }

      .login_submit {
         font-weight: 600;
         font-size: 18px;
         display: block;
         width: 100%;
         padding: 10px;
         margin-top: 10px;
         background-color: #FF2700;
         color: white;
         border: none;
         border-radius: 5px;
         cursor: pointer;
      }

      .login_submit:hover {
         background-color: #FF2700;
      }

      .pass_span,
      .email_span {
         color: black;
      }
   </style>
<body>
    <div class="container">
        <div class="login">
            <h1>Admin login</h1>
            <?php if (!empty($errors)): ?>
                <ul>
                    <?php foreach ($errors as $err): ?>
                        <li style="list-style:none;color:red"><?php echo $err; ?></li> <!-- Display error messages dynamically -->
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <form action="" method="post">
                <div class="email_div">
                    <span>Username</span>
                    <div class="email_field">
                        <input type="text" id="name" class="name" name="name" required placeholder="admin"> <!-- Corrected input type -->
                    </div>
                </div>
                <div class="pass_div">
                    <span>Password</span>
                    <div class="password_field">
                        <input type="password" id="password" class="password" name="password" required placeholder="password">
                        <img class="toggler_password" src="../assets/eye-slash-solid.png" alt="Toggle Password Visibility">
                    </div>
                </div>
                <input class="login_submit" type="submit" value="Login" name="submit">
            </form>
        </div>
    </div>
   <script>
      const password = document.querySelector('.password');
      const toggler_password = document.querySelector('.toggler_password');

      function togglePassword() {
         if (password.type === "password") {
            password.type = "text";
            toggler_password.src = "../assets/eye-solid.png";
         } else {
            password.type = "password";
            toggler_password.src = "../assets/eye-slash-solid.png";
         }
      }

      toggler_password.addEventListener('click', togglePassword);
   </script>

</body>

</html>