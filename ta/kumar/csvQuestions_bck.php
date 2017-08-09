<?php
include ('auth.php');
include ('connect.php');
include ('header.php');
?>
<?php

if (isset ( $_POST ['submit'] )) {
	$fname=$_FILES ['filename'] ['name'];
	if(pathinfo($fname,PATHINFO_EXTENSION)=="csv")
	{
	if (is_uploaded_file ( $_FILES ['filename'] ['tmp_name'] )) {
		echo "<h3>"."File ".$_FILES ['filename'] ['name']." uploaded successfully."."</h3>";
		echo "<h3>Displaying contents:</h3>";
		// readfile($_FILES['filename']['tmp_name']);
	}
	// Import uploaded file to Database
	$handle = fopen ( $_FILES ['filename'] ['tmp_name'], "r" );
	for($lines = 0; $data = fgetcsv ( $handle, 1000, ",", '"' ); $lines ++) {
		if ($lines == 0)
			continue;
			// $question = addslashes($data[0]);
		$question = mysqli_real_escape_string ( $conn, $data [0] );
		$options = mysqli_real_escape_string ( $conn, $data [1] );
		$correct_option = mysqli_real_escape_string ( $conn, $data [2] );
		// $correct_option = mysqli_real_escape_string($conn,$correct_option);
		$chapter = addslashes ( $data [3] );
		$tags = addslashes ( $data [4] );
		$tags = mysqli_real_escape_string ( $conn, $tags );
		$diff_level = addslashes ( $data [5] );
		// $text = addslashes($data[6]);
		$text = mysqli_real_escape_string ( $conn, $data [6] );
		
		// $text = strtolower($text);
		// $chapter = strtolower($chapter);
		
		$sql = "SELECT * FROM question WHERE question = '$question'";
		$results = mysqli_query ( $conn, $sql ) or die ( mysqli_error ( $conn ) );
		
		if (mysqli_num_rows ( $results ) < 1) {
			
			$sql = "SELECT * FROM texbook WHERE text_name = '$text'";
			$results = mysqli_query ( $conn, $sql ) or die ( mysqli_error ( $conn ) );
			if (mysqli_num_rows ( $results ) > 0) {
				
				while ( $row = mysqli_fetch_assoc ( $results ) ) {
					
					$text_id = $row ['id'];
				}
				
				$sql = "SELECT * FROM text_chap_link WHERE textbook_id = $text_id AND chapter = '$chapter'";
				
				$results = mysqli_query ( $conn, $sql ) or die ( mysqli_error ( $conn ) );
				if (mysqli_num_rows ( $results ) > 0) {
					while ( $row = mysqli_fetch_assoc ( $results ) ) {
						
						$text_chap_id = $row ['text_chap_id'];
					}
				} else {
					$sql = "INSERT INTO text_chap_link (textbook_id, chapter) VALUES ($text_id,'$chapter')";
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
				
				mysqli_query ( $conn, $sql ) or die ( mysqli_error ( $conn ) );
				$qid = $last_id = mysqli_insert_id ( $conn );
				
				// $correct_option = strtolower($correct_option);
				
				$options = explode ( ";", $data [1] );
				foreach ( array_filter ( $options ) as $t ) {
					$t = mysqli_real_escape_string ( $conn, $t );
					// print $options[1];
					
					$t1 = strtolower ( $t );
					$correct_option1 = strtolower ( $correct_option );
					
					if ($t1 == $correct_option1) {
						$flag = 1;
					} else {
						$flag = 0;
					}
					
					$sql = "INSERT INTO question_option ( question_id, option , correct_flag) VALUES ($qid,'$t',$flag)";
					
					mysqli_query ( $conn, $sql ) or die ( mysqli_error ( $conn ) );
					
					$i ++;
				}
				// $import="INSERT into tablename(item1,item2,item3,item4,item5) values('$data[0]','$data[1]','$data[2]','$data[3]','$data[4]')";
				// mysqli_query($conn,$import) or die(mysqli_error($conn));
				
				$tags = explode ( ";", $tags );
				
				if (! empty ( $tags )) {
					foreach ( $tags as $tag_new ) {
						
						$sql1 = "SELECT * FROM tag WHERE name = '$tag_new'";
						$results = mysqli_query ( $conn, $sql1 ) or die ( mysqli_error ( $conn ) );
						if (mysqli_num_rows ( $results ) > 0)
							while ( $row = mysqli_fetch_assoc ( $results ) ) {
								
								$tag_id = $row ['tag_id'];
							}
						
						else {
							$sql = "INSERT INTO tag (name) VALUES ('$tag_new')";
							mysqli_query ( $conn, $sql ) or die ( mysqli_error ( $conn ) );
							$tag_id = $last_id = mysqli_insert_id ( $conn );
						}
						$sql2 = "INSERT INTO question_tag (question_id, tag_id) VALUES ($qid,$tag_id)";
						mysqli_query ( $conn, $sql2 ) or die ( mysqli_error ( $conn ) );
					}
				}
			} else {
				echo 'No textbook in Database like ';
				echo $text;
			}
			print $question;
			print " successfully inserted";
			print "</br>";
		} else {
			print $question;
			print " already exists in database";
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
} else {
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
					<tr><td><label>File Format:</label></td><td>QUESTIONS|OPTIONS(COMMA SEPARATED)|CORRECT OPTION|CHAPTER|CUSTOM TAGS|DIFFICULTY LEVEL|TEXTBOOK</td></tr>
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
