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
        // Fetch user details
        $sql_user = "SELECT * FROM users WHERE id='$userId'";
        $result_user = mysqli_query($conn, $sql_user);

        if (mysqli_num_rows($result_user) > 0) {
            $fetch_user = mysqli_fetch_assoc($result_user);
            $name = $fetch_user['name'];
            $email = $fetch_user['email'];
            $number = $fetch_user['number'];
            $address = $fetch_user['address'];

            if (empty($number) || empty($address)) {
                $error = 'Please update your profile';
            } else {
                // Fetch cart items
                $sql = "SELECT * FROM carts WHERE userid='$userId'";
                $query = mysqli_query($conn, $sql);
        
                if ($query && mysqli_num_rows($query) > 0) {
                    $grandTotal = 0;
                    $subtotal = 0;
                    $totalqty = 0;
                    $orderId=md5(uniqid());
                    // Insert order into orderss table
                    $inserOrder = mysqli_query($conn, "INSERT INTO orderss (id,orderStatus, userId, shippingAddress, phoneNumber) VALUES ('$orderId;'pending', '$userId', '$address', '$number')");
                    if ($inserOrder) {
                        // Get the order ID of the inserted order
                        $orderId = mysqli_insert_id($conn);
                        while ($fetchProduct = mysqli_fetch_assoc($query)) {
                            $productId = $fetchProduct['pid'];
                            $quantity = $fetchProduct['quantity'];
                            $price = $fetchProduct['price'];
                            $totalqty += $quantity;
                            $subtotal = $price * $quantity;
                            $grandTotal += $subtotal;
                            // Insert order details into orderdetails table
                            $placeOrder = mysqli_query($conn, "INSERT INTO orderdetails (orderId, productId, quantity, price) VALUES ('$orderId', '$productId', '$quantity', $price)");
                        }
                        $paymentId=md5(uniqid());
                        // Insert payment details into paymentDetails table
                        $paymentDetails = mysqli_query($conn, "INSERT INTO paymentDetails (id,paymentMethod, paymentStatus, pidx) VALUES ('$paymentId','khalti', 'paid', '$pidx')");
                        if ($paymentDetails) {
                            $paymentId = mysqli_insert_id($conn);
                        } else {
                            $error[] = "Error inserting payment details.";
                        }
                        // Update order with amount, paymentId, and quantity
                        $update = mysqli_query($conn, "UPDATE orderss SET amount='$grandTotal', paymentId='$paymentId', quantity='$totalqty' WHERE id='$orderId'");
                        if (!$update) {
                            $error[] = "Error updating order.";
                        }
        
                        // Delete items from cart
                        $deleteCartItems = mysqli_query($conn, "DELETE FROM carts WHERE userid='$userId'");
                        if (!$deleteCartItems) {
                            $error[] = "Error deleting cart items.";
                        }
        
                        // Redirect to cart page with success message
                        header("Location: ../pages/cart.php");
                        exit();
                    } else {
                        $error[] = "Error inserting order.";
                    }
                } else {
                    $error[] = "No items in the cart.";
                }
            }
        } else {
            $error = 'Error fetching user data';
        }
    } else {
        $error = "User ID is empty";
    }
}

// If any error occurs, handle it here
if (isset($error)) {
    echo implode("<br>", $error);
}
?>
