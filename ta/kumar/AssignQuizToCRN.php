<?php
session_start();
define ('DB_USER', 'user');
define ('DB_PASSWORD', 'handson1234');
define ('DB_HOST', 'handson-mysql');
define ('DB_NAME', 'quiz');
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_NAME)
OR die ('Could not connect to MySQL: '.mysql_error());

$crnopts="";
if($_SESSION["roleid"]==4)
{
	$sql="select * from crn";
	$rs=$conn->query($sql);
	if($rs->num_rows>0)
	{
		while($row = $rs->fetch_assoc()) {
			$crnopts=$crnopts."<option value='".$row["id"]."'>".$row["crn"].":".$row["course"]."</option>";
		}
	}
}
else 
{
	$len=count($_SESSION["crninfo"]);
	for($i=0;$i<$len;$i++)
	  {
	  	$crnopts=$crnopts."<option value='".$_SESSION["crninfo"][$i]["id"]."'>".$_SESSION["crninfo"][$i]["crn"].":".$_SESSION["crninfo"][$i]["course"]."</option>";
	  }
}

$sql_quiz="select quiz_id,name from quiz";
$result=$conn->query($sql_quiz);
$quizopts="";
if($result->num_rows>0)
{
	while($row = $result->fetch_assoc()) {
		$quizopts=$quizopts."<option value='".$row["quiz_id"]."'>".$row["name"]."</option>";
	}
}

$sql_sec="select section_id,name from section";
$result=$conn->query($sql_sec);
$secopts="";
if($result->num_rows>0)
{
	while($row = $result->fetch_assoc()) {
		$secopts=$secopts."<option value='".$row["section_id"]."'>".$row["name"]."</option>";
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
			$("#crnSelect").append("<?php echo $crnopts?>");
			$("#quizSelect").append("<?php echo $quizopts?>");
			$("#secSelect").append("<?php echo $secopts?>");
			});
  </script>
</head>
<body>
<div class="panel panel-success">
  <div class="panel-heading">Assign Quiz to below CRN's</div>
  <div class="panel-body">
  <form action="/kumar/services/TagQuizToCRN.php" method="post">
  <label>Select CRN:</label>
  <select id="crnSelect" name="crnSelect" class="form-group" style="width: 200px;">
  </select>
    <label>Select Quiz:</label>
  <select id="quizSelect" name="quizSelect" class="form-group" style="width: 100px;">
  </select>
  <label>Select Section:</label>
  <select id="secSelect" name="secSelect" class="form-group" style="width: 100px;">
  </select>
  <input id="assign" name="assign"  type="submit" value="Assign" />
  </form>
  </div>
  </div>
</body>
</html>