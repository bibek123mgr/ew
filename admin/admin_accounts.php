<?php
include('../connection.php');

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
  header('location:admin_login.php');
}

// if (isset($_GET['delete'])) {
//     $delete_id = $_GET['delete'];
//     $delete_admin_query = "DELETE FROM `admin` WHERE id = ?";
//     $delete_admin_statement = mysqli_prepare($conn, $delete_admin_query);
//     mysqli_stmt_bind_param($delete_admin_statement, "i", $delete_id);
//     if (mysqli_stmt_execute($delete_admin_statement)) {
//         header('location:admin_accounts.php');
//     } else {
//         echo "Error deleting admin: " . mysqli_error($conn);
//     }
//     mysqli_stmt_close($delete_admin_statement);
// }

if (isset($_GET['delete'])) {
  $delete_id = $_GET['delete'];
  $delete_admin_query = "DELETE FROM `admin` WHERE id = $delete_id";
  if (mysqli_query($conn, $delete_admin_query)) {
    header('location:admin_accounts.php');
  } else {
    echo "Error deleting admin: " . mysqli_error($conn);
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>admins accounts</title>

  <!-- font awesome cdn link  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

  <!-- custom css file link  -->
  <!-- <link rel="stylesheet" href="../admin_css/admin_style.css"> -->

</head>

<body>

  <?php include './admin_header.php' ?>

  <!-- admins accounts section starts  -->
  <section class="accounts">

    <h1 class="heading">Admins Account</h1>

    <div class="table-container">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Admin ID</th>
            <th>Username</th>
            <th>Password</th>
            <th class="action">Action</th>
          </tr>
        </thead>
        <tbody>

          <?php
          $select_account_query = "SELECT * FROM `admin`";
          $select_account_result = mysqli_query($conn, $select_account_query);
          if ($select_account_result && mysqli_num_rows($select_account_result) > 0) {
            while ($fetch_accounts = mysqli_fetch_assoc($select_account_result)) {
          ?>
              <tr>
                <td><?= $fetch_accounts['id']; ?></td>
                <td><?= $fetch_accounts['name']; ?></td>
                <td><?= $fetch_accounts['password']; ?></td>
                <td>
                  <div class="flex-btn">
                    <a href="admin_accounts.php?delete=<?= $fetch_accounts['id']; ?>" class="delete" onclick="return confirm('Delete this account?');">Delete</a>
                    <?php
                    if ($fetch_accounts['id'] == $admin_id) {
                      echo '<a href="update_profile.php" class="option">Update</a>';
                    }
                    ?>
                  </div>
                </td>
              </tr>
          <?php
            }
          } else {
            echo '<tr><td colspan="3" class="empty">No accounts available</td></tr>';
          }
          ?>
        </tbody>
      </table>
    </div>

  </section>


  <!-- admins accounts section ends -->


  <style>
    .flex-btn {
      justify-content: center;
    }

    .accounts {
      text-align: center;
      margin-bottom: 50px;
    }

    .heading {
      font-size: 2rem;
      margin-bottom: 20px;
      text-decoration: underline;
    }

    .table-container {
      overflow-x: auto;
    }

    .admin-table {
      width: 100%;
      border-collapse: collapse;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .admin-table th,
    .admin-table td {
      padding: 15px;
      border-bottom: 1px solid #ccc;
    }

    .admin-table th {
      background-color: #f2f2f2;
      font-weight: bold;
    }

    .admin-table tbody tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    .admin-table tbody tr:hover {
      background-color: #f0f0f0;
    }

    .new-admin {
      background-color: #f2f2f2;
    }

    .new-admin p {
      margin: 0;
      font-weight: bold;
    }

    .new-admin a {
      display: inline-block;
      padding: 8px 16px;
      margin-top: 10px;
      background-color: #007bff;
      color: #fff;
      text-decoration: none;
      border-radius: 5px;
      transition: background-color 0.3s ease;
    }

    .new-admin a:hover {
      background-color: #0056b3;
    }

    .delete,
    .option {
      display: inline-block;
      padding: 8px 16px;
      margin-right: 10px;
      background-color: #dc3545;
      color: #fff;
    }
  </style>
  <script src="../js/admin_script.js"></script>