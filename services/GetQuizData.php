<?php
include ('connect.php');
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_NAME)
OR die ('Could not connect to MySQL: '.mysql_error());

if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$quizid=$_REQUEST["qid"];

$sql_quizdata="select user.first_name,user.user_id,student_quiz.score from student_quiz join user on user.user_id=student_quiz.user_id where quiz_id  ='".$quizid."';";

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
mysqli_close($conn);
?>