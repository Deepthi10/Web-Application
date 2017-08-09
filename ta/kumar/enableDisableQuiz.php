<?php
session_start();
include ('services/connect.php');
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_NAME)
OR die ('Could not connect to MySQL: '.mysql_error());

$sql_quiz="select quiz_id,name from quiz";
$result=$conn->query($sql_quiz);
$quizopts="";
if($result->num_rows>0)
{
	while($row = $result->fetch_assoc()) {
		$quizopts=$quizopts."<option value='".$row["quiz_id"]."'>".$row["name"]."</option>";
	}
}



$conn->close();
?>
<html>
<head>
<title></title>
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
  <script src="http://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript">
	$(document).ready(function()
			{
			$("#quizSelect").append("<?php echo $quizopts?>");
			$("#quizSelect1").append("<?php echo $quizopts?>");
			});
	function validate()
	{
	 if($("#startDate").val()=="")
		  {
		  alert("Please enter start Date");
		  return false;
		  }
	  else if($("#startTime").val()=="")
	  {
		  alert("Please enter start time");
		  return false;
		  }
	  else if($("#endTime").val()=="")
	  {
		  alert("Please enter end time");
		  return false;
		  }
	  else if($("#endDate").val()=="")
		  {
		  alert("Please enter end Date");
		  return false;
		  }
	  else 
		  {
		  return true;
		  }

	}
  </script>
</head>
<body>
<div class="panel panel-success">
  <div class="panel-heading">Update Quiz time</div>
  <div class="panel-body">
  <form action="/kumar/services/updateQuizTime.php" method="post">
    <label>Select Quiz:</label>
  <select id="quizSelect" name="quizSelect" class="form-group" style="width: 100px;">
  </select><br>
 Start Date and Time :<input type="date" id="startDate" name="startDate"><input type="time" id="startTime" name="startTime"><br>
End Date and Time :<input type="date" id="endDate" name="endDate"><input type="time" id="endTime" name="endTime">
  <input id="updateTime" name="updateTime"  type="submit" value="Update" onclick="return validate()" />
  </form>
  </div>
  </div>
  <div class="panel panel-success">
  <div class="panel-heading">Complete Quiz</div>
  <div class="panel-body">
  <form action="/kumar/services/completeQuiz.php" method="post">
    <label>Select Quiz:</label>
  <select id="quizSelect1" name="quizSelect1" class="form-group" style="width: 100px;">
  </select>
  <input id="complete" name="complete"  type="submit" value="Complete the Quiz"  />
  </form>
  </div>
  </div>
</body>
</html>