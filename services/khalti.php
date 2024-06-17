<?php
include('../connection.php');
session_start();
include('../components/fetchdata.php');

function pay($totalamount, $name, $email, $phone, $productorderid, $productname)
{
    $curl = curl_init();
    $data = array(
        'return_url' => 'http://localhost/foodapp/services/success.php',
        'website_url' => 'http://localhost/foodapp/pages/home.php',
        'amount' => $totalamount,
        'purchase_order_id' => $productorderid .time(),
        'purchase_order_name' => $productname,
        'customer_info' => array(
            'name' => $name,
            'email' => $email,
            'phone' => $phone
        )
    );
    $payload = json_encode($data);

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://a.khalti.com/api/v2/epayment/initiate/',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $payload,
        CURLOPT_HTTPHEADER => array(
            'Authorization: Key 191e809935014f76869721a2989cbc16',
            'Content-Type: application/json',
        ),
    ));

    $response = curl_exec($curl);

    if ($response === false) {
        echo "Error: " . curl_error($curl);
    } else {
        $response_array = json_decode($response, true);
        if (isset($response_array['payment_url'])) {
            $payment_url = $response_array['payment_url'];
            header("Location: $payment_url");
            exit();
        } else {
            echo "Error: Payment URL not found in response.";
            var_dump($response_array); // Output the response for debugging
        }
    }

    curl_close($curl);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Initiate Payment</title>
</head>

<body>
    <?php
    // Check if user is logged in and fetch user ID
    if (isset($userId)) {

        // Fetch cart items and user details
        $sql = "SELECT * FROM carts WHERE userid='$userId'";
        $query = mysqli_query($conn, $sql);

        if ($query && mysqli_num_rows($query) > 0) {
            $totalCost = 0;
            while ($fetchProduct = mysqli_fetch_assoc($query)) {
                $productId = $fetchProduct['pid'];
                $productName = $fetchProduct['name'];
                $quantity = $fetchProduct['quantity'];
                $price = $fetchProduct['price'];
                $subtotal = $quantity * $price;
                $totalCost += $subtotal;
            }

            // Fetch user details
            $fetchuser = "SELECT * FROM users WHERE id='$userId'";
            $checkquery = mysqli_query($conn, $fetchuser);

            if ($checkquery && mysqli_num_rows($checkquery) > 0) {
                $fetch_user = mysqli_fetch_assoc($checkquery);
                $name = $fetch_user['name'];
                $email = $fetch_user['email'];
                $number = $fetch_user['number'];
                $address = $fetch_user['address'];

                $totalamount = $totalCost * 100;

                // Call the function with the provided arguments
                pay($totalamount, $name, $email, $number, $productId, $productName);
            } else {
                echo 'Error: Something went wrong fetching user data.';
            }
        } else {
            echo "<p>No items in the cart.</p>";
        }
    } else {
        echo 'Error: User not logged in.';
    }
    ?>
</body>

</html>