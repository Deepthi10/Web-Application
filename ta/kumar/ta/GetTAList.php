<?php
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
$sql="SELECT prof.ta_id,u.first_name,u.last_name,u.email,u.role_id from user u,professor_ta_mapping prof where u.midas_id=prof.ta_id and prof.prof_id='".$_SESSION["profid"]."'";
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
  var taLIST="<thead><th>TA</th><th>First Name</th><th>Last Name</th><th>Mail</th><th>Role</th></thead>";
  $("#taTable").empty();
  $.each(tableData, function (i, item) {
	  taLIST +="<tr><td>"+item.ta_id+"</td><td>"+item.first_name+"</td><td>"+item.last_name+"</td><td>"+item.email+"</td><td>"+item.role_id+"</td></tr>";
	  });
	$("#taTable").append(taLIST);		
  }
  </script>
</head>
<body onload="loadTAList()">
<div class="panel panel-info">
  <div class="panel-heading">TA's</div>
    <div class="panel-body">
    <table id="taTable" class="table table-hover">
	</table>
    </div>
  </div>
</body>
</html>