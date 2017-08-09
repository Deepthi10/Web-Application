<?php
include ('connect.php');


$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_NAME)
OR die ('Could not connect to MySQL: '.mysql_error());

if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";
$quesid=$_REQUEST["qid"];
$sql="SELECT t.name FROM `question_tag` q,tag t where q.tag_id=t.tag_id and q.question_id=".$quesid."";
$rs=$conn->query($sql);
$count=1;
$tags=array();
if ($rs->num_rows > 0) {
	while($row = $rs->fetch_assoc()) {
		$tags["tags"][]=$row;
	}
}
$conn->close();
echo json_encode($tags);
?>