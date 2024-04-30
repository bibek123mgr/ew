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

        .email_div {
            margin-bottom: 10px;
        }

        .email {
            width: 100%;
            padding: 10px;
            border: none;
            outline: none;
        }

        .submit_btn {
            margin-top: 15px;
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #FF2700;
            /* Button color remains the same */
            color: #fff;
            cursor: pointer;
        }

        .email_span {
            color: black;
        }



        .email_field {
            margin-top: 5px;
            display: flex;
            align-items: center;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
    </style>
</head>

<body>
    <?php include('../components/navbar.php') ?>
    <div class="container">
        <div class="signup">
            <h1>Forget Password</h1>
            <?php if (!empty($errors)): ?>
                    <ul>
                       <?php foreach ($errors as $err): ?>
                          <li style="color:red;list-style:none;"><?php echo $err; ?></li>
                          <?php endforeach; ?>
                        </ul>
                      <?php endif; ?>  
            <form action="" method="POST" name="myForm">
                <div class="email_div">
                    <span class="email_span">Email Address</span>
                    <div class="email_field">
                        <input type="email" id="email" class="email" name="email" required placeholder="example@gmail.com">
                    </div>
                    <input type="submit" name="submit" value="Send OTP" class="submit_btn">
                </div>
            </form>
        </div>
    </div>
    <?php include('../components/footer.php') ?>
</body>

</html>
<?php
ob_start();
function generateOTP()
{
    return rand(100000, 999999);
}
include('../connection.php');
session_start();

$errors = [];

if (isset($_POST['submit'])) {
    if (empty($_POST['email'])) {
        $errors[] = "Please enter the email address";
    } else {
        $email = $_POST['email'];
        $sql = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");
        if (mysqli_num_rows($sql) == 0) {
            $errors[] = "Please enter a valid email";
        } else {
            $row = mysqli_fetch_assoc($sql);
            $userId = $row['id'];
            $OTP = generateOTP();
            echo "Generated OTP: $OTP"; // For testing purposes, remove in production
            require_once('sendmailfunction.php');
            $recipient = $email;
            $subject = 'Password Forget Verification Code';
            $body = 'Your OTP is: ' . $OTP . '. Please do not share it with anyone.';
            $result = sendEmail($recipient, $subject, $body);
            if ($result) {
                $checkEmail = mysqli_query($conn, "SELECT email FROM forgetRequest WHERE email='$email'");
                if (mysqli_num_rows($checkEmail) > 0) {
                    $updateOTP = mysqli_query($conn, "UPDATE forgetRequest SET otp=$OTP WHERE email='$email'");
                } else {
                    $insertOTP = mysqli_query($conn, "INSERT INTO forgetRequest (email, otp, userId) VALUES ('$email', '$OTP', '$userId')");
                }
                $_SESSION['forgetEmail'] = $email;
                echo "<script>alert('OTP successfully sent'); window.location='./verifyOTP.php';</script>";
                exit();
            }
        }
    }
}
?>
