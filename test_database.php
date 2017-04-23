<?php require_once 'db_connect.php';?>
<?php


/*
//insert test: inserted two entries successfully
$name = "Rbaten";
$name = mysqli_real_escape_string($conn, $name);
$sql = "INSERT INTO user_profiles (name, email, phone_number, dob, password)
VALUES ('{$name}', 'rbaten@ur.rochester.edu', '5852008886', '11/1/1993', 'q')";

if (mysqli_query($conn, $sql)) {
    $last_id = mysqli_insert_id($conn);
    echo "New record created successfully. Last inserted ID is: " . $last_id;
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
*/


/*
//select test: successful

$sql = "SELECT user_id, name, email, phone_number, dob, password FROM user_profiles";
//$sql = "SELECT video_id, user_id, video_name_datakey FROM video_list";
//$sql = "SELECT comment_id, video_id, commenter_id, commenter_name, comment_text, overall_rating, grammar_rating, articulation_rating, vocabulary_rating, content_rating FROM comment_table";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo "id: " . $row["user_id"]. " <br>Name: " . $row["name"]. " <br>email: " . $row["email"]. " <br>phone: " . $row["phone_number"]. " <br>dob: " . $row["dob"]. " <br>password: " . $row["password"].  "<br><br>";
	   //echo "video_id: " . $row["video_id"]. " <br>user id: " . $row["comment_text"]. " <br>video_name_datakey: " . $row["grammar_rating"]. "<br><br>";
    }
} else {
    echo "0 results";
}
*/

/*
//select doc table: successful

$sql = "SELECT doc_id,doc_name, number_of_sentences FROM doc_table";
//$sql = "SELECT video_id, user_id, video_name_datakey FROM video_list";
//$sql = "SELECT comment_id, video_id, commenter_id, commenter_name, comment_text, overall_rating, grammar_rating, articulation_rating, //vocabulary_rating, content_rating FROM comment_table";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo "doc id: " . $row["doc_id"]. " <br>doc name: " . $row["doc_name"]. " <br>Number of Sentences: " . $row["number_of_sentences"]. "<br><br>";
	   //echo "video_id: " . $row["video_id"]. " <br>user id: " . $row["comment_text"]. " <br>video_name_datakey: " . $row["grammar_rating"]. "<br><br>";
    }
} else {
    echo "0 results";
}
*/

/*
//select sentence table: successful

$sql = "SELECT sentence_id, sentence_string, doc_id FROM sentence_table";
//$sql = "SELECT video_id, user_id, video_name_datakey FROM video_list";
//$sql = "SELECT comment_id, video_id, commenter_id, commenter_name, comment_text, overall_rating, grammar_rating, articulation_rating, //vocabulary_rating, content_rating FROM comment_table";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo "sentence id: " . $row["sentence_id"]. " <br>Sentence string: " . $row["sentence_string"]." <br>doc id: " . $row["doc_id"]. "<br><br>";
	   //echo "video_id: " . $row["video_id"]. " <br>user id: " . $row["comment_text"]. " <br>video_name_datakey: " . $row["grammar_rating"]. "<br><br>";
    }
} else {
    echo "0 results";
}
*/


//select task table: successful

$sql = "SELECT task_id, sentence_id, current_string, current_state, resolved_flag, resolving_user_id, iteration_number FROM task_table";
//$sql = "SELECT video_id, user_id, video_name_datakey FROM video_list";
//$sql = "SELECT comment_id, video_id, commenter_id, commenter_name, comment_text, overall_rating, grammar_rating, articulation_rating, //vocabulary_rating, content_rating FROM comment_table";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo "task id: " . $row["task_id"]. " <br>sentence id: " . $row["sentence_id"]." <br>current string: " . $row["current_string"]." <br>current state: " . $row["current_state"]." <br>resolved flag: " . $row["resolved_flag"]." <br>resolving user id: " . $row["resolving_user_id"]." <br>iteration_number: " . $row["iteration_number"]. "<br><br>";
	   
    }
} else {
    echo "0 results";
}






/*

$sql = "DROP TABLE sentence_table";
$retval = mysqli_query( $conn, $sql );
if(! $retval )
{
  die('Could not delete table: ' . mysql_error());
}
echo "Table deleted successfully\n";

*/

/*
// sql to delete a record
$sql = "DELETE FROM doc_table WHERE doc_id=2 LIMIT 1";

if (mysqli_query($conn, $sql) && mysqli_affected_rows($conn) == 1) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}*/




/*
// sql to delete a record
$sql = "DELETE FROM doc_table WHERE doc_id=2 LIMIT 1";

if (mysqli_query($conn, $sql) && mysqli_affected_rows($conn) == 1) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}*/




if (isset($conn)){
  mysqli_close($conn);
}
?>