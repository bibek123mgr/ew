<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Food Delivery Footer</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
   <style>
      /* Global Styles */
      body {
         font-family: Arial, sans-serif;
         margin: 0;
         padding: 0;
      }

      /* Footer Styles */
      footer {
         background-color: #333;
         color: #fff;
         padding: 15px 0;
         text-align: center;
      }

      .footer-text {
         margin-bottom: 5px;
         font-size: 24px;
      }

      .footer-links a {
         color: #fff;
         text-decoration: none;
         margin: 0 5px;
         transition: color 0.3s;
      }

      .footer-links a:hover {
         color: #ddd;
      }

      .contact-info {
         margin-top: 10px;
      }

      .contact-info p {
         margin-bottom: 5px;
      }

      .social-icons {
         margin-top: 20px;
      }

      .social-icons a {
         color: #fff;
         font-size: 20px;
         margin: 0 10px;
         text-decoration: none;
         transition: color 0.3s;
      }

      .social-icons a:hover {
         color: #ddd;
      }

      .owner {
         margin-top: 20px;
      }

      /* Responsive Styles */
      @media screen and (max-width: 768px) {
         footer {
            padding: 20px 0;
         }
      }

      a {
         cursor: pointer;
      }
   </style>
</head>

<body>

   <footer>
      <div class="container">
         <div class="footer-text">Food Land</div>
         <div class="footer-links">
            <a href="../pages/home.php">Home</a>
            <a href="../pages/about_more_page.php">About Us</a>
            <a href="../pages/contact.php">Contact</a>
            <a href="../pages/services.php">Services</a>
         </div>
         <div class="contact-info">
            <p>32900 Tilottama Rupendehi</p>
            <p>Lumbini Province,2914</p>
            <p>info@foodland.com</p>
            <p>(123) 456-7890</p>
         </div>
         <div class="social-icons">
            <a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a>
            <a href="#" target="_blank"><i class="fab fa-twitter"></i></a>
            <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
         </div>
         <p class="owner">&copy;
            <?= date('Y'); ?> Food Land. All rights reserved.
         </p>
      </div>
   </footer>

</body>

</html>