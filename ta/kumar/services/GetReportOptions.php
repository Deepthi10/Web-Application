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

$year=$_REQUEST["yr"];
$sem=$_REQUEST["sem"];
$sql="SELECT semester.name,semester.year,course_crn.crn FROM semester join section on semester.semester_id=section.semester_id join course_crn on section.course_crn_id=course_crn.course_crn_id WHERE semester.name='".$sem."' and semester.year=".$year;

$rs_crn=mysqli_query($conn,$sql) or die(mysql_error());

	
    $crnopts="";
    while($row = mysqli_fetch_assoc($rs_crn)) {
    	
        $crnopts=$crnopts."<option value='".$row["crn"]."'>".$row["crn"]."</option>";
    }
$secopts="";
	$sql_sec = "SELECT section.section_id,section.name FROM semester join section on semester.semester_id=section.semester_id join course_crn on section.course_crn_id=course_crn.course_crn_id WHERE semester.name='".$sem."' and semester.year=".$year;
	$result = mysqli_query($conn,$sql_sec);

	if (mysqli_num_rows($result) > 0) {
		
    while($row = mysqli_fetch_assoc($result)) {
        $secopts=$secopts."<option value='".$row["section_id"]."'>".$row["name"]."</option>";
    }
} else {
    $secopts="0 results";
}


$array=array($crnopts,$secopts);
$conn->close();
echo json_encode($array);

?>