<?php
include('../connection.php');
session_start();
include('../components/fetchdata.php');
if (!isset($userId)) {
    header('Location: home.php');
}
?>
<?php
$error = "";
if (isset($_POST['Delete'])) {
    $user_input_password = $_POST['password'];
    if (empty($user_input_password)) {
        $error = "Please enter your password";
    } else {
        $sql = "SELECT password FROM users WHERE id=$userId";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $old_password = $row['password'];

            if ($old_password !== $user_input_password) {
                $error = 'Invalid Password';
            } else {
                $delete_sql = "DELETE FROM users WHERE id=$userId";
                $delete_result = mysqli_query($conn, $delete_sql);

                if ($delete_result) {
                    header('Location: ../components/user_logout.php');
                    exit;
                } else {
                    $error = "Something went wrong while deleting the user";
                }
            }
        } else {
            $error = "User not found or unable to fetch password";
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

        .pass_div {
            margin-bottom: 10px;
        }

        .password {
            width: 100%;
            padding: 10px;
            border: none;
            outline: none;

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

        .password_field {
            margin-top: 5px;
            display: flex;
            align-items: center;
            border: 1px solid #ccc;
            border-radius: 3px;
            /* flex-direction: column; */
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

        .pass_span {
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
            <form action="" method="post">
                <div class="error">
                    <p><?php echo $error ? $error : ""; ?></p>
                </div>
                <div class="pass_div">
                    <span>Password</span>
                    <div class="password_field">
                        <input type="password" id="password" class="password" name="password" required placeholder="password">
                        <img class="toggler_password" src="../assets/eye-slash-solid.png" alt="Toggle Password Visibility">
                    </div>
                </div>
                <input class="login_submit" type="submit" value="Delete Now" name="Delete">
            </form>
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