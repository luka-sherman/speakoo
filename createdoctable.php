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
$sql = "CREATE TABLE doc_table (
doc_id INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
doc_name VARCHAR(2000),
number_of_sentences INT(9)
)";

if (mysqli_query($conn, $sql)) {
    echo "Table doc_table created successfully";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

mysqli_close($conn);
?>