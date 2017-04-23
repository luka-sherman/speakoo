<?php
$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "speakoo_crowd_grammar";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// sql to create table
$sql = "CREATE TABLE user_profiles (
user_id INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
name VARCHAR(100) NOT NULL,
email VARCHAR(100),
phone_number VARCHAR(100),
dob VARCHAR(50),
password VARCHAR(100)
)";

if (mysqli_query($conn, $sql)) {
    echo "Table user_profiles created successfully";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

mysqli_close($conn);
?>