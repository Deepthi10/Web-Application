<?php
		include ('services/connect.php');
 if (isset ( $_POST ['submit'] )) {
	session_start();

	
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
		echo "<h3>Displaying contents:</h3>";
		//readfile($_FILES['filename']['tmp_name']);
	}
	$handle = fopen ( $_FILES ['filename'] ['tmp_name'], "r" );
	for($lines = 0; $data = fgetcsv ( $handle, 1000, ",", '"' ); $lines ++) {
		//var_dump($data);

	 		 $midas_id = addslashes($data[0]);
			 $uin = addslashes ($data[1] );
			 $first_name = addslashes ( $data[2] );
			 $last_name = addslashes ( $data[3] );
			 $email = addslashes ( $data[4] );
			 $course_id = addslashes($data[5]);
			 $sql = "SELECT * FROM user WHERE midas_id = '$midas_id'";
			 //echo $sql;
			 $results = mysqli_query ( $conn, $sql ) or die ( mysqli_error ( $conn ) );


			 //echo "No of Rows: ".mysqli_num_rows($results);

			 //var_dump($results);
			 if (mysqli_num_rows ( $results ) > 0)
			 {
			 	echo $midas_id."---already present in database<br>";
			 }
			 else
			 {
			 
			 	$query="INSERT INTO `quiz`.`user` (`user_id`, `midas_id`, `uin`, `first_name`, `last_name`, `email`, `course_id`, `role_id`, `device_type`, `device_token`, `created_on`) VALUES (NULL, '$midas_id', '$uin', '$first_name', '$last_name', '$email', '$course_id', '0', NULL, NULL, CURRENT_TIMESTAMP)";
			 	$queryresults = mysqli_query ( $conn, $query ) or die ( mysqli_error ( $conn ) );
			 	echo $query;
			 	echo  $midas_id." not in db--inserted successfully<br>";
			 	
			 } 
			
	}
	}
} 
?> 

<html>
<head>
<link rel="stylesheet"
	href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script
	src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script
	src="http://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
</head>
<body>
	<div class="panel panel-info">
		<div class="panel-heading">UPLOAD Students</div>
		<div class="panel-body">
			<form enctype='multipart/form-data' action='AddStudents.php' accept=".csv"
				method='post'>
				<table class="table table-striped">
					<tr><td><label>File Format:</label></td><td>Midas Id|UIN|first name|last name|email|Course ID (3 for cs120 and 4 for cs121)</td></tr>
					<tr>
						<td><label>Select a csv file:</label></td>
						<td><input size='50' type='file' name='filename' /></td>
					</tr>
					<tr>
						<td colspan="2"><input type='submit' name='submit' value='Upload' /></td>
					</tr>
				</table>
			</form>
		</div>
	</div>
</body>
</html>
