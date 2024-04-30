<?php
include('../connection.php');
include('../components/fetchdata.php');
session_start();
if (isset($userId)) {
    header('Location: home.php');
    exit;
}

include("../connection.php");
$error = [];

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email)) {
        $error[] = "Please enter your email.";
    }

    if (empty($password)) {
        $error[] = "Please enter your password.";
    }

    if (empty($error)) {
        $query = "SELECT * FROM `users` WHERE email='$email' LIMIT 1";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) == 0) {
            $error[] = "no user exist credentials.";
        } else {
            $user_data = mysqli_fetch_assoc($result);
            if (!password_verify($password, $user_data['password'])) {
                $error[] = "password doesnot credentials.";
            }
        if (empty($error)) {
            if ($user_data['verified'] == '0') {
                function generateOTP() {
                    return rand(100000, 999999);
                }

                $OTP = generateOTP();
                $mail = mysqli_query($conn, "UPDATE `users` SET `otp` = '$OTP' WHERE `email` = '$email'");
                require_once('../services/sendmailfunction.php');
                $recipient = $email;
                $subject = 'Email Verification';
                $body = 'Your OTP is: ' . $OTP . ' Please don\'t share it with anyone.';
                $result = sendEmail($recipient, $subject, $body);
                $_SESSION['newRegEmail'] = $email;
                echo "<script>alert('The OTP has been sent to your email. Please verify.'); window.location='../services/verifyOTP.php';</script>";
                exit;
            } else {
                $_SESSION['user_data'] = $user_data;
                echo "<script>alert('successfully login to account'); window.location='./home.php';</script>";
                exit;
            }
        }
    }
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

            margin: 100px auto;
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

        .email,
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

        .reg_link,
        .forget_link {
            margin: 10px 0 0 0;
            font-size: 14px;
            text-align: center;
        }

        .password_field img {
            cursor: pointer;
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

        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>

<body>
    <?php include('../components/navbar.php'); ?>
    <div class="container">
        <div class="login">
            <h1>Login Now</h1>
            <?php if (!empty($error)): ?>
                <ul>
                    <?php foreach ($error as $err): ?>
                        <li style="color:red;list-style:none;"><?php echo $err; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?> 
                <div class="email_div">
            <form action="" method="post">
                    <span>Email Address</span>
                    <div class="email_field">
                        <input type="email" id="email" class="email" name="email" required placeholder="example@gmail.com">
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
            <p class="reg_link">Not registered? Click <a href="signup.php">here</a> to register.
            </p>
            <p class="forget_link"><a href="../services/forgetPassword.php">forget Password ?</a>
            </p>
        </div>
    </div>
    <?php include('../components/footer.php') ?>
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

        //error
        const errorMessage = document.querySelector('.error');

        if (errorMessage && errorMessage.innerHTML.trim() !== '') {
            setTimeout(function() {
                errorMessage.style.display = 'none';
            }, 5000);
        }
    </script>

</body>

</html>