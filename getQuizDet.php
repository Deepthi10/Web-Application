<?php
include("connect.php");
$conn=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME) OR die ('Could not connect to MySQL: '.mysql_error());

if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	//echo "connected";
  $sql="Select name,duration,possible_points from quiz where quiz_id =".$_REQUEST['quizID']."";
  //echo $sql;
  $result=mysqli_query($conn,$sql);
  $arr = "";
		while ($row = mysqli_fetch_assoc($result)) {
				$arr.= $row['duration']."|".$row['possible_points']."|";				
		}
		echo $arr;
	mysqli_close($conn);	
?>