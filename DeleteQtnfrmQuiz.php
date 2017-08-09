<?php
include("connect.php");
$conn=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME) OR die ('Could not connect to MySQL: '.mysql_error());

if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	echo "connected";
	
 $id=$_POST['quizQtnid'];
 
 //echo $qname;

 $sql="Delete from quiz_question where question_id ='".$id."'";
  echo $sql;
  $result=mysqli_query($conn,$sql);
 
	mysqli_close($conn);	
?>
  