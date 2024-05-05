<?php
include '../connection.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
    exit(); // Exit after redirection
}

if (isset($_POST['add_product'])) {

$name = strtolower($_POST['name']);
$price = strtolower($_POST['price']);
$category = strtolower($_POST['category']);
$description = strtolower($_POST['description']);


    $image = $_FILES['image']['name'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_img/' . $image;

    // Check if the category exists
    $select_category_query = "SELECT * FROM `categories` WHERE id = '$category'";
    $select_category_result = mysqli_query($conn, $select_category_query);
    if (mysqli_num_rows($select_category_result) == 0) {
        $message[] = 'Category does not exist! Category ID: ' . $category;
    
    } else {
        // Move uploaded image to folder
        move_uploaded_file($image_tmp_name, $image_folder);

        // Insert product into products table
        $insert_product_query = "INSERT INTO `products` (name, categoryID, price, image, description) VALUES ('$name', '$category', '$price', '$image', '$description')";
        $insert_product_result = mysqli_query($conn, $insert_product_query);

        // Check if the product was successfully inserted
        if ($insert_product_result) {
            $message[] = 'New product added!';
        } else {
            $message[] = 'Error adding product: ' . mysqli_error($conn);
        }
    }
}


if (isset($_GET['delete'])) {

    $delete_id = $_GET['delete'];

    $delete_product_image_query = "SELECT * FROM `products` WHERE id = '$delete_id'";
    $delete_product_image_result = mysqli_query($conn, $delete_product_image_query);
    $fetch_delete_image = mysqli_fetch_assoc($delete_product_image_result);

    unlink('../uploaded_img/' . $fetch_delete_image['image']);

    $delete_product_query = "DELETE FROM `products` WHERE id = '$delete_id'";
    $delete_product_result = mysqli_query($conn, $delete_product_query);

    if ($delete_product_result) {
        $delete_cart_query = "DELETE FROM `carts` WHERE pid = '$delete_id'";
        $delete_cart_result = mysqli_query($conn, $delete_cart_query);

        if (!$delete_cart_result) {
            $message[] = 'Error deleting cart items: ' . mysqli_error($conn);
        }
        header('location:products.php');
        exit(); // Exit after redirection
    } else {
        $message[] = 'Error deleting product: ' . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>products</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

</head>

<body>

    <?php include './admin_header.php' ?>
    <section class="add">
        <form action="" method="POST" enctype="multipart/form-data">
            <h1>Add Product</h1>
            <input type="text" required placeholder="enter product name" name="name" maxlength="100" class="box" id="box">
            <input type="number" min="0" max="9999999999" required placeholder="enter product price" name="price" onkeypress="if(this.value.length == 10) return false;" class="box" id="box">
            <select name="category" class="box" required id="box">
                <?php
                $show_category_query = "SELECT * FROM `categories`";
                $result = mysqli_query($conn, $show_category_query);

                // Check if any categories were found
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $name = $row['name'];
                        $id=$row['id'];
                        echo "<option value=\"$id\">$name</option>";
                    }
                } else {
                    echo '<option value="" disabled selected>No categories found</option>';
                }
                ?>
            </select>
            <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp" required id="box">
            <textarea name="description" id="description" name="description" class="description" rows="8" required minlength="100" style="resize: none;"></textarea>
            <input type="submit" value="add product" name="add_product" class="button">
        </form>

    </section>


    <div class="table">
        <h3 class="h3">Proudct List</h3>
        <table class="table">
            <thead>
                <tr>
                    <th class="first">Image</th>
                    <th class="two">Name</th>
                    <th class="category">category</th>
                    <th class="description">description</th>
                    <th class="third">Price</th>
                    <th class="five">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $show_products_query = "SELECT * FROM `products`";
                $show_products_result = mysqli_query($conn, $show_products_query);
                if (mysqli_num_rows($show_products_result) > 0) {
                    while ($fetch_products = mysqli_fetch_assoc($show_products_result)) {
                        $sql = mysqli_query($conn, "SELECT * FROM `categories` WHERE id='" . $fetch_products['categoryID'] . "'");
                        $data=mysqli_fetch_assoc($sql);
                        $name=$data['name'];
                ?>
                        <tr>
                            <td><img src="../uploaded_img/<?= $fetch_products['image']; ?>" alt=""></td>
                            <td><?= $fetch_products['name']; ?></td>
                            <td><?php echo $name?></td>
                            <td><?= $fetch_products['description']; ?></td>
                            <td><?= $fetch_products['price']; ?></td>
                            <td class="action">
                                <a href="update_product.php?update=<?= $fetch_products['id']; ?>" class="option-btn">Update</a>
                                <a href="products.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('Delete this product?');">Delete</a>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo '<tr><td colspan="4" class="empty">No products added yet!</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <style>
        .add {
            margin-top: 20px;
        }

        .description {
            width: 100%;
        }

        .add form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .add form h1 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }

        .add form input[type="text"],
        .add form input[type="number"],
        .add form select,
        .add form input[type="file"],
        .add form input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .add form input[type="file"] {
            padding: 10px 0;
        }

        .add form input[type="submit"] {
            margin-top: 10px;
            background-color: #FF2700;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .add form input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .heading {
            text-align: center;
            margin-top: 2rem;
            font-size: 2rem;
            text-transform: capitalize;
            text-decoration: underline;
            margin-bottom: 10px;
        }

        .h3 {
            text-align: center;
            font-size: 2rem;
            text-decoration: underline;
        }

        .table {
            width: 80%;
            border-collapse: collapse;
            /* margin-bottom: 20px; */
            margin: 10px auto;
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

        .table .description {
            width: 50%;
        }

        .table .name {
            font-weight: bold;
        }

        .table .price {
            font-style: italic;
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


        .option-btn,
        .delete-btn {
            margin: 2px;
            display: inline-block;
            padding: 6px 12px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .delete-btn {
            background-color: red;


        }

        .option-btn:hover,
        .delete-btn:hover {
            background-color: #0056b3;
        }

    </style>


</body>

</html>