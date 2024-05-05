<?php
session_start();
include('../connection.php');
include('../components/fetchdata.php');

if (isset($_SESSION['transaction_status'])) {
    unset($_SESSION['transaction_status']);
}
if (!isset($userId)) {
    echo "<script>alert('please login first'); window.location='login.php';</script>";
}
if (isset($_POST['delete'])) {
    $cart_id = $_POST['cart_id'];
    $delete_query = "DELETE FROM `carts` WHERE id = '$cart_id'";
    if (mysqli_query($conn, $delete_query)) {
        $message[] = 'cart item deleted!';
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

if (isset($_POST['delete_all'])) {
    $delete_query = "DELETE FROM `carts` WHERE userid = '$userId'";
    if (mysqli_query($conn, $delete_query)) {
        $message[] = 'deleted all from cart!';
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

if (isset($_POST['update_qty'])) {
    $cart_id = $_POST['cart_id'];
    $qty = $_POST['qty'];
    $update_query = "UPDATE `carts` SET quantity = '$qty' WHERE id = '$cart_id'";
    if (mysqli_query($conn, $update_query)) {
        $message[] = 'cart quantity updated';
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

$grand_total = 0;
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>

<body>

    <?php include '../components/navbar.php'; ?>
    <div class="cartAndOrders">
        <section class="allcart_components">
            <div class="before">
                <div class="heading">
                    <h3>shopping cart</h3>
                </div>
                <div class="table">
                    <table>
                        <thead>
                            <tr>
                                <th class="first">Image</th>
                                <th class="two">Item</th>
                                <th class="third">Price</th>
                                <th class="four">Quantity</th>
                                <th class="five">Action</th>
                            </tr>
                        </thead>
                        <?php
                        $select_query = "SELECT * FROM `carts` WHERE userid = '$userId'";
                        $result = mysqli_query($conn, $select_query);

                        if ($result) {
                            if (mysqli_num_rows($result) > 0) {
                                while ($fetch_cart = mysqli_fetch_assoc($result)) {
                                    $sub_total = $fetch_cart['price'] * $fetch_cart['quantity'];
                                    $grand_total += $sub_total;
                        ?>
                                    <tr>
                                        <td>
                                            <img src="../uploaded_img/<?= $fetch_cart['image']; ?>" alt="">
                                        </td>
                                        <td class="name">
                                            <?= $fetch_cart['name']; ?>
                                        </td>
                                        <td class="price">
                                            <span>Rs</span><?= $fetch_cart['price']; ?>
                                        </td>
                                        <td>
                                            <form action="" method="post">
                                                <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
                                                <input type="number" name="qty" class="qty" max="99" value="<?= $fetch_cart['quantity']; ?>" maxlength="2">
                                                <button type="submit" class="update" name="update_qty">Update</button>
                                            </form>
                                        </td>
                                        <td>
                                            <form action="" method="post">
                                                <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
                                                <button type="submit" class="car" name="delete" onclick="return confirm('Delete this item?');">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                        <?php
                                }
                            } else {
                                echo '<tr><td colspan="5" class="empty">Your cart is empty</td></tr>';
                            }
                        } else {
                            echo "Error: " . mysqli_error($conn);
                        }
                        ?>
                    </table>
                </div>

                <div class="cart-total" id="none">
                    <form action="" method="post">
                        <a href="<?= ($grand_total > 0) ? '../services/checkOutOrders.php' : 'javascript:void(0)'; ?>" class="btn <?= ($grand_total > 0) ? '' : 'disabled'; ?>" <?php if ($grand_total <= 0) echo 'disabled'; ?>>Proceed to Checkout</a>
                        <button>
                            <p>Total : <?= $grand_total; ?></p>
                        </button>
                        <button type="submit" id="delete" class="delete-btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>" name="delete_all" onclick="return confirm('Delete all items from cart?');">Delete All</button>
                    </form>
                </div>

                <div class="more-btn">
                    <a href="home.php" class="btn" id="btn">Continue Shopping</a>
                </div>
            </div>
        </section>
    </div>
    <script src="js/script.js"></script>

    <style>
        .cartAndOrders {
            margin: 0 auto;
            max-width: 1280px;
        }

        .allcart_components {
            display: flex;
            /* flex-direction: column; */
            /* align-items: center; */
            gap: 50px;
            justify-content: center;
        }

        .heading {
            text-align: center;
            margin-top: 2rem;
            font-size: 2rem;
            text-transform: capitalize;
            text-decoration: underline;
            margin-bottom: 10px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            /* margin-bottom: 20px; */
            margin: auto;
            /* margin-left: 30rem; */
        }

        table {
            margin: auto;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2;
        }

        .table img {
            max-width: 100px;
            height: auto;
        }

        .table .name {
            font-weight: bold;
        }

        .table .price {
            font-style: italic;
        }

        .table .qty {
            width: 30px;
            border: 1px solid;
        }

        .table .update,
        .table .car {
            padding: 6px 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .table .update:hover,
        .table .car:hover {
            background-color: #0056b3;
        }

        .cart-total {
            margin-top: 20px;
            text-align: center;
        }

        .cart-total .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .cart-total .btn:hover {
            background-color: #0056b3;
        }

        .cart-total button {
            padding: 10px 20px;
            border: none;
            background-color: #dc3545;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .cart-total button:hover {
            background-color: #c82333;
        }

        .cart-total .delete-btn.disabled {
            pointer-events: none;
            opacity: 0.5;
        }

        .more-btn {
            margin-top: 20px;
            text-align: center;
        }

        .more-btn .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .more-btn .btn:hover {
            background-color: #0056b3;
        }

        /* Responsive styles */
        @media (max-width: 768px) {

            .cart-total .btn,
            .more-btn .btn {
                padding: 8px 16px;
            }

            .allcart_components {
                flex-direction: column;
            }
        }

        @media (max-width: 480px) {

            .cart-total .btn,
            .more-btn .btn {
                padding: 6px 12px;
            }

            .table th.two,
            .table td.name {
                display: none;
            }
        }
    </style>



</body>

</html>