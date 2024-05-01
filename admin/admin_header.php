<?php
if (isset($message)) {
   foreach ($message as $msg) {
      echo '
      <div class="message">
         <span>' . $msg . '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">
   <link rel="stylesheet" href="navbar.css">
   <section class="flex">

      <a href="dashboard.php" class="logo">Food<span>Land</span></a>

      <nav class="navbar">
         <a href="dashboard.php">Dashboard</a>
         <a href="products.php">Products</a>
         <a href="placed_orders.php">Orders</a>
         <a href="users_accounts.php">Users</a>
         <a href="category.php">Category</a>
        <a href="messages.php">Messages</a>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="profile">
         <?php
         $select_profile_query = mysqli_query($conn, "SELECT * FROM `admins` WHERE id = '$admin_id'");
         $fetch_profile = mysqli_fetch_assoc($select_profile_query);
         ?>
         <p><?= $fetch_profile['name'] ?? ''; ?></p>
         <a href="update_profile.php" class="btn">update profile</a>
         <div class="flex-btn">
            <a href="register_admin.php" class="option-btn">register</a>
            <a href="./admin_logout.php" onclick="return confirm('logout from this website?');" class="delete-btn">logout</a>
         </div>
      </div>

   </section>

</header>

<style>
   :root {
      --yellow: #fed330;
      --red: #e74c3c;
      --white: #fff;
      --black: #222;
      --light-color: #777;
      --border: .2rem solid var(--black);
   }

   * {
      font-family: 'Rubik', sans-serif;
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      outline: none;
      border: none;
      text-decoration: none;
   }

   *::selection {
      background-color: yellow;
      color: black;
   }

   ::-webkit-scrollbar {
      height: .3rem;
      width: 0.5rem;
   }

   ::-webkit-scrollbar-thumb {
      background-color: black;
   }

   html {
      font-size: 62.5%;
      overflow-x: hidden;
      scroll-behavior: smooth;
      stop-opacity: 7rem;
   }

   section {
      margin: 0 auto;
      max-width: 1200px;
      padding: 2rem;
   }

   .log {
      background-color: orangered;
      padding: 10px;
      font-size: 2rem;
      color: white;
      margin-right: 1rem;
      border-radius: 10px;
   }

   .land {
      color: orangered;
   }

   .header {
      position: sticky;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1000;
      background-color: white;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
   }

   .header .flex {
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: relative;
   }

   .header .flex .logo {
      font-size: 2.5rem;
      /* font-weight: bold; */
      color: var(--black);
   }

   .logo span {
      color: #FF2700;
   }

   .header .flex .navbar a {
      font-size: 2rem;
      color: black;
      margin: 0 2rem;
   }

   .navbar {
      margin-left: 120px;
   }

   .header .flex .navbar a:hover {
      color: red;
   }

   .header .flex .icons>* {
      margin-left: 2rem;
      font-size: 2.5rem;
      color: black;
      cursor: pointer;
   }

   .header .flex .icons>*:hover {
      color: red;
   }

   .header .flex .icons span {
      font-size: 2rem;
   }

   #menu-btn {
      display: none;
   }

   .header .flex .profile {
      background-color: white;
      border: 1px solid black;
      padding: 1.5rem;
      text-align: center;
      position: absolute;
      top: 125%;
      right: 2rem;
      width: 30rem;
      display: none;
      animation: fadeIn .2s linear;
   }

   .header .flex .profile.active {
      display: inline-block;
   }

   @keyframes fadeIn {
      0% {
         transform: translateY(1rem);
      }
   }

   .header .flex .profile .name {
      font-size: 2rem;
      color: var(--black);
      margin-bottom: .5rem;
   }

   .header .flex .profile .account {
      margin-top: 1.5rem;
      font-size: 2rem;
      color: var(--light-color);
   }

   .header .flex .profile .account a {
      color: var(--black);
   }

   .header .flex .profile .account a:hover {
      color: yellow;
      text-decoration: underline;
   }

   .profile {
      background-color: #f9f9f9;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      text-align: center;
   }

   .profile p {
      font-size: 18px;
      font-weight: bold;
      margin-bottom: 10px;
   }

   .btn {
      display: inline-block;
      padding: 10px 20px;
      background-color: #007bff;
      color: #fff;
      text-decoration: none;
      border-radius: 5px;
      transition: background-color 0.3s ease;
      margin-right: 10px;
   }

   .btn:hover {
      background-color: #0056b3;
   }

   .flex-btn {
      margin-top: 20px;
   }

   .option-btn {
      display: inline-block;
      padding: 8px 16px;
      background-color: #ffc107;
      color: #212529;
      text-decoration: none;
      border-radius: 5px;
      transition: background-color 0.3s ease;
      margin-right: 10px;
   }

   .option-btn:hover {
      background-color: #ffca28;
   }

   .delete-btn {
      display: inline-block;
      padding: 8px 16px;
      background-color: #f44336;
      color: #fff;
      text-decoration: none;
      border-radius: 5px;
      transition: background-color 0.3s ease;
   }

   .delete-btn:hover {
      background-color: #b71c1c;
   }

   /*  */

   @media (max-width:991px) {

      html {
         font-size: 55%;
      }

   }

   @media (max-width:768px) {

      #menu-btn {
         display: inline-block;
      }

      .header .flex .navbar {
         position: absolute;
         top: 99%;
         left: 0;
         right: 0;
         border-radius: 5px;
         background-color: white;
         box-shadow: 3px 3px 5px 0px rgba(0, 0, 0, 0.5);
         border: 1px solid whitesmoke;
         margin-top: 2rem;
         margin-right: 7rem;
         transition: .2s linear;
         clip-path: polygon(0 0, 100% 0, 100% 0, 0 0);
      }

      .header .flex .navbar a {
         display: block;
         margin: 5rem;
      }

      .header .flex .navbar.active {
         clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
      }

   }

   @media (max-width:450px) {

      html {
         font-size: 50%;
      }

      .title {
         font-size: 3rem;
      }

      .header .flex .logo {
         font-size: 2rem;
      }
   }
</style>

</style>