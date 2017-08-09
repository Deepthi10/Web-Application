<?php
include("connect.php");
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_NAME)
	OR die ('Could not connect to MySQL: '.mysql_error());
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
		$sql="SELECT quiz_id, name from quiz where name like '%".$_REQUEST['strVal']."%'";
    	//echo $sql;
    	$result = mysqli_query($conn, $sql);
		$arr = "";
		while ($row = mysqli_fetch_assoc($result)) {
				$arr.= $row['name']."-".$row['quiz_id']."|";					
		}	
		echo $arr; //Return the JSON Array */
	
	mysqli_close($conn);
	//echo json_encode("hello");
?>