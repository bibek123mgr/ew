<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "fooddb";

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$sql=mysqli_query($conn,"SELECT * FROM admins");
if(mysqli_num_rows($sql)== 0){
    $name='admin';
    $hashPassword=password_hash('root',PASSWORD_DEFAULT);
    $adminSeed=mysqli_query($conn,"INSERT INTO `admins` (name,password) VALUES ('$name','$hashPassword')");
}
?>
