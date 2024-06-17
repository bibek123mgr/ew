<?php
// Include your database connection file
include('../connection.php');

$search_query = '';
$products = [];

if (isset($_GET['query'])) {
    $search_query = mysqli_real_escape_string($conn, $_GET['query']);

    // Execute search query to find products matching the search term
    $sql = "SELECT * FROM `products` WHERE `name` LIKE '%$search_query%' OR `description` LIKE '%$search_query%'";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Error executing query: " . mysqli_error($conn));
    }

    // Fetch matching products
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $products[] = $row;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services Section</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .all_prod {
            padding: 20px 0;
            height: 100%;
            font-size: 14px;
            font-family: 'Inika', sans-serif;
            background-color: #e7e5e5;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .search_section {
            padding: 20px;
            text-align: center;
        }

        .search_section form {
            display: inline-block;
            margin-bottom: 20px;
        }

        .search_section input[type="text"] {
            padding: 10px;
            font-size: 16px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .search_section button {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        .search_section button:hover {
            background-color: #0056b3;
        }

        .cart-container {
            max-width: 1400px;
            padding: 20px 0;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            gap: 10px;
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
            position: relative;
        }

        .header img {
            max-width: 140px;
            max-height: 100%;
            margin-top: 25px;
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
            margin: 10px 0;
        }

        .order {
            cursor: pointer;
            font-size: 18px;
            color: white;
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

        .empty {
            font-size: 18px;
            color: #555;
            text-align: center;
        }
    </style>
</head>

<body>
    <?php
    ob_start();
    include("../connection.php");
    session_start();
    include("../components/fetchdata.php");
     include('../components/navbar.php') ?>
    
    <section class="all_prod">
        <h1 class="all_dishes">Search Results</h1>
        <div class="cart-container">
            <?php if (!empty($products)) {
                foreach ($products as $product) { ?>
                    <form class="product_cart" method="post">
                        <div class="header">
                            <input type="hidden" value="<?= $product['id']; ?>" name='pid'>
                            <input type="hidden" value="<?= $product['image']; ?>" name='image'>
                            <a href="view.php?pid=<?= $product['id']; ?>"><img src="../uploaded_img/<?= $product['image']; ?>" alt=""></a>
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
                <?php }
            } else {
                echo '<p class="empty">No products found!</p>';
            } ?>
        </div>
    </section>
    <?php include('../components/footer.php') ?>
</body>

</html>