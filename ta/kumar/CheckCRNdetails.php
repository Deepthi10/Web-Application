<?php
session_start();
$dbhost = 'handson-mysql';
$dbuser = 'bkongara';
$dbpass = 'Mamatha5!';
$dbname = 'quiz';

$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die('Error connecting to mysql');
mysql_select_db($dbname);
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