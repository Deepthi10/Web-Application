<?php
//ini_set('display_errors',1);
include ('auth.php');
include ('connect.php');
include ('header.php');
?>
<?php

if (isset ( $_POST ['submit'] )) {
	session_start();
	define ('DB_USER', 'user');
	define ('DB_PASSWORD', 'handson1234');
	define ('DB_HOST', 'handson-mysql');
	define ('DB_NAME', 'quiz');
	
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
	// Import uploaded file to Database
		$handle = fopen ( $_FILES ['filename'] ['tmp_name'], "r" );
		for($lines = 0; $data = fgetcsv ( $handle, 1000, ",", '"' ); $lines ++) {
		//var_dump($data);
		//if ($lines == 0)
			//continue;
			$question = addslashes($data[0]);
			$options = addslashes ($data[1] );
			$chapter = addslashes ( $data[3] );
			$tags = addslashes ( $data[4] );
			$diff_level = addslashes ( $data[5] );
			$text = addslashes($data[6]);
			$correct_option = addslashes ($data[2] );

			echo "==================================================";
			echo "<br>".$question."<br>";

			$optionsex = explode ( ";", $data[1] );
					// $correct_optionChk = strtolower($correct_option);
			foreach ($optionsex as $item) {
					 	//echo "<li>$item</li>";
				if( strCmp(trim(strtolower($item)," "),trim(strtolower($correct_option)," "))==0){
					$flag=1;
					echo "<li>". $item." (This Option will have Flag: " . $flag.")</li>";
				} 
				else{

					echo "<li>$item</li>";
				} 
			}


					//echo "=====================================<br>";
			echo "<li>correct Option is:- ". $correct_option."</li>";
					// echo "=====================================<br>";





			$optiontags = explode ( ";", $data[4] );
			foreach ($optiontags as $item) {
				echo "<li>Tags with this question:".$item."</li>";
			}


			$sql = "SELECT * FROM question WHERE question = '$question'";
		//echo $sql;
			$results = mysqli_query ( $conn, $sql ) or die ( mysqli_error ( $conn ) );

			if (mysqli_num_rows ( $results ) < 1) {
			//echo "question is new to DB";

				$sql = "SELECT * FROM texbook WHERE text_name = '$text'";

				$results = mysqli_query ( $conn, $sql ) or die ( mysqli_error ( $conn ) );

				if (mysqli_num_rows ( $results ) > 0) {
				//echo "text book is present in DB";

					while ( $row = mysqli_fetch_assoc ( $results ) ) {

						$text_id = $row ['id'];
					//echo $text_id;
					}

					$sql = "SELECT * FROM text_chap_link WHERE textbook_id = $text_id AND chapter = '$chapter'";
				//echo $sql;
					$results = mysqli_query ( $conn, $sql ) or die ( mysqli_error ( $conn ) );
					if (mysqli_num_rows ( $results ) > 0) {
					//echo "found link in DB";
						while ( $row = mysqli_fetch_assoc ( $results ) ) {

							$text_chap_id = $row ['text_chap_id'];
						}
					} else {
					//echo "added new link to DB";
						$sql = "INSERT INTO text_chap_link (textbook_id, chapter) VALUES ($text_id,'$chapter')";
					//echo $sql;
						$results = mysqli_query ( $conn, $sql ) or die ( mysqli_error ( $conn ) );
						mysqli_query ( $conn, $sql ) or die ( mysqli_error ( $conn ) );
						$text_chap_id = $last_id = mysqli_insert_id ( $conn );
					}

					$diff_level = strtolower ( $diff_level );
					if ($diff_level == 'easy')
						$diff = 1;
					if ($diff_level == 'medium')
						$diff = 2;

					if ($diff_level == 'hard')
						$diff = 3;

					$sql = "INSERT INTO question ( question, text_chap_id, diff_level) VALUES ('$question',$text_chap_id,$diff)";
				//echo $sql;
					$results = mysqli_query ( $conn, $sql ) or die ( mysqli_error ( $conn ) );
					//mysqli_query ( $conn, $sql ) or die ( mysqli_error ( $conn ) );
					$qid = $last_id = mysqli_insert_id ( $conn );

					$correct_optionChk = strtolower($correct_option);
				// echo $correct_optionChk;


					$optionsall = explode ( ";", $data[1] );
				 // $correct_optionChk = strtolower($correct_option);
					foreach ($optionsall as $item) {
				 	//echo "<li>$item</li>";
						if( strCmp(trim(strtolower($item)," "),trim(strtolower($correct_option)," "))==0){
							$flag=1;
				 		//echo "<li>". $item." (This Option will have Flag: " . $flag.")</li>";
							$sql = "INSERT INTO question_option ( question_id, option , correct_flag) VALUES ($qid,'$item',$flag)";
							mysqli_query ( $conn, $sql ) or die ( mysqli_error ( $conn ) );
						}
						else{

				 		//echo "<li>$item</li>";
							$flag=0;
							$sql = "INSERT INTO question_option ( question_id, option , correct_flag) VALUES ($qid,'$item',$flag)";
							mysqli_query ( $conn, $sql ) or die ( mysqli_error ( $conn ) );
						}
					}


				} else {
					echo 'No textbook in Database like ';
					echo $text;
				}
			//print $question;
				print "=================================<br>";
				print " Question Successfully inserted";
				print "</br>";
			} else {
				print $question;
				echo "=====================================<br>";
				print " Already exists in database";
				print "</br>";
			}
		}

		fclose ( $handle );
	}
	else
	{
		echo "<label>You can only upload csv files!!! Please try uploading a csv file</label>";
	}
	// view upload form
} 


else {
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
		<div class="panel-heading">UPLOAD QUESTIONS</div>
		<div class="panel-body">
			<form enctype='multipart/form-data' action='csvQuestions.php' accept=".csv"
			method='post'>
			<table class="table table-striped">
				<tr><td><label>File Format:</label></td><td>QUESTIONS|OPTIONS(SEMI COLAN (;) SEPARATED)|CORRECT OPTION (num)|CHAPTER(name should be in db)|CUSTOM TAGS|DIFFICULTY LEVEL|TEXTBOOK (name should be in db)</td></tr>
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
