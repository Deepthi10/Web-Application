<?php
define ('DB_USER', 'user');
define ('DB_PASSWORD', 'handson1234');
define ('DB_HOST', 'handson-mysql');
define ('DB_NAME', 'quiz');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_NAME)
OR die ('Could not connect to MySQL: '.mysql_error());

if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
 //echo "Connected successfully";
$year=$_REQUEST["yr"];
$sem=$_REQUEST["sem"];
$sql="select crn from crn where year=".$year." and semester='".$sem."'";
//echo $sql;
$rs_crn=mysqli_query($conn,$sql) or die(mysql_error());

	//echo "<br>".$year."--".$sem;
    //echo "entered if";
    var_dump($rs_crn);
    $crnopts="";
    while($row = mysqli_fetch_assoc($rs_crn)) {
    	//echo "entered while";
        $crnopts=$crnopts."<option value='".$row["crn"]."'>".$row["crn"]."</option>";
    }
$secopts="";
	$sql_sec = "select section_id,name from section where course_crn_id IN(select course_crn_id from course_crn WHERE crn IN(select crn from crn where year=".$year." and semester='".$sem."'))";
	$result = mysqli_query($conn,$sql_sec);

	if (mysqli_num_rows($result) > 0) {
		// output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        $secopts=$secopts."<option value='".$row["section_id"]."'>".$row["name"]."</option>";
    }
} else {
    $secopts="0 results";
}
$quizopts="";
	$sql_quiz = "select quiz_id,name from quiz where quiz_id IN(select quiz_id from quiz_section where section_id IN(select section_id from section where course_crn_id IN(select course_crn_id from course_crn WHERE crn IN(select crn from crn where year=".$year." and semester='".$sem."'))))";
	$result1 = mysqli_query($conn,$sql_quiz);

	if (mysqli_num_rows($result1) > 0) {
		// output data of each row
    while($row = mysqli_fetch_assoc($result1)) {
        $quizopts=$quizopts."<option value='".$row["quiz_id"]."'>".$row["name"]."</option>";
    }
} else {
    $quizopts="0 results";
}
echo $quizopts."<br>".$secopts."<br>".$crnopts;
$array=array($crnopts,$secopts,$quizopts);
$conn->close();
echo $array;
?>