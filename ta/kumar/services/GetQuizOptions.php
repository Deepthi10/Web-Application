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
$crn=$_REQUEST["crn"];
$sec=$_REQUEST["sec"];
$quizopts="";
	$sql_quiz = "SELECT quiz.quiz_id,quiz.name FROM semester join section on semester.semester_id=section.semester_id join course_crn on section.course_crn_id=course_crn.course_crn_id join quiz_section on quiz_section.section_id=section.section_id join quiz on quiz_section.quiz_id=quiz.quiz_id WHERE course_crn.crn=".$crn." and section.section_id=".$sec;
	$result1 = mysqli_query($conn,$sql_quiz);

	if (mysqli_num_rows($result1) > 0) {
	
    while($row = mysqli_fetch_assoc($result1)) {
        $quizopts=$quizopts."<option value='".$row["quiz_id"]."'>".$row["name"]."</option>";
    }
} else {
    $quizopts="0 results";
}
$conn->close();
echo $quizopts;
?>