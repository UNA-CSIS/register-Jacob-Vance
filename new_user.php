<?php

session_start();

include_once 'validate.php';
$newUser = test_input($_POST['user']);
$newUserPassword = test_input($_POST['pwd']);
$repeatUserPassword = test_input($_POST['repeat']);

if ($newUserPassword == $repeatUserPassword) {
    $hashedPassword = password_hash($newUserPassword, PASSWORD_DEFAULT);
} else {
    header("location:register.php");
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "softball";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$check = "SELECT * FROM users WHERE username = '$newUser'";
$rs = mysqli_query($conn, $check);
$data = mysqli_fetch_array($rs, MYSQLI_NUM);
if ($data[0] > 1) {
    echo "User Already in Exists<br/>";
} else {
    $sql = "INSERT INTO users (username, password) VALUES ('$newUser', '$hashedPassword')";
    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
header("location:index.php");
?>
