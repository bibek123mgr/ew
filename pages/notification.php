<?php
include ('../connection.php');
session_start();
include('../components/fetchdata.php');

if(isset($_POST['delete_notification'])) {
    $notificationId = $_POST['notification_id'];

    // Delete the notification from the database
    $deleteQuery = mysqli_query($conn, "DELETE FROM `notifications` WHERE id = '$notificationId'");
    if($deleteQuery) {
        // If deletion is successful, redirect to the current page
        header("Location: $_SERVER[PHP_SELF]");
        exit();
    } else {
        // If deletion fails, display an error message
        $deleteError = "Error: Failed to delete notification.";
    }
}

if(isset($_POST['clearall'])) {
    $deleteQuery = mysqli_query($conn, "DELETE FROM `notifications` WHERE userId = '$userId'");
    if($deleteQuery) {
        // If deletion is successful, redirect to the current page
        header("Location: $_SERVER[PHP_SELF]");
        exit();
    } else {
        // If deletion fails, display an error message
        $deleteError = "Error: Failed to delete notification.";
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification Template</title>
    <style>
        .notification {
            font-family: Arial, sans-serif;
            margin: 20px auto;
            padding: 0;
            display: flex;
            justify-content: center;
            background-color: #f5f5f5;
        }

        #notifications-container {
            max-width: 1280px;
            width: 100%;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center; /* Center horizontally */
        }

        .notification {
            width: 100%;
            max-width: 800px; /* Adjust as needed */
            padding: 15px;
            margin-bottom: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
            display: flex;
            align-items: center;
        }

        .notification-text {
            flex-grow: 1;
            margin-right: 15px;
            font-size: 16px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .delete-btn {
            cursor: pointer;
            font-size: 16px;
            color: #ff0000;
        }

        #clear-all-btn {
            margin-top: 20px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            font-size: 16px;
        }

        #clear-all-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <?php include("../components/navbar.php")?>
    <div class="notification">
    <div style="display:flex;flex-direction:column;align-items:center">
    <div id="notifications-container">
        <?php

        if (isset($userId)) {
            $query = "SELECT * FROM notifications WHERE userId = '$userId'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='notification'>";
                    echo "<div class='notification-text'>" . $row['message'] . "</div>";
                    echo "<form method='post'>";
                    echo "<input type='hidden' name='notification_id' value='" . $row['id'] . "'>";
                    echo "<button type='submit' name='delete_notification' class='delete-btn'>❌</button>";
                    echo "</form>";
                    echo "</div>";
                }
                echo "<form action='' method='POST'>";
                echo "<button id='clear-all-btn' name='clearall' type='submit'>Clear All Notifications</button>";
                echo "</form>";
            } else {
                echo "<p>No notifications found.</p>";
            }
        } else {
            echo "<p>Please log in to view notifications.</p>";
        }
        ?>
    </div>
    </div>
    </div>
</body>

