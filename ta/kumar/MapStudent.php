<?php
include ('auth.php');
include ('connect.php');
include ('header.php');
?>
<?php

if (isset ( $_POST ['MapStudents'] )) {
	session_start();
	define ('DB_USER', 'user');
	define ('DB_PASSWORD', 'handson1234');
	define ('DB_HOST', 'handson-mysql');
	define ('DB_NAME', 'quiz');
	
	$course=$_POST['studentseccourse'];
	$midasid=$_POST['studentsecmidasid'];
	$sectionid=$_POST['sectionid'];
	
	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_NAME)
	OR die ('Could not connect to MySQL: '.mysql_error());
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$fname=$_FILES ['filename'] ['name'];
	if(pathinfo($fname,PATHINFO_EXTENSION)=="csv")
	{
		if (is_uploaded_file ( $_FILES ['filename'] ['tmp_name'] )) {
			echo "<h3>"."File ".$_FILES ['filename'] ['name']." uploaded successfully."."</h3>";
			echo "<h3>Details of Sections and students:</h3>";
			//readfile($_FILES['filename']['tmp_name']);
		}
		$handle = fopen ( $_FILES ['filename'] ['tmp_name'], "r" );
		for($lines = 0; $data = fgetcsv ( $handle, 1000, ",", '"' ); $lines ++) {
			if ($lines == 0)
				continue;
			$midasid = $data[0];
		
			echo "==================================================";
			// slect from user
			
			//$sql = "INSERT INTO user ( question, text_chap_id, diff_level) VALUES ('$question',$text_chap_id,$diff)";
			
			
		}
	}
	
}
	
	?>