<?php
include('../connection.php');
include('../components/fetchdata.php');
session_start();

$errors = [];
$email = "";
$name = "";

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    // Validation
    if (empty($name) || empty($email) || empty($password) || empty($cpassword)) {
        $errors[] = "All fields are required";
    }

    if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
        $errors[] = "Name should contain only alphabetical characters.";
    }

    if (!preg_match("/^[a-zA-Z0-9._%+-]+@gmail\.com$/", $email)) {
        $errors[] = "Please enter a valid @gmail.com email address.";
    }

    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters";
    }

    if ($password !== $cpassword) {
        $errors[] = "Password and confirm password should be the same";
    }

    // Check for existing email
    $sql = "SELECT email FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $errors[] = "Email has already been registered";
    }

    if (empty($errors)) {
        $hashpassword = password_hash($password, PASSWORD_DEFAULT);
        $insert = "INSERT INTO `users` (name, email, password, verified) VALUES ('$name', '$email', '$hashpassword', '0')";
        $result = mysqli_query($conn, $insert);
        if ($result) {
            function generateOTP() {
                return rand(100000, 999999);
            }
            $OTP = generateOTP();
            $mail = mysqli_query($conn, "UPDATE `users` SET `otp` = '$OTP' WHERE `email` = '$email'");
            require_once('../services/sendmailfunction.php');
            $recipient = $email;
            $subject = 'Email Verification';
            $body = 'Your OTP is: ' . $OTP . ' please don\'t share with anyone';
            $result = sendEmail($recipient, $subject, $body);
            $_SESSION['newRegEmail'] = $email;
            echo "<script>alert('The OTP has been sent to your email. Please verify.'); window.location='../services/verifyOTP.php';</script>";
        } else {
            $errors[] = "Registration failed. Please try again.";
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
            margin: 0 auto;
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

        .email_div,
        .pass_div,
        .confirm_pass_div {
            margin-bottom: 10px;
        }

        .email,
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
            color: #fff;
            cursor: pointer;
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
            <h1>Signup</h1>
            <?php if (!empty($errors)): ?>
                <ul>
                    <?php foreach ($errors as $err): ?>
                        <li style="color:red;list-style:none;"><?php echo $err; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <form action="" method="POST" name="myForm" onsubmit="return validateForm()">
                <div class="email_div">
                    <span class="email_span">Email Address</span>
                    <div class="email_field">
                        <input type="email" id="email" class="email" name="email" required placeholder="example@gmail.com" value="<?php echo htmlspecialchars($email); ?>">
                    </div>
                </div>
                <div class="email_div">
                    <span class="email_span">Fullname</span>
                    <div class="email_field">
                        <input type="text" id="name" class="email" name="name" required placeholder="John Doe" value="<?php echo htmlspecialchars($name); ?>">
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
                        <input type="password" id="confirm_password" class="confirm_password" name="cpassword" required placeholder="Confirm Password">
                        <img class="toggler_confirm_password" src="../assets/eye-slash-solid.png" alt="Toggle Confirm Password">
                    </div>
                </div>
                <input class="submit_btn" type="submit" value="Signup" name="submit">
            </form>
            <p class="login_link">Already registered? <a href="login.php">Login here</a></p>
        </div>
    </div>
    <?php include('../components/footer.php'); ?>

    <script>
        const password = document.querySelector('.password');
        const toggler_password = document.querySelector('.toggler_password');
        const confirm_password = document.querySelector('.confirm_password');
        const toggler_confirm_password = document.querySelector('.toggler_confirm_password');

        function validateForm() {
            const email = document.querySelector('#email').value;
            const name = document.querySelector('#name').value;
            const emailPattern = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;
            const namePattern = /^[A-Za-z\s]+$/;

            if (!emailPattern.test(email)) {
                alert('Please enter a valid @gmail.com email address.');
                return false;
            }

            if (!namePattern.test(name)) {
                alert('Name should contain only alphabetical characters.');
                return false;
            }

            if (password.value !== confirm_password.value) {
                alert('Password and confirm password should be the same');
                return false;
            }
            return true;
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
