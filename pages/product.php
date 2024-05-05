<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Inika&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .all_prod {
            /* max-width: 1280px; */
            padding: 40px 0;
            height: 100%;
            font-size: 14px;
            font-family: 'Inika', sans-serif;
            background-color: #e7e5e5;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .cart-container {
            max-width: 1400px;
            padding: 40px 0;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .product_cart {
            width: 250px;
            height: 300px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            width: 100%;
            height: 120px;
            background-color: #f6f6f6;
            display: flex;
            justify-content: center;
            align-items: center;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .header img {
            max-width: 100%;
            max-height: 100%;
        }

        .cart-content {
            padding: 20px;
        }

        .description {
            line-height: 18px;
            color: rgba(0, 0, 0, 0.8);
            font-size: 14px;

        }

        .order-btn {
            cursor: pointer;
            width: 100%;
            height: 40px;
            background-color: #ff6347;
            border-radius: 5px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 10px 0 0;
        }


        .order {
            cursor: pointer;
            font-size: 18px;
            color: white;
            /* background: none; */
            border: none;
            outline: none;
        }

        .name-price {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .name,
        .price {
            font-weight: bold;
            font-size: 16px;
        }

        .price {
            color: rgba(0, 0, 0, 0.8);
        }

        @media screen and (max-width: 600px) {
            .product_cart {
                width: calc(50% - 10px);
            }

            .cart-container {
                padding: 0 10px;
            }
        }

        .all_dishes {
            font-size: 40px;
            text-align: center;
            margin-bottom: 20px;
            text-decoration: underline;
        }
    </style>
    <title>Document</title>
</head>

<body>
    <section class="all_prod">
        <h1 class="all_dishes">All Dishes</h1>
        <div class="cart-container">

            <?php
            $select_products = mysqli_query($conn, "SELECT * FROM `products`");
            if (mysqli_num_rows($select_products) > 0) {
                // Output HTML for each product
                while ($product = mysqli_fetch_assoc($select_products)) {
            ?>
            <a style="text-decoration:none;color:black;" href="singleproduct.php?productId=<?= $product['id']; ?>">
                    <form class="product_cart" method="post">
                        <div class="header">
                            <input type="hidden" value="<?= $product['id']; ?>" name='pid'>
                            <input type="hidden" value="<?= $product['image']; ?>" name='image'>
                            <img src="../uploaded_img/<?= $product['image']; ?>" alt="">
                        </div>
                        <div class="cart-content">
                            <div class="name-price">
                                <input type="hidden" value="<?= $product['name']; ?>" name='name'>
                                <span class="name"><?= $product['name']; ?></span>
                                <input type="hidden" value="<?= $product['price']; ?>" name='price'>
                                <span class="price">Rs.<?= $product['price']; ?></span>
                            </div>
                            <p class="description"><?= substr($product['description'], 0, 90); ?>...</p>
                            <button type="submit" name="submit" class="order-btn order">Add to cart</button>
                        </div>
                    </form>
            </a>
            <?php
                }
            } else {
                echo '<p class="empty">No products added yet!</p>';
            }
            ?>
        </div>
    </section>
</body>
</html>
<?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
    // Check if the form has been submitted
    if (isset($_POST['submit'])) {
        if (isset($userId)) {
            $Image = $_POST['image'];
            $Name = $_POST['name'];
            $Price = $_POST['price'];
            $pid = $_POST['pid'];

            // Check if product is already in the cart
            $query = "SELECT * FROM `carts` WHERE userid='$userId' AND pid='$pid'";
            $result = mysqli_query($conn, $query);
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $newQuantity = $row['quantity'] + 1;
                // $newPrice = $row['price'] + $Price;
                $updateQuery = "UPDATE `carts` SET quantity='$newQuantity'WHERE userid='$userId' AND pid='$pid'";
                if (mysqli_query($conn, $updateQuery)) {
                    header("Location: " . $_SERVER['PHP_SELF']);
                    exit();
                }
            }
            // Insert data into the cart table
            $sql = "INSERT INTO carts (name, price, quantity, image, pid, userid) 
                    VALUES ('$Name', '$Price', '1', '$Image', '$pid', '$userId')";
            if (!mysqli_query($conn, $sql)) {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            } else {
                echo "<script>alert('successfully add item to cart');window.location='./home.php'</script>";
                exit();
            }
        } else {
            echo "<script>alert('please login to add items in carts');window.location='./home.php'</script>";
            exit();
        }
    }
}
?>