<?php
include('../connection.php');
session_start();
include('../components/fetchdata.php');
// Check if pidx is set
if(isset($_GET['pidx'])){
    $pidx = $_GET['pidx'];
}
// Function to verify pidx
function verifypidx($pidx) {
    $url = "https://a.khalti.com/api/v2/epayment/lookup/"; 
    $data = array(
        'pidx' => $pidx
    );

    $headers = array(
        'Authorization: key 191e809935014f76869721a2989cbc16'
    );

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if ($response === false) {
        $error = curl_error($ch);
        curl_close($ch);
        return "Error: " . $error;
    }

    curl_close($ch);

    // Decode the JSON response
    $responseData = json_decode($response, true);

    if ($responseData["status"] == "Completed") {
        // Set session variables for successful transaction
        $_SESSION['transaction_details'] = $responseData; 
        $_SESSION['transaction_status'] = "success";
    } else {
        // Redirect or handle unsuccessful transaction
        header("Location: ../error_page.php");
        exit();
    }
}

// Verify pidx
verifypidx($pidx);

// Process order if transaction is successful
if (isset($_SESSION['transaction_status']) && $_SESSION['transaction_status'] === "success") {
    // Assuming $userId is available somewhere
    if (!empty($userId)) {

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
        // Fetch user details
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
                $paymentDetails = mysqli_query($conn, "INSERT INTO paymentDetails (id, paymentMethod, paymentStatus,pidx) VALUES ('$paymentId', 'khalti', 'paid','$pidx')");
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
    <title>Document</title>
</head>
<body>
    
</body>
</html>