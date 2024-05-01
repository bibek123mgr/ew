<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Fira+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Fira Sans", sans-serif;
            font-weight: 400;
            font-style: normal;
        }

        .logo span {
            color: #FF2700;
        }

        nav {
            width: 100%;
            max-width: 1400px;
            padding: 15px 10px;
            margin: 0 auto;
        }

        .menu {
            font-size: 18px;
            gap: 20px;
        }

        nav {
            z-index: 999;
        }

        nav,
        .menu,
        .user {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .user {
            gap: 15px;
        }

        .menu li,
        .user li {
            list-style: none;
            cursor: pointer;
        }

        .menu li a,
        .user li a {
            text-decoration: none;
            color: black;
        }

        .logo a {
            text-decoration: none;
            color: black;
            font-size: 25px;
        }

        .nav_btn {
            background-color: #FF2700;
            border: none;
            outline: none;
            cursor: pointer;
            font-size: 18px;
            padding: 5px;
        }

        .nav_input {
            border: none;
            outline: none;
            background-color: transparent;
            width: 90%;
            height: 80%;
            border-radius: 23px;
            padding: 5px;
        }

        .toggler a {
            cursor: pointer;
            margin-right: 10px;
        }

        .search_bar form {
            width: 250px;
            height: 30px;
            background-color: #D9D9D9;
            border-radius: 25px;
            padding: 3px 5px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .right_nav {
            display: none;
            gap: 70px;
        }

        .toggle_nav {
            padding: 15px 10px;
            border-radius: 5px;
            display: none;
            background: rgb(255, 250, 250);
            position: absolute;
            flex-direction: column;
            right: 3%;
            align-items: center;
            gap: 15px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);
        }


        .toggle_nav .menu,
        .toggle_nav .user,
        .toggle_nav .search_bar {
            display: flex;
            flex-direction: column;
        }

        .toggle_nav .search_bar form {
            width: 200px;
        }

        /*cart css*/

        .cart {
            top: 10%;
            right: 3%;
            position: absolute;
            width: 300px;
            height: 400px;
            background: rgba(255, 255, 255, 0.7);
            /* Semi-transparent white background */
            border-radius: 20px;
            display: none;
        }

        .toggler {
            display: flex;
            align-items: center;
            /* Align items vertically center */
        }

        #profile {
            display: flex;
            align-items: center;
        }

        #toggle_cart,
        #toggle_btn {
            margin-left: 10px;
            height: 25px;
        }
        .search_bar img{
            cursor: pointer;
        }
        .search_bar button{
          border: none;
          outline: none;
          background: none;
        }
    </style>
</head>

<body>
    <?php
    require('../components/fetchdata.php');
    ?>
    <div style="display: flex; margin:0 auto;background: linear-gradient(90deg, #4ca1af, #2c3e50);">
        <nav>
            <div class="logo">
                <a href="../pages/home.php"> Food <span>Land</span></a>
            </div>
            <div class="toggler">
                <div id="profile">
                    <?php
                    if (isset($userName)) {
                        $firstLetter = strtoupper(substr($userName, 0, 1));
                    ?>
                        <a href="../pages/profile.php" style='width: 35px; height: 35px;text-decoration:none; border-radius: 50%; background-color: blue; color: white; display: flex; justify-content: center; align-items: center;'>
                            <?php echo $firstLetter; ?>
                        </a>

                    <?php
                    }
                    ?>
<?php
    if(!isset($userId)){
        echo '<a href="../pages/cart.php"><img src="../assets/cart.png" alt="cart_icon" style="height:25px;" id="toggle_cart"></a>';
    } else {
        echo '<a href="../pages/cart.php"><img src="../assets/cart.png" alt="cart_icon" style="height:25px;" id="toggle_cart"></a>';
        $sql = mysqli_query($conn, "select * from `carts` where userid='$userId'");
        if($row = mysqli_num_rows($sql) > 0) {
             echo "<span style='color:white;font-size:15px;'>$row</span>";
        } else {
            echo "";
        }
    }
?>                   <a onclick="toggleMenu()" id="toggle_btn"><img src="../assets/menu.png" alt="menu" style="height:25px;text-decoration:none"></a>
                </div>
            </div>

            <div class="right_nav">
                <ul class='menu'>
                    <li><a href="../pages/home.php">Home</a></li>
                    <?php
                     if (isset($userId)) {
                    echo '<li><a href="../pages/Orders.php">order</a></li>';
                     }
                     ?>
                    <li><a href="../pages/about_more_page.php">About</a></li>
                    <li><a href="../pages/contact.php">Contact</a></li>
                    <li><a href="../pages/services.php">Our Services</a></li>

                </ul>
                <div class='search_bar'>
                    <form action="" method="POST">
                        <input type="text" class="nav_input" placeholder="search foods">
                        <button  type="submit"><img src="../assets/search.png" alt="" style="height:23px;"></button>
                    </form>
                </div>
                <ul class='user'>

                    <li>
                        <?php
                        if (isset($userId)) {
                            echo '<button class="nav_btn"><a href="../components/user_logout.php" style="color: white;">Logout</a></button>';
                        } else {
                            echo '<button class="nav_btn" style="margin-right: 5px;"><a href="../pages/signup.php"  style="color: white;">Signup</a></button>';
                            echo '<button class="nav_btn" ><a href="../pages/login.php" style="color: white;">Login</a></button>';
                        }
                        ?>

                    </li>

                    <li>
                <?php
    if(!isset($userId)){
        echo '<a href="../pages/cart.php"><img src="../assets/cart.png" alt="cart_icon" style="height:25px;" id="toggle_cart"></a>';
    } else {
        echo '<a href="../pages/cart.php"><img src="../assets/cart.png" alt="cart_icon" style="height:25px;" id="toggle_cart"></a>';
        $sql = mysqli_query($conn, "select * from `carts` where userid='$userId'");
        if($row = mysqli_num_rows($sql) > 0) {
             echo "<span style='color:white;font-size:15px;'>$row</span>";
        } else {
            echo "";
        }
    }
?>  </li>
         <li>
            <?php
              if(isset($userId)){
              echo' <a href="../pages/notification.php"><img src="../assets/notification.png" alt="" style="height:35px"></a>';
              $sql=mysqli_query($conn,"SELECT * from `notifications` Where userId='$userId'");

              if($row=mysqli_num_rows($sql)>0){
             echo "<span style='color:white;font-size:15px;'>$row</span>";
              }
              }else{
                echo "";
              }
          ?>
        </li>
                    <?php if (isset($userName)) : ?>
                        <li id="profile">
                            <a href="../pages/profile.php">
                                <?php
                                $firstLetter = strtoupper(substr($userName, 0, 1));
                                ?>
                                <div style='width: 35px; height: 35px; border-radius: 50%; background-color: blue; color: white; display: flex; justify-content: center; align-items: center;'>
                                    <?php echo $firstLetter; ?>
                                </div>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </div>
    <div class="toggle_nav" id="toggle_nav">
        <div class='search_bar'>
            <form action="" method="POST">
                <input type="text" class="nav_input" placeholder="search foods">
                <img src="../assets/search.png" alt="" style="height:20px;">
            </form>
        </div>
        <ul class='menu'>
            <li><a href="../pages/home.php">Home</a></li>
            <li><a href="../pages/orders.php">Order</a></li>
            <li><a href="./pages/about_more_page.php">About</a></li>
                                <?php
                     if (isset($userId)) {
                    echo '<li><a href="../pages/Orders.php">order</a></li>';
                     }
                     ?>
            <!-- <li><a href="../pages/contact.php">Contact</a></li> -->
            <li><a href="../pages/services.php">Our Services</a></li>
        </ul>
        <ul class='user'>
            <li>
                <?php
                if (isset($userId)) {
                    echo '<button class="nav_btn"><a href="../components/user_logout.php" style="color: white;">Logout</a></button>';
                } else {
                    echo '<button class="nav_btn" style="margin-right: 5px;"><a href="../pages/signup.php"  style="color: white;">Signup</a></button>';
                    echo '<button class="nav_btn"><a href="../pages/login.php" style="color: white;">Login</a></button>';
                }
                ?>
            </li>
        </ul>
    </div>
    <script>
        let isClick = false;

        function toggleMenu() {
            const toggle_nav = document.getElementById('toggle_nav');
            toggle_nav.style.display = isClick ? "none" : "flex";
            isClick = !isClick;
        }

        function responsive() {
            const screenWidth = window.innerWidth;
            const right_nav = document.querySelector(".right_nav");
            const toggle_nav = document.querySelector(".toggle_nav");
            const toggler = document.querySelector('.toggler')

            if (screenWidth > 960) {
                toggler.style.display = "none";
                right_nav.style.display = "flex";
                toggle_nav.style.display = "none";
                isClick = false;
            } else {
                toggler.style.display = "block";
                right_nav.style.display = "none";
                toggle_nav.style.display = isClick ? "flex" : "none";
            }
        }

        window.addEventListener('load', () => {
            responsive();
        });

        window.addEventListener('resize', () => {
            responsive();
        });
    </script>

</body>

<!-- </html> -->