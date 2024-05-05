<?php
ob_start();

include('../connection.php');
session_start();
include('../components/fetchdata.php');

if (!isset($userId)) {
    header('Location:../pages/home.php');
}

$error = [];

// Fetch user profile
$sql = "SELECT * FROM users WHERE id='$userId'";
$checkquery = mysqli_query($conn, $sql);

if (!$checkquery) {
    die('Error in fetching user data: ' . mysqli_error($conn));
}

if (mysqli_num_rows($checkquery) > 0) {
    $fetch_user = mysqli_fetch_assoc($checkquery);
    $name = $fetch_user['name'];
    $email = $fetch_user['email'];

    // Check if user has updated their profile
    if (empty($fetch_user['number']) || empty($fetch_user['address']) || empty($fetch_user['gender']) || empty($fetch_user['dob'])) {
        $error[] = 'Please update your profile';
    } else {
        $number = $fetch_user['number'];
        $address = $fetch_user['address'];
    }
} else {
    $error[] = 'Error fetching user data';
}

if (isset($_POST['placeOrder'])) {
    // Retrieve payment method
    $payment = isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : '';

    // Check if required fields are empty
    if (empty($email) || empty($address) || empty($number) || empty($payment) || empty($userId)) {
        $error[] = "Something went wrong during order placement: Required fields are empty.";
    } else {
        // If payment method is 'khalti', redirect to khalti.php
        if ($payment == 'khalti') {
            header('Location: khalti.php');
            exit();
        }

        // Fetch items from cart
        $sql = "SELECT * FROM carts WHERE userid='$userId'";
        $query = mysqli_query($conn, $sql);

        if ($query && mysqli_num_rows($query) > 0) {
            $grandTotal = 0;
            $subtotal = 0;
            $totalqty = 0;
            $orderId = md5(uniqid());
            $inserOrder = mysqli_query($conn, "INSERT INTO `orderss` (id, orderStatus, userId, shippingAddress, phoneNumber) VALUES ('$orderId', 'pending', '$userId', '$address', '$number')");
            
            if ($inserOrder) {
                while ($fetchProduct = mysqli_fetch_assoc($query)) {
                    $productId = $fetchProduct['pid'];
                    $quantity = $fetchProduct['quantity'];
                    $price = $fetchProduct['price'];
                    $totalqty += $quantity;
                    $subtotal = $price * $quantity;
                    $grandTotal += $subtotal;
                    $placeOrder = mysqli_query($conn, "INSERT INTO orderdetails (orderId, productId, quantity, price) VALUES ('$orderId', '$productId', '$quantity', $price)");
                }
                $paymentId = md5(uniqid());
                $paymentDetails = mysqli_query($conn, "INSERT INTO paymentDetails (id, paymentMethod, paymentStatus) VALUES ('$paymentId', 'cod', 'unpaid')");
                $update = mysqli_query($conn, "UPDATE orderss SET amount=$grandTotal, paymentId='$paymentId', quantity=$totalqty WHERE id='$orderId'");
                $deleteCartItems = mysqli_query($conn, "DELETE FROM carts WHERE userid='$userId'");
                echo "<script>alert('Order successfully placed'); window.location='../pages/cart.php';</script>";
                exit();
            } else {
                $error[] = "Error inserting order.";
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
    <title>Checkout - Food Ordering System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        .checkoutcontainer {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .heading {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        .checkoutsection {
            margin-bottom: 30px;
        }

        .checkhoutlabel {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        .checkoutinput-field,
        .checkoutselect-fileld {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .submit {
            display: block;
            width: 100%;
            padding: 15px;
            background-color: #FF2700;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .submit:hover {
            background-color: #d62500;
        }

        .productsList {
            list-style: none;
            padding-left: 0;
        }

        .order-summary p,
        .delivery-information p,
        .payment-options p {
            margin: 10px 0;
        }
    </style>
</head>

<body>
    <?php include ('../components/navbar.php');?>
    <div class="checkoutcontainer">
        <form action="" method="POST">
            <div class="heading">Checkout</div>
            <?php if (!empty($errors)): ?>
                <ul>
                    <?php foreach ($errors as $err): ?>
                        <li style="color:red;list-style:none;"><?php echo $err; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?> 
            <!-- Order Summary Section -->
            <section class="order-summary checkoutsection">
                <div class="heading">Order Summary</div>
                <?php
                $sql = "SELECT * FROM carts WHERE userid='$userId'";
                $query = mysqli_query($conn, $sql);

                if ($query && mysqli_num_rows($query) > 0) {
                    $totalCost = 0;
                    while ($fetchProduct = mysqli_fetch_assoc($query)) {
                        $productName = $fetchProduct['name'];
                        $quantity = $fetchProduct['quantity'];
                        $price = $fetchProduct['price'];
                        $subtotal = $quantity * $price;
                        $totalCost += $subtotal;
                        echo "<p>$productName x $quantity - Rs." . number_format($subtotal, 2) . "</p>";
                    }
                    echo "<p>Total: Rs." . number_format($totalCost, 2) . "</p>";
                } else {
                    echo "<p>No items in the cart.</p>";
                }
                ?>
            </section>

            <!-- Delivery Information Section -->
            <section class="delivery-information checkoutsection">
                <div class="heading">Delivery Information</div>
                <label class="checkhoutlabel">Email:</label>
                <input type="email" name="email" class="checkoutinput-field" value="<?php echo ($email) ? $email : ''; ?>" required disabled>

                <label class="checkhoutlabel">Address:</label>
                <input type="text" name="address" class="checkoutinput-field" value="<?php echo ($address) ? $address : ''; ?>" required>

                <label class="checkhoutlabel">Phone:</label>
                <input type="number" name="phone" class="checkoutinput-field" value="<?php echo ($number) ? $number : ''; ?>" required>
            </section>

            <!-- Payment Method Section -->
            <section class="payment-options checkoutsection">
                <div class="heading">Payment Method</div>
                <select name="paymentmethod" class="checkoutselect-fileld">
                    <option value="khalti">Khalti</option>
                    <option value="cash">Cash on Delivery</option>
                </select>
            </section>
            <input type="submit" name="placeOrder" class="submit">
        </form>
    </div>
    <?php include ('../components/footer.php');?>

</body>

</html>