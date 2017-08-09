<?php

include ('connect.php');
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_NAME)
OR die ('Could not connect to MySQL: '.mysql_error());

if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
function sortByPercent($a, $b) {
    return  $b['percentage']-$a['percentage'] ;
}
$wrong;
$i=0;
$array1[100][4];

$json="<h2>Quiz Result Analysis</h2><br><table class='table table-striped' id=\"ques\" style=\"width:100%\"  border spacing=5>
  <tr>
  <th>Question Id</th>
    <th>Question</th>
    <th>Wrong Percentage</th> 
    <th>Difficulty Level</th>
  </tr>";
$quizid=$_REQUEST["qid"];

$ques_query="select A.quizid,A.quesid,question.question,question.diff_level from (select quiz.quiz_id as quizid,question_id as quesid from quiz JOIN quiz_question on quiz.quiz_id=quiz_question.quiz_id where quiz.quiz_id=".$quizid.") A join question on A.quesid=question.question_id";

$result_quesdata = mysqli_query($conn, $ques_query);
while($row = mysqli_fetch_assoc($result_quesdata)){
	
	$quesid1=$row['quesid'];
	//$percent_query="SELECT (A.wrong/A.total)*100 as percent from(select(SELECT count(*) FROM `student_answers` WHERE question_id=".$quesid1.") as total,(select count(*) from `student_answers` where question_id=".$quesid1." and answer_option_id IN(select option_id from question_option where question_id=".$quesid1." and correct_flag=0  )) as wrong)A";
	$percent_query="SELECT (A.wrong/A.total)*100 as percent from (select (SELECT count(*) FROM user join student_quiz on student_quiz.user_id=user.user_id join student_answers on student_quiz.student_quiz_id=student_answers.student_quiz_id where student_quiz.quiz_id=".$quizid." and student_answers.question_id=".$quesid1.") as total, 
	(SELECT count(*) FROM user join student_quiz on student_quiz.user_id=user.user_id join student_answers on student_quiz.student_quiz_id=student_answers.student_quiz_id where student_quiz.quiz_id=".$quizid." and student_answers.question_id=".$quesid1." and student_answers.answer_option_id IN(select option_id from question_option where question_id=".$quesid1." and correct_flag=0 )) as wrong )A";
	//echo $percent_query."<br>";
	$result_percent = mysqli_query($conn, $percent_query);
	while($row1 = mysqli_fetch_assoc($result_percent)){
		$wrong=$row1["percent"];
		
		$wrong=intval($wrong);
		
		
		
		$array1[]=array("quesid"=>$row['quesid'],"question"=>$row['question'],"percentage"=>$wrong,"diff_level"=>$row['diff_level']);
		
		$i=$i+1;
		
	}
	}
	
usort($array1,'sortByPercent');


				for ($i=0;$i<count($array1);$i++)
					$json=$json."<tr><td>".$array1[$i]['quesid']."</td><td>".$array1[$i]['question']."</td><td>".$array1[$i]['percentage']."%</td><td>".$array1[$i]['diff_level']."</td></tr>";
				$json=$json."</table>";
				echo $json;
mysqli_close($conn);
?>