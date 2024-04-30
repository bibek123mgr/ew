<?php
session_start();
include("../connection.php");

if (isset($_POST['submit'])) {
  $name = $_POST['name'];
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];

  if (!empty($name) && !empty($password) && !empty($confirm_password)) {
    if ($password === $confirm_password) {
      $query = "SELECT * FROM admin WHERE name='$name' LIMIT 1";
      $result = mysqli_query($conn, $query);

      if ($result) {
        if (mysqli_num_rows($result) > 0) {
          echo "User with this email already exists";
        } else {
          $query = "INSERT INTO admin (name, password) VALUES ('$name', '$password')";
          if (mysqli_query($conn, $query)) {
            echo "<script>alert('Successfully registered new admin');</script>";
            header('Location: ./register_admin.php');
            die;
          } else {
            echo "Error: " . mysqli_error($conn);
          }
        }
      } else {
        echo "Error: " . mysqli_error($conn);
      }
    } else {
      echo "Passwords do not match";
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Signup</title>
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

    .signup {
      margin: 100px auto 0;
      width: 400px;
      font-family: Arial, sans-serif;
      border: 1px solid #ccc;
      border-radius: 7px;
      max-width: 100%;
      padding: 20px 15px;
      background-color: #f9f9f9;
    }

    .signup h1 {
      text-align: center;
    }

    .signup form {
      margin-top: 20px;
    }

    .email_div,
    .pass_div,
    .confirm_pass_div {
      margin-bottom: 10px;
    }

    .name,
    .password,
    .confirm_password {
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
      background-color: #FF2700;
      /* Button color remains the same */
      color: #fff;
      cursor: pointer;
    }

    .submit_btn:hover {
      background-color: #0056b3;
    }

    .email_span,
    .pass_span,
    .confirm_pass_span {
      font-size: 16px;
      color: black;
    }

    .toggler_confirm_password,
    .toggler_password {
      height: 18px;
      color: black;
      margin-right: 3px;
    }

    .confirm_password_field,
    .password_field,
    .email_field {
      margin-top: 5px;
      display: flex;
      align-items: center;
      border: 1px solid #ccc;
      border-radius: 3px;
    }
  </style>
  <script src="../js/admin_script.js"></script>
</head>

<body>
  <?php include('./admin_header.php'); ?>
  <div class="container">
    <div class="signup">
      <h1>SignUp</h1>
      <form action="" method="POST" name="myForm">
        <div class="email_div">
          <span class="email_span">Admin name</span>
          <div class="email_field">
            <input type="text" id="name" class="name" name="name" required placeholder="admin name">
          </div>
        </div>
        <div class="pass_div">
          <span class="pass_span">Password</span>
          <div class="password_field">
            <input type="password" id="password" class="password" name="password" required placeholder="Password">
            <img class="toggler_password" src="../assets/eye-slash-solid.png" alt="Toggle Password">
          </div>
        </div>
        <div class="confirm_pass_div">
          <span class="confirm_pass_span">Confirm Password</span>
          <div class="confirm_password_field">
            <input type="password" id="confirm_password" class="confirm_password" name="confirm_password" required placeholder="Confirm Password">
            <img class="toggler_confirm_password" src="../assets/eye-slash-solid.png" alt="Toggle Confirm Password">
          </div>
        </div>
        <input class="submit_btn" type="submit" value="Register Now" name="submit" onclick='checkPassword()'>
      </form>
    </div>
  </div>

  <script>
    const password = document.querySelector('.password');
    const toggler_password = document.querySelector('.toggler_password');
    const confirm_password = document.querySelector('.confirm_password');
    const toggler_confirm_password = document.querySelector('.toggler_confirm_password');

    function checkPassword() {
      if (password.value !== confirm_password.value) {
        alert('password and confirm password should be same')
      }
    }

    function togglePassword() {
      if (password.type === "password") {
        password.type = "text";
        toggler_password.src = "../assets/eye-solid.png";
      } else {
        password.type = "password";
        toggler_password.src = "../assets/eye-slash-solid.png";
      }
    }

    function toggleConfirmPassword() {
      if (confirm_password.type === "password") {
        confirm_password.type = "text";
        toggler_confirm_password.src = "../assets/eye-solid.png";
      } else {
        confirm_password.type = "password";
        toggler_confirm_password.src = "../assets/eye-slash-solid.png";
      }
    }

    toggler_password.addEventListener('click', togglePassword);
    toggler_confirm_password.addEventListener('click', toggleConfirmPassword);
  </script>
</body>

</html>