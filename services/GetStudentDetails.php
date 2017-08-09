<?php
include ('connect.php');
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_NAME)
OR die ('Could not connect to MySQL: '.mysql_error());

if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
// "start";
//$array;
$userid=$_REQUEST["uid"];
//echo $userid;
$quiz_query="SELECT user.user_id,user.first_name,user.last_name,student_quiz.quiz_id,student_quiz.score,quiz.name,quiz.start_time FROM `student_quiz` join user on user.user_id=student_quiz.user_id join quiz on student_quiz.quiz_id=quiz.quiz_id where user.user_id=".$userid." order by quiz.start_time";
//echo $quiz_query;
$result = mysqli_query($conn,$quiz_query);


    while($row = mysqli_fetch_assoc($result)) {
      // $array=$array. $row['user_id']."--".$row['quiz_id']."--".$row['score']."--".$row['name']."--".$row['start_time'];
    if($row['score']==null)
					{
						$row['score']=0;
					}
       $array[]=array_map('utf8_encode',$row);
    }
echo json_encode($array);
?>