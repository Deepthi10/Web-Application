<?php 
echo hi;
echo $_POST['submit'];
echo $_POST['saveCRN'];
echo $_POST['Next'];
session_start();

if (isset ( $_POST ['submit'] )) {

	$dbhost = 'handson-mysql';
	$dbuser = 'bkongara';
	$dbpass = 'Mamatha5!';
	$dbname = 'quiz';

	$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die('Error connecting to mysql');
	mysql_select_db($dbname);
	echo "connection ".$conn;

	if(!$conn){

	//echo "hi";
	}
	$crnid=$_REQUEST["crnid"];
	$qid=$_REQUEST["course"];
	$cformat=$_REQUEST["cformat"];
	$midasid=$_REQUEST["midasid"];
	$sem=$_REQUEST["sem"];
	$year=$_REQUEST["year"];
	$course=$_REQUEST["course"];
	$section = $_REQUEST["sectionname"];
	$location=$_REQUEST["loca"];
	$fname=$_FILES ['fileToUpload'] ['name'];
	$return_arrfinal=array();


// check the sem and year mapping  //
	$sql1="select name from semester where name='".$sem."' and year='".$year."'";
	echo $sql1;
	$rs=mysql_query($sql1);
	if(mysql_num_rows($rs)==0){

		$row_array[]="0";

		echo "Incorrect mapping of sem and year!!Try agian with correct mapping";
	}
	else{

		if(pathinfo($fname,PATHINFO_EXTENSION)=="csv")
		{

			echo "<script>console.log(\"3\");</script>";
			if (is_uploaded_file ( $_FILES ['fileToUpload'] ['tmp_name'] )) {
				echo "<h3>"."File ".$_FILES ['fileToUpload'] ['name']." uploaded successfully."."</h3>";
				echo "<h3>Displaying contents:</h3>";
			//readfile($_FILES['filename']['tmp_name']);
			}
		}

		// Insert CRN Details into CRN Table. //
		$sql="INSERT INTO `crn`(`id`, `crn`, `course`, `prof_midas_id`, `class_format`, `year`, `semester`,`Created_Date`) VALUES
		(null,".$crnid.",'".$course."','".$midasid."','".$cformat."','".$year."','".$sem."',now())";
		//echo $sql;

		if(mysql_query($sql))
		{
			$crn_id=mysql_insert_id();
			echo "Created CRN :".$crn_id."<br>";
		// get the last generated crn ID //
			$sqlgetCourseID="SELECT crn, course_id,number,year,semester,prof_midas_id,Created_Date FROM `crn` , `course` where course=course.number and crn.id='".$crn_id."'";
			//echo $sqlgetCourseID;
			$rs=mysql_query($sqlgetCourseID);
			//var_dump($rs);
			while($row = mysql_fetch_array($rs))
			{	
				$crn= $row['crn'] ;
				$courseid= $row['course_id'] ;
				$number= $row['number'] ;
				$year= $row['year'] ;
				$semester= $row['semester'] ;
				$prof_id= $row['prof_midas_id'] ;
				$create_Date= $row['Created_Date'] ;


				$sqlInsertCourseID="INSERT INTO `quiz`.`course_crn` (`course_crn_id`, `course_id`, `crn`, `created_on`) VALUES (NULL, '".$courseid."', '".$crn."','".$create_Date."' )";	
			//echo $sqlInsertCourseID;
				mysql_query($sqlInsertCourseID);
				$course_id = mysql_insert_id();
				echo "Mapping CRN :".$crn." to course : ".$courseid." generated course_crn_id :".$course_id."<br>";
				$sqlgetCourseID="SELECT crn ,course_crn_id,course_id FROM course_crn where course_crn_id ='".$course_id."' and crn='".$crnid."'";
			//echo $sqlgetCourseID;
				$rs=mysql_query($sqlgetCourseID);

				while($row = mysql_fetch_array($rs)){
					//echo "<script>console.log(\"5\");</script>";	
					$crn= $row['crn'] ;
					$course_crn_id= $row['course_crn_id'] ;
					$course_id= $row['course_id'] ;
       				// get semid
					$getsemid="select semester_id from semester where year='".$year."' and name='".$sem."'";
					$rssemid=mysql_query($getsemid);
					$semvalue=0;
					while($row=mysql_fetch_assoc($rssemid))
					{
						// semester ids
						$semvalue=$row["semester_id"];
					}
			 			// select instructor id
					$selectInstructorID="select id from teachers where username='".$midasid."'";
								//echo $selectInstructorID;
					$rsInstID=mysql_query($selectInstructorID);

					while($row=mysql_fetch_assoc($rsInstID))
					{
						$cvalue=$row["id"];

						$CreateNewSection="INSERT INTO `quiz`.`section` (`section_id`, `name`, `semester_id`, `course_crn_id`, `instructor_id`, `location_id`, `created_on`) VALUES
						(NULL, '".$section."', '".$semvalue."', '".$course_crn_id."', '".$cvalue."', '".$location."', now())";
						echo $CreateNewSection;
						if(mysql_query($CreateNewSection)){
							$section_id=mysql_insert_id();
							echo "Section id created :".$section_id;
								// map students to quiz

										// Import uploaded file to Database
							$handle = fopen ( $_FILES ['fileToUpload'] ['tmp_name'], "r" );
							for($lines = 0; $data = fgetcsv ( $handle, 1000, ",", '"' ); $lines ++) {
								if ($lines == 0)
									continue;
								$midasid = addslashes($data[0]);
								//echo $midasid;

								//echo "==================================================";
								//echo "<br>".$midasid."<br>";


								$findstudentid="select user_id from user where midas_id='".$midasid."'";
								//echo $findstudentid;
								$rsmidas=mysql_query($findstudentid);
								while($row=mysql_fetch_array($rsmidas)) {

									$id=$row['user_id'];
									//echo $id;
									$mappingstudentsection="Insert into student_section (user_id,section_id) values ($id,$section_id)";
									mysql_query($mappingstudentsection);
									echo $id." into section : ".$section_id." <br>";

												} //while closing


												$row_array['status']="success";
								//array_push(,$last_id);
							} //for closing

						} //if closing

					} //while closing
				}//while closing

			}//while closing
			
		}//if closing


	} // first else closing

}  //main if closing


?>