<?php
session_start();
require('../connection.php');
    if (isset($_GET['productId'])) {
        $pid = $_GET['productId'];
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Langar&family=Poppins:wght@200;300&display=swap" rel="stylesheet">
</head>

<body>
   <?php include("../components/navbar.php"); ?>

   <section class="quick-view">
    <div class="prod">
        <?php
            $select_product = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$pid'");
            if (!$select_product) {
                die("Error fetching product details: " . mysqli_error($conn));
            }
            if (mysqli_num_rows($select_product) > 0) {
                $product = mysqli_fetch_assoc($select_product);
        ?>
                <form class="product_cart"   method="post">
                        <input type="hidden" name="image" value="<?= $product['image']; ?>">
                         <input type="hidden" name="name" value="<?= $product['name']; ?>">
                         <input type="hidden" name="price" value="<?= $product['price']; ?>">
                    <div class="product-details">
                        <div class="product">
                        <img src="../uploaded_img/<?= $product['image']; ?>" alt="">
                        </div>
                        <div class="image">
                        <h2><?= $product['name']; ?></h2>
                        <p>Price: Rs.<?= $product['price']; ?></p>
                        <p><?= $product['description']; ?></p>
                        <div style="display:flex">
                        <button type="submit" name="submit" class="order-btn order">Add to cart</button>
                        <input type="number" name="number" id="numberInput" style="width:40px; margin-left:10px;text-align:center;" value="1" onchange="validateInput()">
                        </div>
                        </div>
                    </div>
                </form>
            <?php
            } else {
                echo '<p>No product found!</p>';
            }
            ?>

</div>

    </section>

   
    <style>
        /* CSS for quick view page */

body {
    font-family: 'Inika', sans-serif;
    margin: 0;
    padding: 0;
}
.order{
    cursor: pointer;
    font-size: 18px;
    color: white;
    border: none;
    padding: 8px;
    border-radius: 3px;
    outline: none;
    background-color: #ff6347;
}
.product_cart{
    margin: 0 auto;

}

.quick-view {
    max-width: 1200px;
    margin: 0 auto;
    display:flex;
    flex-direction:column;
    padding: 20px;
}

.product-details {
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin: 0 auto;
}

.product-details img {
    min-height: 300px;
    max-height:650px;
    height: auto;
    width:100%;
    /* border-radius: 5px; */
    /* margin-bottom: 20px;
    margin-left: -20px;
    margin-top: 30px; */
}

.product-details h2 {
    font-size: 24px;
    margin-bottom: 10px;
}

.product-details p {
    font-size: 16px;
    line-height: 1.5;
    margin-bottom: 15px;
}

.product-details a {
    display: inline-block;
    background-color: #007bff;
    color: #fff;
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.product-details a:hover {
    background-color: #0056b3;
}

/* You can add more styles as needed */

    </style>

<script>
    function validateInput() {
        var numberInput = document.getElementById('numberInput');
        var value = parseFloat(numberInput.value);
        
        // If the entered value is less than or equal to 0, set it to 1
        if (value <= 0 || isNaN(value)) {
            numberInput.value = 1;
        }
    }
</script>

   <?php include '../components/footer.php'; ?>


   <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

   <!-- custom js file link  -->
   <!-- <script src="js/script.js"></script> -->

   <!-- <style>
      .products {
         padding: 30px 0 20px;
      }
   </style> -->

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
            $number=$_POST['number'];
            $query = "SELECT * FROM `carts` WHERE userid='$userId' AND pid ='$pid'";
            $result = mysqli_query($conn, $query);
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $newQuantity = $row['quantity'] + $number;
                // $newPrice = $row['price'] + $Price;
                $updateQuery = "UPDATE `carts` SET quantity='$newQuantity' WHERE userid='$userId' AND pid='$pid'";
                if (mysqli_query($conn, $updateQuery)) {
                echo "<script>alert('product adds in cart');window.location='./singleproduct.php?productId=" . $_GET['productId'] . "'</script>";
                exit();
                }
            }
            // Insert data into the cart table
            $sql = "INSERT INTO `carts` (name, price, quantity, image, pid, userid) 
                    VALUES ('$Name', '$Price', '$number', '$Image', '$pid', '$userId')";
            if (!mysqli_query($conn, $sql)) {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            } else {
                echo "<script>alert('product adds in cart');window.location='./singleproduct.php?productId=" . $_GET['productId'] . "'</script>";
                exit();
            }
        } else {
            echo "<script>alert('please login to add items in carts');window.location='./singleproduct.php?productId=" . $_GET['productId'] . "'</script>";
            exit();
        }
    }
}
?>
