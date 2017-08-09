<?php
$dbhost = 'handson-mysql';
$dbuser = 'bkongara';
$dbpass = 'Mamatha5!';
$dbname = 'quiz';
$conn = mysql_connect ( $dbhost, $dbuser, $dbpass ) or die ( 'Error connecting to mysql' );
mysql_select_db ( $dbname );
/* define ('DB_USER', 'user');
 define ('DB_PASSWORD', 'handson1234');
define ('DB_HOST', 'handson-mysql');
define ('DB_NAME', 'quiz');
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_NAME)
OR die ('Could not connect to MySQL: '.mysql_error());

if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
} */

$getQuiznames = $_REQUEST["type"];
 //echo $getQuiznames;
/* if($getQuizNames=='getQuizNames'){ */
	
	$returnArray=Array();
	$row_name=array();
 $sql="select distinct name,quiz_id from quiz order by name";
 //echo $sql;
 $rs=mysql_query($sql);
// echo mysql_num_rows($rs);
 

	
	while($row = mysql_fetch_array($rs))
	{
	$row_name["name"]=$row["name"];	
	array_push($returnArray, $row_name);
	}
	
	header('Content-Type: application/json');
	echo json_encode($returnArray);

/* } */
//$conn->close();
?>