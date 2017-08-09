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
           // echo "Connected successfully";
           if($_SESSION["roleid"]==4)
           {
           	$sql="SELECT quiz_id,name,duration,possible_points,status FROM `quiz`";
           }
           else {
            $sql="SELECT quiz_id,name,duration,possible_points,status FROM `quiz` where quiz_id in (select quiz_id from crn_quiz where crn_id in (".$_SESSION["crns"]."))";
           }
            $count=0;
            $rs=$conn->query($sql);
            $rows=array();
            if ($rs->num_rows > 0) {
            	// output data of each row
            	//$trHTML = "<thead><th style='display:none;'>Q.Id</th><th>Quiz Name</th><th>Duration(Mins)</th><th>Points</th></thead>";
            	while($row = $rs->fetch_assoc()) {
            		if($count>=5)
            		{
            			$rows['quizzes'][]=$row;
            		}
            		else
            		{
            			$rows['quizzes'][]=$row;
            			//$trHTML .= "<tr id=".$row["quiz_id"]."><td style='display:none;'>".$row["quiz_id"] ."</td><td><a href='javascript:loadQuizDetails(".$row["quiz_id"].")'>".$row["name"]."</a></td><td>".$row["duration"]."</td><td>".$row["possible_points"]."</td></tr>";
            			$count = $count+1;
            		}
            	}
            }
            $conn->close();
		?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>List of Quiz's</title>
 <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script type="text/javascript">
var jsonData=<?php   echo json_encode($rows)?>;
var pgnum=1;
var count=0;
function loadList()
{
	$('#quizTable').empty();
	$('#popUpDetails').hide();
	 count=Math.ceil(jsonData.quizzes.length/5);
	 var trHTML = "<thead><th style='display:none;'>Q.Id</th><th>Quiz Name</th><th>Duration(Mins)</th><th>Points</th><th>Status</th></thead>";
     $.each(jsonData.quizzes, function (i, item) {
   	  if(i>=5)
   		  {
   		  pgnum=1;
   		  $("#pgno").text("Page:"+pgnum);
   		  return;
   		  }
   	trHTML += "<tr id="+item.quiz_id+"><td style='display:none;'>" + item.quiz_id + "</td><td><a href='javascript:loadQuizDetails("+item.quiz_id+")'>" + item.name + "</a></td><td>"+item.duration+"</td><td>"+item.possible_points+"</td><td>"+item.status+"</td></tr>";
     });
	$("#pgno").text("Page:"+pgnum);
	$('#quizTable').append(trHTML);
}

function displayPagination(pgno)
{
	  var start = (pgno-1)*5;
	  var end =   (pgno*5)-1;
	  $('#quizTable').empty();
		 var trHTML = "<thead><th style='display:none;'>Q.Id</th><th>Quiz Name</th><th>Duration(Mins)</th><th>Points</th><th>Status</th></thead>";
	  for(var i=start;i<=end;i++)
		  {
		  var item=jsonData.quizzes[i];
		  if(i>=jsonData.quizzes.length)
			  {
			  	
			  }
		  else
			  {
			  trHTML += "<tr id="+item.quiz_id+"><td style='display:none;'>" + item.quiz_id + "</td><td><a href='javascript:loadQuizDetails("+item.quiz_id+")'>" + item.name + "</a></td><td>"+item.duration+"</td><td>"+item.possible_points+"</td><td>"+item.status+"</td></tr>";
				  }
		  }
		$('#quizTable').append(trHTML);
}

function pagination(x)
{
	  if(parseInt(x)==1)
		  {
		//prev page
		  if(pgnum==1)
			  {
			  	alert("You are on the first page");
			  }
		  else
			  {
			  	pgnum=pgnum-1;
				$("#pgno").text("Page:"+pgnum);
				displayPagination(pgnum);
			  }
		  }
	  else if(parseInt(x)==2)
		  {
		//next page
			if(pgnum==count)
			  {
			  	alert("You are on the Last page");
			  }
			else
				{
				pgnum=pgnum+1;
				$("#pgno").text("Page:"+pgnum);
				}
			displayPagination(pgnum);
		  }
}

function loadQuizDetails(quizid)
{
	$('#popUpDetails').show();
	 $.ajax({
          url: "/kumar/QuizDetails.php?qid="+quizid,
          data:"",
          type:"GET",
          dataType: "text",
          success: function( data, textStatus, jqXHR) {
        	  $('#quizDetails').empty();
        	  $('#quizDetails').show();
	          	$('#quizDetails').append(data);
          },
	 	 error: function( data, textStatus, jqXHR) {
        	alert("error:"+data);
        }
	  });
}
function hideQuizDetails()
{
	 $('#quizDetails').hide();
}
</script>
</head>
<body onload="loadList()">
<div class="panel panel-info">
  <div class="panel-heading">List of Quizzes
  <div style="float: right;">
 <a href="javascript:pagination(1)">
<span class="glyphicon glyphicon-step-backward"></span>
 </a>
<label id="pgno"></label>
 <a href="javascript:pagination(2)">
<span class="glyphicon glyphicon-step-forward"></span>
 </a></div>
  </div>
  <div class="panel-body">
<table id="quizTable" class="table table-hover">
</table>
</div>
</div>
<div id="popUpDetails" style="z-index: 3;" class="panel panel-info">
  <div class="panel-heading">Quiz Details<a href="javascript:hideQuizDetails()" style="float: right;"><span class="glyphicon glyphicon-remove"></span></a></div>
  <div class="panel-body">
<table id="quizDetails" class="table table-hover">
</table>
</div>
</div>
</body>
</html>