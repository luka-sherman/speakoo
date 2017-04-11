<?php
$servername = "localhost";
$username = "root";
$password = "test";
$dbname = "speakoo_crowd_grammar";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// sql to create table
$sql = "CREATE TABLE sentence_table (
sentence_id INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
sentence_string VARCHAR(2000),
doc_id INT(9)
)";

if (mysqli_query($conn, $sql)) {
    echo "Table sentence_table created successfully";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

mysqli_close($conn);
?>