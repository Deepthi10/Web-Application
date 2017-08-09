<?php 
include ('services/connect.php');
session_start();
$dbhost = 'handson-mysql';
$dbuser = 'bkongara';
$dbpass = 'Mamatha5!';
$dbname = 'quiz';

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_NAME) or die('Error connecting to mysql');
// mysql_select_db($dbname);
//echo $conn;

if(!$conn){
	
	//echo "hi";
}
$crnid=$_REQUEST["crnid"];
$qid=$_REQUEST["autocourse"];
$midasid=$_REQUEST["midasid"];
$sem=$_REQUEST["sem"];
$year=$_REQUEST["year"];
$course=$_REQUEST["course"];
$section=$_REQUEST["section"];
$loca=$_REQUEST["loca"];
$cformat=$_REQUEST["cformat"];
$return_arrfinal=array();
$sec_array=array();
$last_id=array();

$sqlgetCourseID="SELECT crn.crn ,course_crn_id,course.course_id,number,prof_midas_id ,semester.year ,semester.name,semester_id FROM `crn` ,
		course_crn, course,semester where `crn`.crn='".$crnid."' and crn.crn=course_crn.crn and course_crn.course_id=course.course_id and 
		semester_id= (select semester.semester_id from semester where year='".$year."' and semester.name='".$sem."')";

$rs=mysql_query($sqlgetCourseID);

//echo $sqlgetCourseID;

		while($row = mysql_fetch_array($rs)){
			
			$row_array['crn']= $row['crn'] ;
			$row_array['course_crn_id']= $row['course_crn_id'] ;
			$row_array['course_id']= $row['course_id'] ;
			$row_array['number']= $row['number'] ;
			$row_array['year']= $row['year'] ;
			$row_array['semester']= $row['semester_id'] ;
			$row_array['prof_midas_id']= $row['prof_midas_id'] ;

			// 
			$crn=$row_array['crn'];
			$course_crn_id=$row_array['course_crn_id'];
			$course_id=$row_array['course_id'];
			$number=$row_array['number'];
			$year=$row_array['year'];
			$semester=$row_array['semester'];
			$prof_id=$row_array['prof_midas_id'];
			
			// select instructor id
			$selectInstructorID="select id from teachers where username='".$prof_id."'";
		    //echo $selectInstructorID;
			$rsInstID=mysql_query($selectInstructorID);
			
			while($row=mysql_fetch_assoc($rsInstID))
			{
				foreach ($row as $cname=>$cvalue)
					//$cvalue;	
			// insert instructor ,semester _id , course_crn_id in section table
			
			$CreateNewSection="INSERT INTO `quiz`.`section` (`section_id`, `name`, `semester_id`, `course_crn_id`, `instructor_id`, `location_id`, `created_on`) VALUES 
					          (NULL, '".$section."', '".$semester."', '".$course_crn_id."', '".$cvalue."', NULL, now())";
			echo $CreateNewSection;
			mysql_query($CreateNewSection);
			//echo $last_id;
			
			$last_id['section_id']= mysql_insert_id();
			//array_push(,$last_id);
			}
		
		}
		array_push($return_arrfinal,$row_array,$last_id);
		header('Content-Type: application/json');
		echo json_encode($return_arrfinal);



?>