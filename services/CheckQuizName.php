<?php
include ('connect.php');
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_NAME)
OR die ('Could not connect to MySQL: '.mysql_error());

if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";
$quiz_name=$_REQUEST["qname"];
$sql="SELECT count(*) as count from quiz where name='".$quiz_name."'";
$rs=$conn->query($sql);
if ($rs->num_rows > 0) {
	 $cnt=0;
	while($row = $rs->fetch_assoc()) {
		$cnt=$row["count"];
	}
	if($cnt==0)
	echo "true";
	else 
		echo "false";
}
$conn->close();
?>