<?php
session_start ();
$dbHost = "handson-mysql"; // MySQL Server
$dbUser = "bkongara"; // MySQL Username
$dbPass = "Mamatha5!"; // MySQL Passwordf
$dbname = "apns"; // MySQL Database Name
$DB_TBLName = "ModuleFinalScore"; // MySQL Table Name

$Conn  = mysql_connect($dbHost,$dbUser,$dbPass) or die('Error connecting to mysql');
if ($Conn) {
	echo "connected";
}
mysql_select_db($dbname) or die ( 'Error connecting to db' );

$userid = $_POST["user_id"];
$mid = $_POST["moduleid"];

$sql="Select Finalscore from ModuleFinalScore where UserID = $userid and Module_Id = $mid";

 $result = mysql_query($sql);
while($row = mysql_fetch_assoc($result)){
	$total = $row['Finalscore'];	
}
echo $total;
mysql_close();
?>