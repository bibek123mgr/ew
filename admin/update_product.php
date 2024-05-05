<?php

include '../connection.php';
session_start();
$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['update'])){

   $pid = $_POST['pid'];
   $name = $_POST['name'];
   $price = $_POST['price'];
   $category = $_POST['category'];
   // Update product information
   $update_product_query = "UPDATE `products` SET name = '$name', categoryID = '$category', price = '$price' WHERE id = '$pid'";
   $update_product_result = mysqli_query($conn, $update_product_query);

   if($update_product_result) {
      $message[] = 'Product updated!';
   } else {
      $message[] = 'Error updating product: ' . mysqli_error($conn);
   }

   $old_image = $_POST['old_image'];
   $image = $_FILES['image']['name'];
   // $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../uploaded_img/'.$image;

   if(!empty($image)){
      if($image_size > 2000000){
         $message[] = 'Images size is too large!';
      }else{
         // Update product image
         $update_image_query = "UPDATE `products` SET image = '$image' WHERE id = '$pid'";
         $update_image_result = mysqli_query($conn, $update_image_query);
         if($update_image_result) {
            move_uploaded_file($image_tmp_name, $image_folder);
            unlink('../uploaded_img/'.$old_image);
            $message[] = 'Image updated!';
         } else {
            $message[] = 'Error updating image: ' . mysqli_error($conn);
         }
      }
   }

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update product</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">


</head>
<body>

<?php include './admin_header.php' ?>

<!-- update product section starts  -->

<section class="update-product">

   <h1 class="heading">update product</h1>

   <?php
$update_id = $_GET['update'];
$show_products_query = "SELECT * FROM `products` WHERE id = '$update_id'";
$show_products_result = mysqli_query($conn, $show_products_query);
if(mysqli_num_rows($show_products_result) > 0){
   while($fetch_products = mysqli_fetch_assoc($show_products_result)){  
?>
   <form action="" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
      <input type="hidden" name="old_image" value="<?= $fetch_products['image']; ?>">
      <img src="../uploaded_img/<?= $fetch_products['image']; ?>" alt="">
      <span>update name</span>
      <input type="text" required placeholder="enter product name" name="name" maxlength="100" class="box" value="<?= $fetch_products['name']; ?>">
      <span>update price</span>
      <input type="number" min="0" max="9999999999" required placeholder="enter product price" name="price" onkeypress="if(this.value.length == 10) return false;" class="box" value="<?= $fetch_products['price']; ?>">
      <span>update category</span>
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
      <span>update image</span>
      <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp">
      <div class="flex-btn">
         <input type="submit" value="update" class="btn" name="update">
         <a href="products.php" class="option-btn">go back</a>
      </div>
   </form>
   <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
   ?>

</section>

<!-- update product section ends -->

<style>
   .update-product {
  max-width: 400px;
  margin: 0 auto;
  padding: 20px;
  background-color: #f9f9f9;
  border: 1px solid #ddd;
  border-radius: 5px;
}

.update-product .heading {
  text-align: center;
  font-size: 2rem;
  margin-bottom: 20px;
}

.update-product form {
  display: flex;
  flex-direction: column;
}

img{
   width: 20rem;
   margin-left: 8rem;
}

.update-product form input[type="text"],
.update-product form input[type="number"],
.update-product form select {
  margin-bottom: 15px;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 5px;
}

.update-product form input[type="file"] {
  margin-bottom: 15px;
}

.update-product form .flex-btn {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.update-product form .btn,
.update-product form .option-btn {
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 1rem;
  text-transform: uppercase;
}

.update-product form .btn {
  background-color: #007bff;
  color: #fff;
}

.update-product form .option-btn {
  background-color: #f9f9f9;
  color: #007bff;
  border: 1px solid #007bff;
}

.update-product form .option-btn:hover {
  background-color: #007bff;
  color: #fff;
}

</style>










<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>