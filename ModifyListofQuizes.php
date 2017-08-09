<?php
include("connect.php");
$conn=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME) OR die ('Could not connect to MySQL: '.mysql_error());

if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	//echo "connected";
	
 $name=$_POST['quizname'];
 $id=$_POST['quizid'];
 $duration=$_POST['duration'];
 $points=$_POST['points'];
 
 $sql="Update quiz set name='".$name."',duration='".$duration."',possible_points='".$points."' where quiz_id ='".$id."'";
  echo $sql;
  $result=mysqli_query($conn,$sql);
	mysqli_close($conn);	
?>
  