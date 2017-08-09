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

$json="<html><head><link rel=\"stylesheet\"
	href=\"http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css\">
	</head><body>
<h2>Quiz Result Analysis</h2><br><table class='table table-striped' id=\"ques\" style=\"width:100%\"  border spacing=5>
  <tr>
  <th>Question Id</th>
    <th>Question</th>
    <th>Wrong Percentage</th> 
    <th>Difficulty Level</th>
  </tr>";
$quizid=$_REQUEST["qid"];

$ques_query="select question_id,question,diff_level from question" ;

$result_quesdata = mysqli_query($conn, $ques_query);
while($row = mysqli_fetch_assoc($result_quesdata)){
	
	$quesid1=$row['question_id'];
	$percent_query="SELECT (A.wrong/A.total)*100 as percent from(select(SELECT count(*) FROM `student_answers` WHERE question_id=".$quesid1.") as total,(select count(*) from `student_answers` where question_id=".$quesid1." and answer_option_id IN(select option_id from question_option where question_id=".$quesid1." and correct_flag=0  )) as wrong)A";
	
	$result_percent = mysqli_query($conn, $percent_query);
	while($row1 = mysqli_fetch_assoc($result_percent)){
		$wrong=$row1["percent"];
		
		$wrong=intval($wrong);
		
		
		
		$array1[]=array("question_id"=>$row['question_id'],"question"=>$row['question'],"percentage"=>$wrong,"diff_level"=>$row['diff_level']);
		
		$i=$i+1;
		
	}
	}
	
usort($array1,'sortByPercent');


				for ($i=0;$i<count($array1);$i++)
					$json=$json."<tr><td>".$array1[$i]['question_id']."</td><td>".$array1[$i]['question']."</td><td>".$array1[$i]['percentage']."%</td><td>".$array1[$i]['diff_level']."</td></tr>";
				$json=$json."</body></table></html>";
				echo $json;
mysqli_close($conn);
?>