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

$sql = "DROP TABLE doc_table";
$retval = mysqli_query( $conn, $sql );
if(! $retval )
{
  die('Could not delete table: ' . mysql_error());
}
echo "Table deleted successfully\n";



$sql = "DROP TABLE sentence_table";
$retval = mysqli_query( $conn, $sql );
if(! $retval )
{
  die('Could not delete table: ' . mysql_error());
}
echo "Table deleted successfully\n";


$sql = "DROP TABLE task_table";
$retval = mysqli_query( $conn, $sql );
if(! $retval )
{
  die('Could not delete table: ' . mysql_error());
}
echo "Table deleted successfully\n";



// sql to create doc table
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

// sql to create sentence table
$sql = "CREATE TABLE sentence_table (
sentence_id INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
sentence_string VARCHAR(2000),
sentence_latest_string VARCHAR(2000),
doc_id INT(9)
)";

if (mysqli_query($conn, $sql)) {
    echo "Table sentence_table created successfully";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}


// sql to create task table
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