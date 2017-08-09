<?php
session_start();
include ('services/connect.php');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_NAME)
OR die ('Could not connect to MySQL: '.mysql_error());

if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$sql="SELECT * FROM `crn` WHERE prof_midas_id='".$_SESSION["midas"]."'";
$rs=$conn->query($sql);
$taData=array(); 
if ($rs->num_rows > 0) {
	while($row = $rs->fetch_assoc()) {
		$taData[] =$row;
	}
}
$conn->close();
?>
<html>
<head>
 <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <script type="text/javascript">
  function loadTAList()
  {
  var tableData=<?php echo json_encode($taData)?>;
  var taLIST="<thead><th>CRN</th><th>Course</th><th>Class Format</th><th>Year</th><th>Semester</th></thead>";
  $("#taTable").empty();
  $.each(tableData, function (i, item) {
	  taLIST +="<tr><td>"+item.crn+"</td><td>"+item.course+"</td><td>"+item.class_format+"</td><td>"+item.year+"</td><td>"+item.semester+"</td></tr>";
	  });
	$("#taTable").append(taLIST);		
  }
  </script>
</head>
<body onload="loadTAList()">
<div class="panel panel-info">
  <div class="panel-heading">CRN's</div>
    <div class="panel-body">
    <table id="taTable" class="table table-hover">
	</table>
    </div>
  </div>
</body>
</html>