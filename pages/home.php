<?php
session_start();
require('../connection.php');
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
   <!-- <link rel="stylesheet" href="../css/home.css"> -->
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Langar&family=Poppins:wght@200;300&display=swap" rel="stylesheet">
</head>

<body>
   <?php include("../components/navbar.php"); ?>
   <?php include("../components/herosection.php"); ?>
   <?php 
   $selectCart=mysqli_query($conn,"SELECT * FROM `products`");
   if(mysqli_num_rows($selectCart) > 0){
      include('./product.php'); 
   }else{
      echo "<div style='padding-top:50px;text-decoration:underline;'><h1>No product Items</h1></div>";
   }
   ?>
   <?php include '../components/about.php'; ?>
   <?php include '../components/footer.php'; ?>


   <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

   <!-- custom js file link  -->
   <!-- <script src="js/script.js"></script> -->

   <style>
      .products {
         padding: 30px 0 20px;
      }
   </style>

</body>


</html>