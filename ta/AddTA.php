<?php
session_start ();
	include ('services/connect.php');


if ($_SERVER ['REQUEST_METHOD'] == "POST") {
	$conn = mysqli_connect ( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME ) or die ( 'Could not connect to MySQL: ' . mysqli_error () );
	
	if ($conn->connect_error) {
		die ( "Connection failed: " . $conn->connect_error );
	}
	
	$ta_id = $_POST ['taMidas'];
	$first_name =$_POST ['fName'] ;
	$last_name = $_POST ['lastName'] ;
	$email = $_POST ['email'] ;
	$role_id = $_POST ['roleType'] ;
	
	$sql = "INSERT INTO user (midas_id, first_name, last_name, email, role_id) 
        VALUES ('". $ta_id . "','" . $first_name . "','" . $last_name . "','" . $email . "'," . $role_id . ")";
	
	echo $sql;
	
	if ($conn->query ( $sql ) == TRUE) {
		$uid = $conn->insert_id;
		echo "Records added successfully";
	} else {
		
		echo "New record could not be added";
	}
	$conn->close ();
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<link rel="stylesheet"
	href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" />
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
		<div class="panel-heading">Add TA</div>
		<div class="panel-body">
			<form id="taForm" action="<?php $_PHP_SELF ?>" method="post"
				role="form">
				<div class="form-group">
					<label for="taMidas">Midas ID:</label> <input type="text" value=""
						id="taMidas" name="taMidas" class="form-control" />
				</div>
				<div class="form-group">
					<label for="fName">First Name:</label> <input type="text" value=""
						id="fName" name="fName" class="form-control" />
				</div>
				<div class="form-group">
					<label for="lastName">Last Name:</label> <input type="text"
						value="" id="lastName" name="lastName" class="form-control" />
				</div>
				<div class="form-group">
					<label for="lastName">Email ID:</label> <input type="email"
						id="email" name="email" class="form-control" />
				</div>
				<div class="form-group">
					<label for="roleType">Role:</label> <select id="roleType"
						name="roleType" class="form-control">
						<option value="2">TA</option>
						<option value="3">Admin TA</option>
					</select>
				</div>
				<input type="submit" value="Add" id="add" name="add" />
			</form>
		</div>
	</div>
</body>
</html>