<?php
include ('connect.php');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_NAME)
OR die ('Could not connect to MySQL: '.mysql_error());

if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$crnid=$_REQUEST["crnSelect"];
$qid=$_REQUEST["quizSelect"];
$secid=$_REQUEST["secSelect"];
$sql="INSERT INTO `crn_quiz`(`crn_id`, `quiz_id`, `user_id`, `time`, `status`, `location_id`, `duration`, `start_time`, `end_time`) VALUES (".$crnid.",".$qid.",null,now(),'ENABLED',0,0,now(),now())";
if ($conn->query($sql)==TRUE) {
	echo $quizname." created successfully!! with id:".$qid.".Please check list page for the quiz details<br>";
}
else
{
	echo "Quiz is already assigned to CRN!!";
}
$secSql="INSERT INTO `quiz_section` (`quiz_section_id`, `quiz_id`, `section_id`, `created_on`) VALUES (NULL, '".$qid."', '".$secid."', CURRENT_TIMESTAMP)";
if ($conn->query($secSql)==TRUE) {
	echo $qid." assigned to section ".$secid;
}
else
{
	echo "Quiz is already assigned to Section!!";
}
$conn->close();
?>