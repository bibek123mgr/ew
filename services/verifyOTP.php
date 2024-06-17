<?php
include('../connection.php');
ob_start();
session_start();

if (isset($_SESSION['forgetEmail'])) {
    $email = $_SESSION['forgetEmail'];
} elseif (isset($_SESSION['newRegEmail'])) {
    $email = $_SESSION['newRegEmail'];
} else {
    header('Location: ../pages/home.php');
    exit();
}

if (isset($_POST['submit'])) {
    $errors = [];
    $OTP = mysqli_real_escape_string($conn, $_POST['otp']);
    
    if (empty($OTP) || !is_numeric($OTP)) {
        $errors[] = "Please enter the OTP";
    }

    if (empty($errors)) {
        if (isset($_SESSION['newRegEmail'])) {
            $sql = "SELECT * FROM `users` WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $data = mysqli_fetch_assoc($result);

            if ($data['otp'] != $OTP) {
                $errors[] = "OTP does not match";
            } else {
                $update = mysqli_query($conn, "UPDATE `users` SET verified='1' WHERE email = '$email'");
                unset($_SESSION["newRegEmail"]);
                echo "<script>alert('Account verified successfully'); window.location='../pages/login.php';</script>";
                exit();
            }
        } elseif (isset($_SESSION['forgetEmail'])) {
            $sql = "SELECT otp FROM forgetrequest WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $data = mysqli_fetch_assoc($result);

            if ($data['otp'] != $OTP) {
                $errors[] = "OTP does not match";
            } else {
                $_SESSION['forgetOTP'] = $OTP;
                echo "<script>alert('OTP verified successfully'); window.location='./changepassword.php';</script>";
                exit();
            }
        }
    }
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <style>
        * { margin: 0; padding: 0; }
        .container { max-width: 1280px; margin: 0 auto; padding: 0 15px; }
        .signup { margin: 100px auto; width: 400px; font-family: Arial, sans-serif; border: 1px solid #ccc; border-radius: 7px; max-width: 100%; padding: 20px 15px; background-color: #f9f9f9; }
        .signup h1 { text-align: center; }
        .signup form { margin-top: 20px; }
        .email_div { margin-bottom: 10px; }
        .email { width: 100%; padding: 10px; border: none; outline: none; }
        .submit_btn { margin-top: 15px; width: 100%; padding: 10px; border: none; border-radius: 5px; background-color: #FF2700; color: #fff; cursor: pointer; }
        .email_span { color: black; }
        .email_field { margin-top: 5px; display: flex; align-items: center; border: 1px solid #ccc; border-radius: 3px; }
    </style>
</head>

<body>
    <?php include('../components/navbar.php') ?>
    <div class="container">
        <div class="signup">
            <h1>Verify OTP</h1>
            <?php if (!empty($errors)): ?>
                <ul>
                    <?php foreach ($errors as $err): ?>
                        <li style="color:red;list-style:none;"><?php echo $err; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <form action="" method="POST" name="myForm">
                <div class="email_div">
                    <span class="email_span">OTP</span>
                    <div class="email_field">
                        <input type="number" id="email" class="email" name="otp" required placeholder="123456">
                    </div>
                    <input type="submit" name="submit" value="Verify OTP" class="submit_btn">
                </div>
            </form>
        </div>
    </div>
    <?php include('../components/footer.php') ?>
</body>
</html>
