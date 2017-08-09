<?php
include ('services/connect.php');
if ($_SERVER ['REQUEST_METHOD'] == "POST") {
	if ($_FILES [myFile] [size] > 0) {
		$file = $_FILES [myFile] [tmp_name];
		$handle = fopen ( $file, "r" );
		$cnt = 0;
		do {
			if ($data [0]) {
				$cnt += 1;
				if ($cnt > 1) {
					// for each question
					$question_id = 0;
					$quiz_id=0;
					$qname=$_REQUEST["qname"];
					$duration=$_REQUEST["qduration"];
					$pts=$_REQUEST["qpts"];
					$tag_id = 0;
					$options = array ();
					$options = split ( ";", $data [1] );
					$correct = $data [2];
					$chapter = $data [3];
					$tags = $data [4];
					$level = $data [5];
					$tb = $data [6];
					echo "INSERT INTO `quiz`(`name`, `duration`, `start_time`, `end_time`, `possible_points`, `status`, `location_id`) VALUES (.$qname.,.$duration.,now(),now(),.$pts.,'CREATED','')<br>";
					echo "INSERT INTO QUESTION VALUES(" . $data [0] . ",1,1,null,now(),null,0,0)<br>";
					echo "INSERT INTO `quiz_question`(`quiz_id`, `question_id`, `created_on`) VALUES (.$quiz_id.,.$question_id.,now())<br>";
					foreach($options as $opt ) {
						if($opt==$correct)
						{
						echo "INSERT INTO QUESTION_OPTION ('question_id','option','correct_flag') VALUES(".$question_id ."," .$opt.",1)<br>";
						}
						else {
							echo "INSERT INTO QUESTION_OPTION ('question_id','option','correct_flag') VALUES(".$question_id ."," .$opt.",0)<br>";
						}
					}
					
					echo "INSERT INTO tag(name) VALUES ('.$tags.')<br>";
					echo "INSERT INTO `question_tag`(`question_id`, `tag_id`) VALUES (.$question_id.,.$tag_id.)<br>";
					echo "---------------------------------------------------------<br>";
				}
			}
		} while ( $data = fgetcsv ( $handle, 1000, "|", "'" ) );
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
<script type="text/javascript">
var nameFlag=false;
  function checkQuizName()
  {
	  var condt=$("#qname").val();
	  if(condt==null || condt =='')
	  {
		  $("#available").hide();
		  $("#notAvailable").hide();
	  }
	  else
		  {
		  $.ajax({
	          type: "GET",
	          url: "/quizapp_web_dev/services/CheckQuizName.php?qname="+condt,
	          data: "",
	          dataType: "text",
	          success: function( data, textStatus, jqXHR) {
	        	if(data=="false")
	        		{
	        		$("#available").hide();
	        		nameFlag=false;
	        		$("#notAvailable").show();
	        		}
	        	else if(data=="true")
	        		{
	        		$("#available").show();
	        		nameFlag=true;
	        		$("#notAvailable").hide();
	        		}
	          },
		 	 error: function( data, textStatus, jqXHR) {
	      	alert("error"+data);
	        }
		  });
		  }
  }
  </script>
</head>
<body>
	<div class="panel panel-success">
		<div class="panel-heading">Enter Quiz Details</div>
		<div class="panel-body">
			<form action="" method="post" enctype="multipart/form-data"
				role="form">
				<label>Upload Quiz :</label> Quiz Name:<input type="text" id="qname"
					name="qname" onchange="checkQuizName()" /> <span id="notAvailable"
					style="color: red; display: none;"
					class="glyphicon glyphicon-thumbs-down"></span> Duration:<input
					type="text" id="qduration" name="qduration" size="5" /> Points:<input
					type="text" id="qpts" name="qpts" size="5" /> <input type="file"
					id="myFile" name="myFile" /> <input type="submit" id="uploadBtn"
					name="uploadBtn" value="Upload" />
			</form>
		</div>
	</div>
</body>
</html>