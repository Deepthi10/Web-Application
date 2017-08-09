<?php

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Manual Quiz</title>
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
  <script src="http://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript">
$(document).ready(function () {
$("#SECTIONdetails").hide();
$("#Studentsdetails").hide();
$("#saveCRN").click(function (){

	 
/* else{
	  $.post('CheckCRNdetails.php',
				{
		  year: $("#year").val(),
		  sem: $("#sem").val(),
					},			
	     function (data){
			var getSem=data;
            if(getSem[0]!="0"){           
	        $.post('SaveCRN.php',
     		{
	     	
	        crnid: $("#crnid").val(),
            course: $("#course").val(),
            midasid: $("#midasid").val(),
            cformat: $("#cformat").val(),
            year: $("#year").val(),
            sem: $("#sem").val(),
            section: $("#sectionname").val(),
            loca:$("#loca").val()
            },
	                  function (data){


                // if success
	                      // map students //
	                      // done
		                             });
}


	}); 
} */
	});


$("#saveSection").click(function (){
	  $.post('SaveSection.php',
				{
		  crnid: $("#autocrnid").val(),
		  course: $("#autocourse").val(),
		  midasid: $("#automidasid").val(),
		  year  : $("#autoyear").val(),
		  cformat: $("#autosem").val(),
		  section: $("#sectionname").val(),
		  loca : $("#loca").val()
					},
	function (data){

						var detail = data;
						console.log(detail[0]["crn"]);
						if(detail[0]["crn"]>0){
alert("CRN TO SECTION MAPPING DONE");
$("#SECTIONdetails").hide();
$("#Studentsdetails").show();
}
		}); 
					});
  });
 </script>
</head>
<body>
<body>
<div class="panel panel-success" id="CRNdetails">
 <form enctype='multipart/form-data' action='SaveCRN.php' accept=".csv" METHOD='POST'>
  <div class="panel-heading">Enter CRN Details</div>
  <div class="panel-body">

<label for ="crnid" >CRN ID:</label><input type="text" id="crnid" name="crnid" required>

<label for ="course" >Course:</label>
<select id="course" name="course" />
<option value="CS120">CS120</option>
<option value="CS121">CS121</option>
</select>


<label for ="midasid" >Professor Midas ID:</label><input type="text" id="midasid" name="midasid" size="5" required >
<label for ="cformat" >class_format:</label><input type="text" id="cformat" name="cformat" size="5" value="0" required >
<label for ="year" >Year:</label>
<select id="year" name="year">
<option value="2014">2014</option>
<option value="2015">2015</option>
<option value="2016">2016</option>
<option value="2017">2017</option>
</select>


<label for ="sem" >Semester:</label>
<select id="sem" name="sem">
<option value="Spring">Spring</option>
<option value="Fall">Fall</option>
<option value="Fall">Summer</option>
</select>

<br><br>
<label>Enter Section Name:</label>
		  <input id="sectionname" name="sectionname" class="form-group" style="width: 350px;" Placeholder="For example:- CS120-RGUPTA-Kaufmann 1423" required/>
		 
		<label>Enter Location:</label>
	 <input id="loca" name="loca" class="form-group" style="width: 200px;" required />
		  
<label class="control-label col-sm-6" for ="fileToUpload">Upload Midas IDs:</label>
<input name="fileToUpload" type ="file"  id="fileToUpload" required>


<input type="submit" name="submit" value ="submit">
</form>
</div>
</div>







</body>