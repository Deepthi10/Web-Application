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
$quesid=$_REQUEST["qid"];
$sql="SELECT option_id,option,correct_flag FROM `question_option` WHERE question_id='".$quesid."'";
$rs=$conn->query($sql);
$count=1;
$opts="";
if ($rs->num_rows > 0) {
	while($row = $rs->fetch_assoc()) {
		if($row["correct_flag"]==1)
		{
			$opts=$opts."<b>".$count.".".$row["option"]."</b><br>";
		}
		else{
			$opts=$opts."".$count.".".$row["option"]."<br>";
		}
		$count=$count+1;
	}
}
$conn->close();
echo $opts;
?>