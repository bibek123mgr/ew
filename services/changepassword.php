<?php
ob_start();
function generateOTP()
{
    return rand(100000, 999999);
}

include('../connection.php');
session_start();
include('../components/fetchdata.php');

$errors = [];

if ((!isset($_SESSION['forgetOTP']) && !isset($_SESSION['forgetEmail'])) && !isset($userId)) {
    header('Location: ../pages/home.php');
    exit();
}

if (isset($_POST['submit'])) {
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    if ($password !== $cpassword) {
        $errors[] = "Password and confirm password should be same";
    }
    if (empty($password) || empty($cpassword)) {
        $errors[] = "All fields are required";
    }

    if (empty($errors)) {
        if (isset($userId)) {
            $user_input_password = $_POST['oldpassword'];
            if (empty($user_input_password)) {
                $errors[] = "Enter the old password";
            }
            $fetchpwd = mysqli_query($conn, "SELECT password FROM `users` WHERE id='$userId'");
            $row = mysqli_fetch_assoc($fetchpwd);
            if (!password_verify($user_input_password, $row['password'])) {
                $errors[] = "Enter the valid old password";
            }
            if (empty($errors)) {
                $hashpassword = password_hash($password, PASSWORD_DEFAULT);
                $sql = mysqli_query($conn, "UPDATE users SET password='$hashpassword' WHERE id='$userId'");
                echo "<script>alert('Password changed successfully'); window.location='../pages/profile.php'</script>";
                exit;
            }
        } else {
            $email = $_SESSION['forgetEmail'];
            if (empty($errors)) {
                $hashpassword = password_hash($password, PASSWORD_DEFAULT);
                $sql = mysqli_query($conn, "UPDATE users SET password='$hashpassword' WHERE email='$email'");
                unset($_SESSION['forgetOTP']);
                unset($_SESSION['forgetEmail']);
                echo "<script>alert('Password changed successfully'); window.location='../pages/login.php'</script>";
                exit;
            }
        }
    }
}

?>

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
            margin: 100px auto;
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

        .pass_div,
        .confirm_pass_div {
            margin-bottom: 10px;
        }

        .oldpass,
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

        .login_link {
            margin: 10px 0 0 0;
            font-size: 14px;
            text-align: center;
        }
    </style>
</head>

<body>
    <?php include('../components/navbar.php'); ?>
    <div class="container">
        <div class="signup">
            <h1>Change Password</h1>
            <?php if (!empty($errors)): ?>
                    <ul>
                       <?php foreach ($errors as $err): ?>
                          <li style="color:red;list-style:none;"><?php echo $err; ?></li>
                          <?php endforeach; ?>
                        </ul>
                      <?php endif; ?>  
            <form action="" method="POST" name="myForm">
                <?php if (isset($userId)) : ?>
                    <div class="pass_div">
                        <span class="pass_span">Old Password</span>
                        <div class="password_field">
                            <input type="text" id="password" class="oldpass" name="oldpassword" required placeholder="Old Password">
                        </div>
                    </div>
                <?php endif; ?>
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
                        <input type="password" id="confirm_password" class="confirm_password" name="cpassword" required placeholder="Confirm Password">
                        <img class="toggler_confirm_password" src="../assets/eye-slash-solid.png" alt="Toggle Confirm Password">
                    </div>
                </div>
                <input class="submit_btn" type="submit" value="Signup" name="submit" onclick='checkPassword()'>
            </form>
            <p class="login_link">Already registered? <a href="login.php">Login here</a></p>
        </div>
    </div>
    <?php include('../components/footer.php') ?>

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