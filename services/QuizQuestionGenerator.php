<?php
include ('connect.php');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_NAME)
OR die ('Could not connect to MySQL: '.mysql_error());

if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";
$numofques=$_REQUEST["pts"];
$filter=$_REQUEST["condt"];
//$sql="SELECT question_id,question from question order by rand() limit ".$numofques."";
$sql="SELECT distinct question,question_id,diff_level from question";
$sql_complex="SELECT question_id,question,diff_level from question where question_id in (SELECT DISTINCT q.question_id 
		FROM question_tag q,tag t where q.tag_id=t.tag_id and t.name in (".$filter."))";
if(empty($filter) || $filter=="''")
{
	$rs=$conn->query($sql);
}
else {
	$rs=$conn->query($sql_complex);
}
$count=0;
$ques=array();
if ($rs->num_rows > 0) {
	while($row = $rs->fetch_assoc()) {
		$count=$count+1;
	$ques['questions'][]= array_map('utf8_encode',$row);
	}
}
echo json_encode($ques);
$conn->close();
?>