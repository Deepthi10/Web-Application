<?php
include("connect.php");
$conn=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME) OR die ('Could not connect to MySQL: '.mysql_error());

if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	//echo "connected";
	
 $qname=$_POST['qname'];
 $id=$_POST['qtnid'];
 $optid1=$_POST['optid1'];
 $optid2=$_POST['optid2'];
 $optid3=$_POST['optid3'];
 $optid4=$_POST['optid4'];
 $opt1=$_POST['one'];
 $opt2=$_POST['two'];
 $opt3=$_POST['three'];
 $opt4=$_POST['four'];
 
   $sql="Update question set question='".$qname."',edited_by='',edit_date='NOW()' where question_id ='".$id."'";
   echo $sql;
   $result=mysqli_query($conn,$sql);

	$sql2="Update question_option set option='".$opt1."',created_on='NOW()' where option_id='".$optid1."'";
	echo $sql2;
	$result=mysqli_query($conn,$sql2);
	
	$sql3="Update question_option set option='".$opt2."',created_on='NOW()' where option_id='".$optid2."'";
	echo $sql3;
	$result=mysqli_query($conn,$sql3);
	
	$sql4="Update question_option set option='".$opt3."',created_on='NOW()' where option_id='".$optid3."'";
	echo $sql4;
	$result=mysqli_query($conn,$sql4);
	
	$sql5="Update question_option set option='".$opt4."',created_on='NOW()' where option_id='".$optid4."'";
	echo $sql5;
	$result=mysqli_query($conn,$sql5);

    $sql6 = "INSERT INTO question_option (id,question_id,option) VALUES ('".$id."','".$opt1."'),('".$id."','".$opt2."'),('".$id."','".$opt3."'),('".$id."','".$opt4."')";
    echo $sql6;
    $result2=mysqli_query($sql6); 

	mysqli_close($conn);	
?>
  
