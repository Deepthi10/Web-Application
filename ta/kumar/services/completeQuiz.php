<?php
include ('connect.php');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_NAME)
OR die ('Could not connect to MySQL: '.mysql_error());

if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";

$qid=$_REQUEST["quizSelect1"];



$sql="UPDATE `quiz` SET  `status` = 'COMPLETED' WHERE `quiz_id` = $qid";

echo $sql;
if ($conn->query($sql)==TRUE) {
	echo "Quiz completed!!!!";
}
else {
	echo $quizname." couldn't be completed!!";
}
$conn->close();
?>