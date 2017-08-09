<?php
session_start();
include ('services/connect.php');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_NAME)or die('Error connecting to mysql');
// mysql_select_db($dbname);
//echo $conn;

if(!$conn){

	//echo "hi";
}

$sem=$_REQUEST["sem"];
$year=$_REQUEST["year"];
$sql="select name from semester where name='".$sem."' and year='".$year."'";
//echo $sql;
$rs=mysql_query($sql);
if(mysql_num_rows($rs)==0){
	
	$row_array[]="0";
	
}

while($row = mysql_fetch_array($rs, MYSQL_ASSOC)){
	$row_array[]=$row["name"];
	
}

array_push($row_array);
header('Content-Type: application/json');
echo json_encode($row_array);


?>