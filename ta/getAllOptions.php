<?php
include("connect.php");
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_NAME)
	OR die ('Could not connect to MySQL: '.mysql_error());
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
		//$sql="SELECT option_id from question_option where question_id =36";
		$sql="SELECT option,option_id from question_option where question_id =".$_REQUEST['qtnID']."";
    	//echo $sql;
    	$result = mysqli_query($conn, $sql);
		$arr = "";
		while ($row = mysqli_fetch_assoc($result)) {
				$arr.= $row['option']."-".$row['option_id']."|";				
		}
		echo $arr;
	mysqli_close($conn);
?>