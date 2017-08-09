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
echo "entered ";
$quizid=$_REQUEST["qid"];
$total_ques_query="select question_id,question from question where question_id IN(select question_id from quiz_question where quiz_id=".quizid.");";
//$result_quesdata = mysqli_query($conn, $total_ques_query);
			echo "start";
			$sql_quizdata="select student_quiz_id,score from student_quiz where quiz_id ='".$quizid."';";

			$result_quizdata = mysqli_query($conn, $sql_quizdata);
			
			 while($row = mysqli_fetch_assoc($result_quizdata)) {
					if($row['score']==null)
					{
						$row['score']=0;
					}
					$array[]=array_map('utf8_encode',$row);
					
				}
				$json=json_encode($array);
				echo $json;
			 /*while($row = mysqli_fetch_assoc($result_quesdata)) {
				 echo "entered loop";
					/*$total_ans="SELECT count(*) FROM `student_answers` WHERE question_id=".$row['question_id'].";";
					$result_tansdata = mysqli_query($conn, $total_ans);
					while($row1 = mysqli_fetch_assoc($result_tansdata)) {
						$total=$row1['count(*)'];
					}
					$correct_ans="select count(*) from `student_answers` where question_id=".$row['question_id']." and answer_option_id =(select option_id from question_option where question_id=".$row['question_id']." and correct_flag=1  );";
					$result_coransdata = mysqli_query($conn, $correct_ans);
					while($row2 = mysqli_fetch_assoc($result_coransdata)) {
						$correct=$row2['count(*)'];
					}
					echo $total;
					echo $correct;*/
					//$array[]=array_map('utf8_encode',$row);
					
				}*/



mysqli_close($conn);
?>