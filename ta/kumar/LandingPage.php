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
$midas=$_REQUEST["midasid"];
$error=0;
$sql="SELECT * from user where midas_id='".$midas."'";
$rs=$conn->query($sql);
if ($rs->num_rows > 0) {
	while($row = $rs->fetch_assoc()) {
		$roleid=$row["role_id"];
	}
}
if (is_null($roleid))
{
	$roleid=0;
   $error=1;
}
$_SESSION["midas"]=$midas;
$_SESSION["roleid"]=$roleid;
$crnlist="";
$crninfo=array();
if($roleid==1)
{
	$_SESSION["profid"]=$midas;
	$sql_crn="select * from crn where prof_midas_id='".$midas."'";
	$rs_crn=$conn->query($sql_crn);
	if ($rs_crn->num_rows > 0) {
		while($row = $rs_crn->fetch_assoc()) {
			$crninfo[]=$row;
			$crnlist=$crnlist."".$row["id"].",";
		}
	}
	
	$_SESSION["crninfo"]=$crninfo;
	
	$crnlist=substr($crnlist,0,strlen($crnlist)-1);
	
	$_SESSION["crns"]=$crnlist;
}
else if($roleid==2 || $roleid==3)
{
	$sql_ta="select * from professor_ta_mapping where ta_id='".$midas."'";
	$rs_ta=$conn->query($sql_ta);
	$profid="";
	if ($rs_ta->num_rows > 0) {
		while($row = $rs_ta->fetch_assoc()) {
			$profid=$row["PROF_ID"];
		}
	}
	
	$_SESSION["profid"]=$profid;
	
	$sql_crn="select * from crn where prof_midas_id='".$profid."'";
	$rs_crn=$conn->query($sql_crn);
	if ($rs_crn->num_rows > 0) {
		while($row = $rs_crn->fetch_assoc()) {
			$crninfo[]=$row;
			$crnlist=$crnlist."".$row["id"].",";
		}
	}
	$_SESSION["crninfo"]=$crninfo;
	
	$crnlist=substr($crnlist,0,strlen($crnlist)-1);
	
	$_SESSION["crns"]=$crnlist;
}
$conn->close();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Home Page</title>
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <script type="text/javascript">
  function showPage(x)
  {
	  document.getElementById("displayController").src=x;
  }
  function changeRole()
  {
	  var roleid=0;
	  var error=<?php echo $error?>;
	  if(error==0)
		{
	     roleid=<?php echo $roleid?>;
		}
		
	  if(roleid==0)
	  {
		  $("#adminMenu").hide();
		  $("#profMenu").hide();
		  $("#taMenu").hide();
		  $("#adminTAMenu").hide();
		  alert("Username or password is incorrect!!  Please login again");
           document.location.href ="http://qav2.cs.odu.edu/kumar/HomePage.php";
		}
		  else if(roleid==1)
				  {
			  $("#adminMenu").hide();
			  $("#profMenu").show();
			  $("#taMenu").hide();
			  $("#adminTAMenu").hide();
			  }
		  else if(roleid==2)
		  {
			  $("#adminMenu").hide();
			  $("#profMenu").hide();
			  $("#taMenu").show();
			  $("#adminTAMenu").hide();
	  }
		  else if(roleid==3)
		  {
			  $("#adminMenu").hide();
			  $("#profMenu").hide();
			  $("#taMenu").hide();
			  $("#adminTAMenu").show();
	  }
		  else if(roleid==4)
		  {
			  $("#adminMenu").show();
			  $("#profMenu").hide();
			  $("#taMenu").hide();
			  $("#adminTAMenu").hide();
	  }
}
  </script>
</head>
<body onload="changeRole()">
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand">Quiz Application</a>
    </div>
       <!-- Options for Admin -->
    <div id="adminMenu">
      <ul class="nav navbar-nav">
      <li  class="dropdown">
         <a class="dropdown-toggle" data-toggle="dropdown" href="#">Questions<span class="caret"></span></a>
		      <ul class="dropdown-menu">
		            <li><a href="javascript:showPage('/kumar/csvQuestions.php')">Upload</a></li>
		            <li><a href="javascript:showPage('/kumar/ta/CreateQuestion.php')">Create</a></li>
		            <li><a href="#">Modify</a></li> 
		          </ul>
		</li>
        <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Quiz<span class="caret"></span></a>
        	<ul class="dropdown-menu">
        	<li><a href="javascript:showPage('/kumar/CreateCRN.php')">Create CRN</a></li>
        	<li><a href="javascript:showPage('/kumar/QuizList.php')">List</a></li>
            <li><a href="javascript:showPage('/kumar/CreateQuiz.php')">Auto</a></li>
            <li><a href="javascript:showPage('/kumar/CreateComplexQuiz.php')">Manual</a></li>
            <li><a href="javascript:showPage('/kumar/UploadQuiz.php')">Upload</a></li>
            <li><a href="javascript:showPage('/kumar/AssignQuizToCRN.php')">Assign to CRN</a></li>
            <li><a href="javascript:showPage('/kumar/enableDisableQuiz.php')">Enable/Disable Quiz</a></li>
            <li><a href="#">Delete</a></li>
            <li><a href="#">Modify</a></li> 
          </ul>
          </li>
        <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Tags<span class="caret"></span></a>
        	<ul class="dropdown-menu">
		            <li><a href="javascript:showPage('/kumar/AddTag.php')">Add</a></li>
		    </ul>
        </li>
        <li><a href="javascript:showPage('/kumar/AddStudents.php')">Add Students</a></li>
        <li class="dropdown"><a class="dropdown-toggle"
					data-toggle="dropdown" href="#">Reports<span class="caret"></span> </a>
					<ul class="dropdown-menu">
						<li><a href="javascript:showPage('/kumar/ReportsHome.php')">Reports on Quiz</a></li>
						<li><a href="javascript:showPage('/kumar/services/AllQuestionAnalysis.php')">Question Analysis</a></li>
					</ul>
				</li>

       <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><b style="color: blue;">Welcome <?php echo  $midas?>[<?php echo $roleid?>]</b><span class="caret"></span></a>
        <ul class="dropdown-menu">
		            <li><a href="/kumar/HomePage.php">Logout</a></li>
		    </ul>
        </li>
      </ul>
    </div>
       <!-- Options for Admin TA -->
     <div id="adminTAMenu">
      <ul class="nav navbar-nav">
      <li  class="dropdown">
         <a class="dropdown-toggle" data-toggle="dropdown" href="#">Questions<span class="caret"></span></a>
		      <ul class="dropdown-menu">
		            <li><a href="javascript:showPage('/kumar/csvQuestions.php')">Upload</a></li>
		            <li><a href="javascript:showPage('/triveni/ta/CreateQuestion.php')">Create</a></li>
		            <li><a href="#">Modify</a></li> 
		          </ul>
		</li>
        <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Quiz<span class="caret"></span></a>
        	<ul class="dropdown-menu">
        	<li><a href="javascript:showPage('/kumar/QuizList.php')">List</a></li>
            <li><a href="javascript:showPage('/kumar/CreateQuiz.php')">Auto</a></li>
            <li><a href="javascript:showPage('/kumar/CreateComplexQuiz.php')">Manual</a></li>
            <li><a href="javascript:showPage('/kumar/UploadQuiz.php')">Upload</a></li>
            <li><a href="javascript:showPage('/kumar/AssignQuizToCRN.php')">Assign to CRN</a></li>
            <li><a href="#">Delete</a></li>
            <li><a href="#">Modify</a></li> 
          </ul>
          </li>
        <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Tags<span class="caret"></span></a>
        	<ul class="dropdown-menu">
		            <li><a href="javascript:showPage('/kumar/AddTag.php')">Add</a></li>
		    </ul>
        </li>
        <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">TA<span class="caret"></span></a>
        	<ul class="dropdown-menu">
		            <li><a href="javascript:showPage('/kumar/ta/GetTAList.php')">List</a></li>
		              <li><a href="javascript:showPage('/kumar/ta/AddTA.php')">Add</a></li>
		    </ul>
        </li>
        <li><a href="#">Reports</a></li>
       <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><b  style="color: blue;">Welcome <?php echo  $midas?>[<?php echo $roleid?>] [<?php echo $crnlist?>]</b><span class="caret"></span></a>
        <ul class="dropdown-menu">
		            <li><a href="/kumar/HomePage.php">Logout</a></li>
		    </ul>
        </li>
      </ul>
    </div>
       <!-- Options for TA -->
     <div id="taMenu">
      <ul class="nav navbar-nav">
      <li  class="dropdown">
         <a class="dropdown-toggle" data-toggle="dropdown" href="#">Questions<span class="caret"></span></a>
		      <ul class="dropdown-menu">
		            <li><a href="javascript:showPage('/triveni/ta/CreateQuestion.php')">Create</a></li>
		            <li><a href="#">Modify</a></li> 
		          </ul>
		</li>
        <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Quiz<span class="caret"></span></a>
        	<ul class="dropdown-menu">
        	
        	<li><a href="javascript:showPage('/kumar/QuizList.php')">List</a></li>
            <li><a href="javascript:showPage('/kumar/CreateQuiz.php')">Auto</a></li>
            <li><a href="javascript:showPage('/kumar/CreateComplexQuiz.php')">Manual</a></li>
            <li><a href="javascript:showPage('/kumar/UploadQuiz.php')">Upload</a></li>
            <li><a href="javascript:showPage('/kumar/AssignQuizToCRN.php')">Assign to CRN</a></li>
          </ul>
          </li>
        <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Tags<span class="caret"></span></a>
        	<ul class="dropdown-menu">
		            <li><a href="javascript:showPage('/kumar/AddTag.php')">Add</a></li>
		    </ul>
        </li>
       <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><b style="color: blue;">Welcome <?php echo  $midas?>[<?php echo $roleid?>] [<?php echo $crnlist?>]</b><span class="caret"></span></a>
        <ul class="dropdown-menu">
		            <li><a href="/kumar/HomePage.php">Logout</a></li>
		    </ul>
        </li>
      </ul>
    </div>
    <!-- Options for Professor -->
     <div id="profMenu">
      <ul class="nav navbar-nav">
        <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Quiz<span class="caret"></span></a>
        	<ul class="dropdown-menu">
        	<li><a href="javascript:showPage('/kumar/QuizList.php')">List</a></li> 
          </ul>
          </li>
        <li  class="dropdown">
         <a class="dropdown-toggle" data-toggle="dropdown" href="#">CRN<span class="caret"></span></a>
		      <ul class="dropdown-menu">
		    		  <li><a href="javascript:showPage('/kumar/professor/CRNList.php')">List</a></li>
		            <li><a href="javascript:showPage('/kumar/AddCRN.php')">Add</a></li>
		          </ul>
		</li>
        <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">TA<span class="caret"></span></a>
        	<ul class="dropdown-menu">
		            <li><a href="javascript:showPage('/kumar/ta/GetTAList.php')">List</a></li>
		              <li><a href="javascript:showPage('/kumar/ta/AddTA.php')">Add</a></li>
		    </ul>
        </li>
        <li><a href="#">Reports</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" f style="float: right;"><b style="color: blue;">Welcome <?php echo  $midas?></b><span class="caret"></span></a>
        <ul class="dropdown-menu">
		            <li><a href="/kumar/HomePage.php">Logout</a></li>
		    </ul>
        </li>
    </ul>
    </div>
    
  </div>
</nav>

<div class="container">
<iframe src="" id="displayController" width="100%" height="1000px" style="border: 0px;" scrolling="auto">

</iframe>
</div>
<div id="footer">
</div>
</body>
</html>