<?php

define ('DB_USER', 'user');
define ('DB_PASSWORD', 'handson1234');
define ('DB_HOST', 'handson-mysql');
define ('DB_NAME', 'quiz');
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_NAME)
OR die ('Could not connect to MySQL: '.mysql_error());

if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$wrong;
$i=0;
$array1[][4];
$array="(";
$json="<table class='table table-striped' id=\"ques\" style=\"width:100%\"  border spacing=5>
  <tr>
  <th>Question Id</th>
    <th>Question</th>
    <th>Wrong Percentage</th> 
    <th>Difficulty Level</th>
  </tr>";
$quizid=$_REQUEST["qid"];
//echo $quizid;
$ques_query="select A.quizid,A.quesid,question.question,question.diff_level from (select quiz.quiz_id as quizid,question_id as quesid from quiz JOIN quiz_question on quiz.quiz_id=quiz_question.quiz_id where quiz.quiz_id=".$quizid.") A join question on A.quesid=question.question_id";
//echo $ques_query;
$result_quesdata = mysqli_query($conn, $ques_query);
while($row = mysqli_fetch_assoc($result_quesdata)){
	//echo $row['quizid']."--".$row['quesid']."--".$row['question']."--".$row['diff_level'];
	$quesid1=$row['quesid'];
	$percent_query="SELECT (A.wrong/A.total)*100 as percent from(select(SELECT count(*) FROM `student_answers` WHERE question_id=".$quesid1.") as total,(select count(*) from `student_answers` where question_id=".$quesid1." and answer_option_id IN(select option_id from question_option where question_id=".$quesid1." and correct_flag=0  )) as wrong)A";
	//echo $percent_query."<br>";
	$result_percent = mysqli_query($conn, $percent_query);
	while($row1 = mysqli_fetch_assoc($result_percent)){
		$wrong=$row1["percent"];
		//echo $wrong;
		$wrong=intval($wrong);
		$json=$json."<tr><td>".$row['quesid']."</td><td>".$row['question']."</td><td>".$wrong."%</td><td>".$row['diff_level']."</td></tr>";
		$array=$array."array('".$row['question']."',".$wrong.",".$row['diff_level']."),";
		$array1[i]["quesid"]=$row['quesid'];
		$array1[i]["question"]=$row['question'];
		$array1[i]["percent"]=$wrong;
		$array1[i]["diff_level"]=$row['diff_level'];
		$i++;
	}
	}
	$array=trim($array,",");
$array=$array.");";
//echo $array."<br><br>";
echo $array1;

//usort($yourArray,"cmp");
				//$json=json_encode($array);
				$json=$json."</table>";
				echo $json;
mysqli_close($conn);
?>