<?php
session_start();
include ('services/connect.php');
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_NAME)
OR die ('Could not connect to MySQL: '.mysql_error());


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
		});
  </script>
</head>
<body>
<div class="panel panel-success">
		  <div class="panel-heading">Create Section For the generated CRN</div>
		  <div class="panel-body">
		  <form action="/quizapp_web_dev/services/TagQuizToCRN.php" method="post">
		  <label>Enter Section Name:</label>
		  <select id="sectionname" name="sectionname" class="form-group" style="width: 200px;">
		  </select>
    <label>Enter Location:</label>
  <select id="loca" name="loca" class="form-group" style="width: 100px;">
  </select>
  <input id="assign" name="assign"  type="submit" value="Next" />
  </form>
  </div>
  </div>
</body>
</html>