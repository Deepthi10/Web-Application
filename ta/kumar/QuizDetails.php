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
// echo "Connected successfully";
$quiz_id=$_REQUEST["qid"];
$sql="SELECT qques.question_id,details.question FROM quiz q,quiz_question qques,question details WHERE q.quiz_id=qques.quiz_id and qques.question_id=details.question_id and  q.quiz_id='".$quiz_id."'";
$rs=$conn->query($sql);
if ($rs->num_rows > 0) {
	// output data of each row
	$trHTML = "<thead><th style='display:none;'>Q.Id</th><th>Questions</th></thead>";
	$row_num=1;
	while($row = $rs->fetch_assoc()) {
		$trHTML .="<tr id=".$row["question_id"]."><td>".$row_num."</td><td>".$row["question"]."</td></tr>";
		$row_num=$row_num+1;
	}
	echo $trHTML;
} 
$conn->close();
?>