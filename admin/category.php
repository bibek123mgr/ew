<?php
session_start();
include("../connection.php");
$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
  header('location:admin_login.php');
}
if (isset($_POST['submit'])) {
$name = strtolower($_POST['name']);
   $errors = [];

   if (empty($name)) {
      $errors[] = "Please enter the category name";
   } else {
      $query = mysqli_query($conn, "SELECT * FROM `categories` WHERE name ='$name'");
      if (mysqli_num_rows($query) > 0) {
         $errors[] = "Category already exists";
      } else {
         $insert_query = mysqli_query($conn, "INSERT INTO categories (name) VALUES ('$name')");
         if ($insert_query) {
            echo "<script>alert('Successfully added new category');window.location='./category.php'</script>";
            exit;
         } else {
            $errors[] = "Failed to add category";
         }
      }
   }
}


if (isset($_POST['delete'])) {
    // Check if the category_id is set and not empty
    if (isset($_POST['category_id']) && !empty($_POST['category_id'])) {
        // Sanitize the category_id to prevent SQL injection
        $categoryId = mysqli_real_escape_string($conn, $_POST['category_id']);

        // Perform the delete operation
        $deleteQuery = mysqli_query($conn, "DELETE FROM `categories` WHERE id = '$categoryId'");
        if ($deleteQuery) {
            // Category deleted successfully
            echo "<script>alert('Category deleted successfully'); window.location='./category.php';</script>";
            exit;
        } else {
            // Failed to delete category
            echo "<script>alert('Failed to delete category');</script>";
        }
    } else {
        // Category ID is not set or empty
        echo "<script>alert('Category ID is missing');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 50px auto;
            display: flex;
            justify-content: center;
        }

        .category-list {
            width: 30%;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .category-list h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .category-item {
            margin-bottom: 10px;
        }

        .category-item a {
            display: block;
            padding: 10px 0;
            color: #333;
            transition: color 0.3s ease;
        }

        .category-item a:hover {
            color: #007bff;
        }

        .add-category-form {
            width: 70%;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .add-category-form h1 {
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }

        .form-group input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
        }

        .form-group input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-group input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <?php include("./admin_header.php");?>
    <div class="container">
        <!-- Category List Section -->
    <!-- Category List Section -->
    <div class="category-list">
        <h2>Categories</h2>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM `categories`");
        if (mysqli_num_rows($result) > 0) {
            echo "<table>";
            echo "<thead><tr><th>Category Name</th><th>Action</th></tr></thead>";
            echo "<tbody>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>";
                echo "<form method='POST'>";
                echo "<input type='hidden' name='category_id' value='". $row['id'] ."'>";
                echo "<button type='submit' name='delete' style='background:red;border:none;padding:5px;color:white;cursor:pointer'>Delete</button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p>No categories found.</p>";
        }
        ?>
    </div>

        <!-- Add Category Form -->
        <div class="add-category-form">
            <h1>Add Category</h1>
            <?php if (!empty($errors)): ?>
            <ul>
                <?php foreach ($errors as $err): ?>
                <li style="list-style:none;color:red"><?php echo $err; ?></li>
                <!-- Display error messages dynamically -->
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
            <form action="" method="post">
                <div class="form-group">
                    <label for="name">Category Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <input type="submit" value="Add Category" name="submit">
                </div>
            </form>
        </div>
    </div>
</body>
</html>
