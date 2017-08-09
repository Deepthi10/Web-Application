<!DOCTYPE html >
<html>
<head>
<!-- <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"> -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Alert After CSV Upload</title>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script type="text/javascript">

	$(document).ready(function(){
	   $("#flag").hide();
	     debugger;
		//strVal- I dont know what how to get questions here by get
          $.ajax({
			            type:"GET",
					    url:"/quizapp_web_dev/csvQuestions.php?strVal="+strVal,
			            dataType:"text",
			                success:function(data,textStatus,jqXHR){
								
						         var result=data.split("-");
						          console.log(result);
								},
							error: function( data, textStatus, jqXHR) {
			  		      	  alert("error: some problem!");
			  		      	  //errorPopUp("some problem!");
			  		        }
					});
    });
  </script> 
 </head>
 <body>
 
 </body>
  </html>

  