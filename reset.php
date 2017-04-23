<?php 

require_once 'db_connect.php';



// sql to create table
$sql = "CREATE TABLE IF NOT EXISTS user_profiles (

user_id INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
name VARCHAR(100) NOT NULL,
email VARCHAR(100),
phone_number VARCHAR(100),
dob VARCHAR(50),
password VARCHAR(100),
score INT(255),
level INT(3)
)";

if (mysqli_query($conn, $sql)) {
    echo "Table user_profiles created successfully";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}




$sql = "DROP TABLE IF EXISTS doc_table";
$retval = mysqli_query( $conn, $sql );
if(! $retval )
{
  die('Could not delete table: ' . mysql_error());
}
echo "Table deleted successfully\n";

$sql = "DROP TABLE IF EXISTS sentence_table";
$retval = mysqli_query( $conn, $sql );
if(! $retval )
{
  die('Could not delete table: ' . mysql_error());
}
echo "Table deleted successfully\n";

$sql = "DROP TABLE IF EXISTS task_table";
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





$filename="transcript1"; //later on, make sure same document doesn't get populated twice
$mypath = "data/$filename.txt";
if( file_exists($mypath) ) {
  $transcriptFile = fopen($mypath,"r") or die("Unable to open file!");
  $text = fread($transcriptFile,filesize($mypath));
  fclose($transcriptFile);
  //echo $text;
  $splitted_text = explode(".", $text);
  $count=count($splitted_text)-1;
  //echo $count;
  $doc_name = mysqli_real_escape_string($conn, $filename);
  $sql = "INSERT INTO doc_table (doc_name, number_of_sentences)
  VALUES ('{$doc_name}',{$count})";

  if (mysqli_query($conn, $sql)) {
    $last_doc_id = mysqli_insert_id($conn);
    echo "New doc created successfully. Last inserted ID is: " . $last_doc_id;
    
    // if the doc_table entry is successful, we populate the sentence_table
    for($i = 0; $i < count($splitted_text)-1; $i++){ //later on, add an if condition to make sure there is a fullstop at the end
      file_put_contents("sentence_$i", $splitted_text[$i]);

      //to display a file just use echo file_get_contents($file_name) as such :
      //echo "file $i :<br/>";
      $single_sentence = trim(file_get_contents("sentence_$i"));
      //echo $single_sentence;  //note that you could echo $splitted_text[$i]
      $single_sentence = mysqli_real_escape_string($conn, $single_sentence);
      $sql = "INSERT INTO sentence_table (sentence_string, sentence_latest_string, doc_id)
      VALUES ('{$single_sentence}','{$single_sentence}',{$last_doc_id})";
      if (mysqli_query($conn, $sql)) {
        $last_sentence_id = mysqli_insert_id($conn);
        echo "New sentence created successfully. Last inserted ID is: " . $last_sentence_id;
        
        //if the sentence table entry is successful, insert the sentence to the task table as well
        $sql = "INSERT INTO task_table (sentence_id, current_string, current_state, resolved_flag, resolving_user_id, iteration_number)
        VALUES ({$last_sentence_id}, '{$single_sentence}', 0, 0, 0, 1)";
        if (mysqli_query($conn, $sql)) {
          $last_task_id = mysqli_insert_id($conn);
          echo "New record created successfully. Last inserted ID is: " . $last_task_id;
        } else {
          echo "Error with task insertion: " . $sql . "<br>" . mysqli_error($conn);
        }
      
      } else {
        echo "Error with creating new sentence: " . $sql . "<br>" . mysqli_error($conn);
      }
      //echo $splitted_text[$i];
      //echo "<br/>";
      //$single_sentence = mysqli_real_escape_string($conn, $single_sentence);
      //$sql = "INSERT INTO user_profiles (name, email, phone_number, dob, password)
      //VALUES ('{$name}', 'rbaten@ur.rochester.edu', '5852008886', '11/1/1993', 'q')";
    }    
  } else {
    echo "Error with creating new doc entry: " . $sql . "<br>" . mysqli_error($conn);
  }
}



if (isset($conn)){
  mysqli_close($conn);
}
?>