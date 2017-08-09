<?php
include ('connect.php');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_NAME)
OR die ('Could not connect to MySQL: '.mysql_error());

if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";

$qid=$_REQUEST["quizSelect"];


echo $_REQUEST["startDate"]." ".$_REQUEST["startTime"].":00";
echo $_REQUEST["endDate"]."  ".$_REQUEST["endTime"];
$sql="UPDATE `quiz` SET `start_time` = '".$_REQUEST["startDate"]." ".$_REQUEST["startTime"].":00"."', `end_time` = '".$_REQUEST["endDate"]." ".$_REQUEST["endTime"].":00"."', `status` = 'ENABLED' WHERE `quiz_id` = $qid";

//echo $sql;
if ($conn->query($sql)==TRUE) {
	echo $quizname." updated successfully!! with id:".$quizid.".Please check list page for the quiz details";
}
else {
	echo $quizname." couldn't be updated!!";
}
$conn->close();
?>