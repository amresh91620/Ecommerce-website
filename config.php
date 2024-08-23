<?php

// New MySQL database credentials
$db_name = "shop_db";  // MySQL DB Name
$username = "root";         // MySQL User Name
$password = "";            // MySQL Password
$host = "localhost";  // MySQL Host Name

// Creating a new PDO connection
$conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
// Set PDO to throw exceptions on error
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>

