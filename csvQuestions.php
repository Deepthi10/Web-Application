<html>
<head>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<?php
//ini_set('display_errors',1);
include ('auth.php');
include ('connect.php');
include ('header.php');
?>
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
		$counter_oldqtn=0;
		$counter_newqtn=0;
	// Import uploaded file to Database
		$handle = fopen ( $_FILES ['filename'] ['tmp_name'], "r" );
		for($lines = 0; $data = fgetcsv ( $handle, 1000, ",", '"' ); $lines ++) {
		
			$question = addslashes($data[0]);
			$options = addslashes ($data[1] );
			$chapter = addslashes ( $data[3] );
			$tags = addslashes ( $data[4] );
			$diff_level = addslashes ( $data[5] );
			$text = addslashes($data[6]);
			$correct_option = addslashes ($data[2] );

			//echo "==================================================";
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
           //var_dump($optiontags);
		  // echo "<br>".$optiontags."<br>";
		   

			$sql = "SELECT * FROM question WHERE question = '$question'";
		//echo $sql;
			$results = mysqli_query ( $conn, $sql ) or die ( mysqli_error ( $conn ) );

			if (mysqli_num_rows ( $results ) < 1) {
			echo " Above Question and options Inserted";
			/*(added by me on sunday)
                $arr = "";
		        while ($row = mysqli_fetch_assoc($results)) {
				$arr.= $row['$question']."|";					
		        }	
		        echo $arr;*/
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
					} 
					
					
					else {
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
                        
						//Added Insert for tag
						
						//$sql="INSERT into tag (tag_id, name) VALUES ($tag_id,'$name')";
						
						

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
					
					//Added by me
					$sql10= "Select tag_id from tag where name = '$tags'";
					 //echo $sql10;
					 $results10 = mysqli_query($conn,$sql10) or die (mysqli_error($conn));
					 if (mysqli_num_rows ( $results10 ) > 0) {
					 while ( $row = mysqli_fetch_assoc ( $results10 ) ) {

						$tag_id = $row ['tag_id'];
					//echo $tag_id;
					}
					 }
					 else{
						 $sql11= "INSERT INTO tag (name) VALUES ('$tags')";
					 //echo $sql11;
					 $results11 = mysqli_query($conn,$sql11) or die (mysqli_error($conn));
					 $tag_id = $last_id = mysqli_insert_id($conn);
					 }
					 $sql12= "INSERT INTO question_tag (question_id,tag_id) VALUES ($qid,$tag_id)";
					 //echo $sql12;
					 $results12 =mysqli_query($conn,$sql12) or die (mysqli_error($conn));
					 
				} else {
					echo 'No textbook in Database like ';
					echo $text;
				}
			//print $question;
				//print "=================================<br>";
				//echo "<script type='text/javascript'>alert('No of Questions Successfully inserted!')</script>";
				print "</br>";
				$counter_newqtn++;
			} else {
				//print $question;
				echo "Above Question and options already in DB";
				//echo "<script type='text/javascript'>alert('Already exists in database!')</script>";
				print "</br>";
				$counter_oldqtn++;
			}
		}
		if($counter_oldqtn!==0){
			//echo '<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>';
			echo '<div class="modal fade" id="myModal" role="dialog">';
             echo '<div class="modal-dialog">';
               // <!-- Modal content-->
             echo '<div class="modal-content">';
              echo '<div class="modal-header">';
                echo '<button type="button" class="close" data-dismiss="modal">&times;</button>';
                 echo '<h4 class="modal-title">Modal Header</h4>';
               echo '</div>';
             echo '<div class="modal-body">';
           echo '<p>Some text in the modal.</p>';
        echo '</div>';
        echo '<div class="modal-footer">';
          echo '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
        echo '</div>';
      echo '</div>';
      echo '</div>';
     echo '</div>';
			echo '<script type="text/javascript">alert("Number of Questions Inserted Already exists in database is = '.$counter_oldqtn.'")</script>';
		
		}
         if($counter_newqtn!==0){
			 
			echo '<script type="text/javascript">alert("Number of New Questions Inserted is = '.$counter_newqtn.'")</script>';
		 
		}
		 
		fclose ( $handle );
	}
	else
	{
		echo "<label>You can only upload csv files!!! Please try uploading a csv file</label>";
	}
	
} 


else {
}
?>
<body>
<script>
function myModal(){
	//alert("Modal works!");
}
</script>
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
					<td colspan="2"><input type='submit' name='submit' value='Upload' onclick="myModal()"/></td>
				</tr>
			</table>
		</form>
	</div>
</div>
</body>
</html>
