<!DOCTYPE html >


<html>
<head>
<!-- <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"> -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Create Question</title>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <script type="text/javascript">
  $(document).ready(function() { 
$("#flag").hide();

$.get('getQuizDetails.php',
	       {
		   		type: 'getQuizNames'
		   	},
	   function(data){
		   		var list='';
		   	list= "<select name='quizname' type ='text' class='form-control' id='quizname'>";
		     
			 	   for(var i=0;i<data.length;i++){
list+="<option>"+data[i]['name']+"</option>";

				 	   }
			 	   list+="</select>";
		   		console.log(list);
		   		$("#quizn").html(list);
		   		
		   		
	   });

	  });
function reply(c){

	$("#flag").val(c);
	console.log($("#flag").val());
}
 </script>
</head>
<body>
 <form method="POST" action="CreateQuestion.php" > 
   <form role="form">
 <div class="container">
 <!--  <form action=""> -->
<div class="panel panel-success">
  <div class="panel-heading">Add Question's to the Database</div>
  <div class="panel-body">
  <!--added onn 15th sep  -->
  

<!--changes end  -->
 <!--  <form role="form" class="form-horizontal"> -->
 <div class="form-group">
      <label class="control-label col-sm-2" for="qname">Question:</label>
      <div class="col-sm-10">
        <input name="qname" type ="text" class="form-control" id="qname" placeholder="Enter Question Here">
      </div>
       <label class="control-label col-sm-2" for="quiznameis">Quiz:</label>
      <div class="col-sm-10" id="quizn">
          </div>
 </div>
 </div></div>

   <div class="panel panel-success">
  <div class="panel-heading">Answer Options         (select the button correct option before submission)</div>
  <div class="panel-body"> 
    
    <!--   <div class="form-inline" role="form">     --> 

  
  
   <div class="input-group">
  <span class="input-group-btn">
    <button class="btn btn-success" type="button" name="opt1" id="opt1" onClick="reply(this.id)" >Option 1</button>
  </span>
  <input type="text" name="one"  class="form-control" placeholder="option 1">
</div>
  
   <div class="input-group">
  <span class="input-group-btn">
    <button class="btn btn-success" type="button"  name="opt2" id="opt2" onClick="reply(this.id)" >Option 2</button>
  </span>
  <input name="two" type="text" class="form-control" placeholder="option 2">
</div>
  
  
   <div class="input-group">
  <span class="input-group-btn">
    <button class="btn btn-success" type="button"  id="opt3" onClick="reply(this.id)" >Option 3</button>
  </span>
  <input name="three" type="text" class="form-control" placeholder="option 3">
</div>
  
  
   <div class="input-group">
  <span class="input-group-btn">
    <button class="btn btn-success" type="button" id="opt4" onClick="reply(this.id)">Option 4</button>
  </span>
  <input name="four" type="text" class="form-control" placeholder="option 4">
</div>
 </div></div>
 
 
 <div class="panel panel-success">
  <div class="panel-heading">Additional Details</div>
  <div class="panel-body">
  <div class="form-group">
      <label class="control-label col-sm-2" for="qtags">Tags:</label>
      <div class="col-sm-10">
        <input name="qtags" type="text" class="form-control" id="qtags" placeholder="Enter Tags in comma seperated list">
      </div>
 </div>
 <br>
 <div class="form-group">
 <label class="control-label col-sm-2" for ="dlevel">Difficulty Level:</label>
 <div class="col-sm-10">
 <input name= "dlevel" type="text" class="form-control" id="dlevel" placeholder="Enter Diffuculty Level" >
 </div>
   </div>
 <br>
 <div class="form-group">
 <label class="control-label col-sm-2" for ="point">Points to be awarded: </label>
 <div class="col-sm-10">
 <input name= "point" type="text" class="form-control" id="point" placeholder="This question is worth how many points?" required>
 
 </div>
 </div>
 
 <div class="form-group">
 <div class="col-sm-10">
<input name= "flag" type="text" class="form-control" id="flag">
 </div>
 </div>
 <br><br>
 <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <input type="submit" name="submit" value ="submit">
      </div>
    </div>
    
    
    </div>
</div>

</div>  <!-- container -->
</form>
</form>
</body>
</html>


<?php 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {  
 include "config.php";
$dbhost = 'handson-mysql';
$dbuser = 'bkongara';
$dbpass = 'Mamatha5!';
$dbname = 'quiz';
$conn = mysql_connect ( $dbhost, $dbuser, $dbpass ) or die ( 'Error connecting to mysql' );
mysql_select_db ( $dbname );

echo $dbname;



if ($conn) {
	echo "coasfsdfnnected";
}

$dlevel = $_POST['dlevel'];
$qname = $_POST['qname'];
$flag = $_POST['flag'];
$opt4 = $_POST['four'];
$opt1 = $_POST['one'];
$opt3 = $_POST['three'];
$opt2 = $_POST['two'];
$point = $_POST['point'];
$qtags = $_POST['qtags'];
$qans = $_POST['qtags'];
$dlevel=$_POST['dlevel'];
$quizname=$_POST['quizname'];
$qopt1flag=$qopt2flag=$qopt3flag=$qopt4flag=0;


if($flag==''){
	echo "<script type='text/jscript'>
 		alert('Error:-Please select the correct answer option.');
 		showPage('/kumar/ta/CreateQuestion.php');
 		</script>" ;
}
else{
if($flag=='opt1'){
	$qopt1flag=1;
}
else if($flag=='opt2'){
	
$qopt2flag=1;
}
else if($flag=='opt3'){
$qopt3flag=1;

}
else if($flag=='opt4'){
$qopt4flag=1;

}


$sqlgetQuizID="select quiz_id from quiz where name='".$quizname."'";

$result=mysql_query($sqlgetQuizID);
while($row=mysql_fetch_assoc($result))
{
	foreach ($row as $cname=>$quizid)
		//echo $quizid;
		echo '';
}

$sql = "INSERT INTO question (question, point, created_by, edited_by, created_date, edit_date, text_chap_id, diff_level) VALUES
 	    ('".$qname."' , '".$point."', '', '',NOW() ,'' ,'' ,'".$dlevel."' )";

//echo $sql;
$result=mysql_query($sql);
	
//RETRIEVE LAST CREATED QUESTION ID insertion into quiz option table
$sql1="SELECT question_id FROM question where question='".$qname."' and point='".$point."' order by question_id desc limit 1";
	
	 //echo $sql1;
	 
	// echo $qans;
	$result=mysql_query($sql1);
	while($row=mysql_fetch_assoc($result))
	{
	foreach ($row as $cname=>$cvalue)
		//echo $cvalue;
		echo '';
	} 
	 

	$sql2 = "INSERT INTO question_option (question_id,option,correct_flag) VALUES ('".$cvalue."','".$opt1."','".$qopt1flag."'),('".$cvalue."','".$opt2."','".$qopt2flag."'),('".$cvalue."','".$opt3."','".$qopt3flag."'),('".$cvalue."','".$opt4."','".$qopt4flag."')";
    //echo $sql2;
   $result2=mysql_query($sql2); 
   
    
   $sqlInsert="Insert into quiz_question (quiz_id,question_id,created_on) values ('".$quizid."','".$cvalue."',now())";
   mysql_query($sqlInsert);
   
    
    // insertion into quiz_tag table
    $sql3="INSERT INTO question_tag (question_id,tag_id,tag_detail) VALUES ('".$cvalue."','','".$qtags."')";
    $result3=mysql_query($sql3);

    echo $sql3;
    mysql_close ( $conn );
    
    echo "<script type='text/jscript'>
 		alert('Question is created and linked to the quiz');
 		showPage('/kumar/ta/CreateQuestion.php');
 		</script>" ;
    
    
}

}
    ?>