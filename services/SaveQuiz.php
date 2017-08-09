<?php
include ('connect.php');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_NAME)
OR die ('Could not connect to MySQL: '.mysql_error());

$conn1 = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_NAME)
OR die ('Could not connect to MySQL: '.mysql_error());

if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";
$quizname=$_REQUEST["qname"];
$duration=$_REQUEST["qduration"];
$points=$_REQUEST["qpts"];
$selectedQues=$_REQUEST["selectedQues"];
$ques=explode(",",$selectedQues);

echo $_REQUEST["startDate"]." ".$_REQUEST["startTime"].":00";
echo $_REQUEST["endDate"]."  ".$_REQUEST["endTime"];
$sql="INSERT INTO `quiz`(`name`, `duration`, `start_time`, `end_time`, `possible_points`, `status`, `location_id`) VALUES('".$quizname."',".$duration.",'".$_REQUEST["startDate"]." ".$_REQUEST["startTime"].":00"."','".$_REQUEST["endDate"]." ".$_REQUEST["endTime"].":00"."',".$points.",'ENABLED',null)";
if ($conn->query($sql)==TRUE) {
	$quizid=$conn->insert_id;
	$ques_len=count($ques)-1;
	for($x=0;$x<$ques_len;$x++)
	{
		$sql_ques="INSERT INTO `quiz_question`(`quiz_id`, `question_id`, `created_on`) VALUES (".$quizid.",".$ques[$x].",now())";
		$conn1->query($sql_ques);
	}
// 	for($i=0;i<$ques_len;$i++)
// 	{
// 		$sql_ques="INSERT INTO `quiz_question`(`quiz_id`, `question_id`, `created_on`) VALUES (".$quizid.",".$ques[$i].",now())";
// 		if($conn1->query($sql_ques)==TRUE)
// 		{
// 			echo $ques[$i]." mapped to quiz id:".$quizid;
// 		}
// 		else {
// 			echo $ques[$i]." couldnt be mapped to quiz id:".$quizid;
// 		}
// 	}
	echo $quizname." created successfully!! with id:".$quizid.".Please check list page for the quiz details";
}
else {
	echo $quizname." couldn't be created!!";
}
$conn->close();
$conn1->close();
?>