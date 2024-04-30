<?php
require('../connection.php');
if (isset($_SESSION['user_data'])) {
    $fetch_profile = $_SESSION['user_data'];
    $userId = $fetch_profile['id'];
    $emailAddress = $fetch_profile['email'];
    $userName = $fetch_profile['name'];
    $userAddress = $fetch_profile['address'];
    $userNumber = $fetch_profile['number'];
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