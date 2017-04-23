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
$sql = "CREATE TABLE task_table (
task_id INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
sentence_id INT(9),
current_string VARCHAR(2000),
current_state INT(9),
resolved_flag INT(9),
resolving_user_id INT(9),
iteration_number INT(9)
)";

if (mysqli_query($conn, $sql)) {
    echo "Table task_table created successfully";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

mysqli_close($conn);
?>