<?php
ob_start();
function generateOTP()
{
    return rand(100000, 999999);
}
$errors=[];
include('../connection.php');
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    if (empty($email)) {
        $errors[]='Please enter the email address';
    }
$findEmail=mysqli_query($conn,"SELECT email FROM `users` WHERE email='$email' LIMIT 1");
if(mysqli_num_rows($findEmail)== '0'){
    $errors[]='Please the valid email address';
}
if(empty($errors)){
    $OTP = generateOTP();
    $findEmail=mysqli_query($conn,"SELECT email FROM `forgetRequest` WHERE email='$email'");
    if(mysqli_num_rows($findEmail) == 0){
        $InsertUser=mysqli_query($conn,"INSERT INTO `forgetRequest` (email,otp) VALUES ('$email','$OTP')");
    }else{
        $updateOTP=mysqli_query($conn,"UPDATE `forgetRequest` SET otp='$OTP' WHERE email='$email'");
    }
    require_once('sendmailfunction.php');
    $recipient = $email;
    $subject = 'Email Verification';
    $body = 'Your OTP is: ' . $OTP . ' please don\'t share with any one';
    $result = sendEmail($recipient, $subject, $body);
    $_SESSION['forgetEmail']=$email;
    echo "<script>alert('otp successfully send');window.location='./verifyOTP.php';</script>";
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
            <h1>Email Verification</h1>
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