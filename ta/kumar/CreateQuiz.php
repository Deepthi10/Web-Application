<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Create Quiz</title>
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
  <script src="http://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript">
  var nameFlag=false;
	  $(document).ready(function() {
		  $("#filterQues").prop('disabled',true);
		  $("#filterCondt").prop('disabled',true);
	
		  var allQues;
		  $("#genQuiz").click(function(e){
			  if($("#qpts").val()==null || $("#qpts").val()=='')
				  {
				  alert("Please enter points to generate questions");
				  return;
				  }
			  else if($("#qpts").val()==0)
				  {
				  alert("Please enter points to generate questions");
				  return;
				  }
			  var quesList="";
			  $("#filterQues").prop('disabled',false);
			  $("#filterCondt").prop('disabled',false);			
			  $('#quizTable').empty();
			  var formData=$("#quizForm").serialize();
			  $.ajax({
		          type: "GET",
		          url: "/kumar/services/QuizQuestionGenerator.php?pts="+$("#qpts").val(),
		          data: formData,
		          dataType: "json",
		          success: function( data, textStatus, jqXHR) {
		        	  allQues=data.questions;
		        	  var trHTML = '<thead><th>Q.No</th><th>Question</th><th>Tags</th></thead>';
		        	  var count=1;
		              $.each(data.questions, function (i, item) {
		            	  quesList=quesList+item.question_id+",";
		                  trHTML += "<tr id='+item.question_id+'><td>" + count + "</td><td>" + item.question + "<a href='javascript:showOptions("+item.question_id+")' class='glyphicon glyphicon-collapse-down'></a><a href='javascript:hideOptions("+item.question_id+")' class='glyphicon glyphicon-collapse-up'></a><br>";
		                  trHTML +="<div id='opts"+item.question_id+"'></div>";
// 		                  if(item.qans==item.option1)
// 		                	  {
// 		                	  trHTML +='<b>A.'+item.option1+ '</b><br>';
// 		                	  }
// 		                  else
// 		                	  {
// 		                	  trHTML +='A.'+item.option1+ '<br>';
// 		                	  }
		                  
// 		                  if(item.qans==item.option2)
// 	                	  {
// 	                	  trHTML +='<b>B.'+item.option2+ '</b><br>';
// 	                	  }
// 	                 	 else
// 	                	  {
// 	                	  trHTML +='B.'+item.option2+ '<br>';
// 	                	  }
		                  
// 		                  if(item.qans==item.option3)
// 	                	  {
// 	                	  trHTML +='<b>C.'+item.option3+ '</b><br>';
// 	                	  }
// 	                  	else
// 	                	  {
// 	                	  trHTML +='C.'+item.option3+ '<br>';
// 	                	  }
		                  
// 		                  if(item.qans==item.option4)
// 	                	  {
// 	                	  trHTML +='<b>D.'+item.option4+ '</b><br>';
// 	                	  }
// 	                  	else
// 	                	  {
// 	                	  trHTML +='D.'+item.option4+ '<br>';
// 	                	  }
		                 trHTML +='</td><td>';
// 		                 $.each( item.tags, function (k, tag) {
// 		                	 trHTML += item.tags[k]+",";
// 		                 });
		                 trHTML +='</td></tr>';
		                 count=count+1;
		              });
		              $('#selectedQues').val(quesList);
		              $('#quizTable').append(trHTML);  
		          }
			  });
		  });
		  
		  $("#filterQues").click(function(e){
			  var keys=$("#filterCondt").val().split(',');
			  var oper=$("#filterType").val();
			  $.each(allQues, function (i, item) {
				  var flag=false;
				  if(keys=='' || keys==null)
					  {
					  $("#"+item.qid).show();
					  }
				  else
					{
					  if(oper=="or")
						  {
						  var flg1=false;
						  $.each( keys, function (k, tag) {
								if($.inArray(tag,item.tags)>-1)
									  {
									flg1=true;
									  }
	 		                 });
			 						if(!flg1)
			 						{
			 	               		 $("#"+item.qid).hide();
			 	               		}  
						  }
					  else if(oper=="and")
						  {
						  var flg2=false;
						  $.each( keys, function (k, tag) {
								if($.inArray(tag,item.tags)>-1)
									  {
									  }
								else
									{
									flg2=true;
									}
	 		                 });
			 						if(flg2)
			 						{
			 	               		 $("#"+item.qid).hide();
			 	               		}  
						  }
					  
// 					  $.each( item.tags, function (k, tag) {
// 		                	 if(item.tags[k]==key)
// 		                		 {
// 		                		 flag=true;
// 		                		 }
// 		                 });
// 						if(!flag)
// 						{
// 	               		 $("#"+item.qid).hide();
// 	               		 }  
					}   
			  });
		  });//filtering close
		  
// 		  $("#saveQuiz").click(function(e){
// 			  var quizData="{\"quizid\":\"q1\",\"quizname\":\"q1\",\"duration\":10,\"points\":3}";
// 			  var formData=$("#quizForm").serialize();
// 			  alert(quizData);
// 			  $.ajax({
// 		          url: "/QuizApp/rest/quiz/create",
// 		          data:quizData,
// 		          type:"POST",
// 		          contentType:"text",
// 		          dataType: "text",
// 		          success: function( data, textStatus, jqXHR) {
// 		          	alert("Success:"+data);
// 		          },
// 			 	 error: function( data, textStatus, jqXHR) {
// 		        	alert("error:"+data);
// 		        }
// 			  });
// 		  });
		  
	  });//document closing
	  
	  function validate()
	  {
		  if($("#qname").val()=="")
			  {
			  alert("Please enter Quiz Name!!");
			  return false;
			  }
		  else if(nameFlag==false)
		  {
			  alert("Please enter proper quiz name");
			  return false;
		  }
		  else if($("#qduration").val()=="")
		  {
			  alert("Please enter Duration!!");
			  return false;
			  }
		  else if($("#qpts").val()=="")
		  {
			  alert("Please enter Points!!");
			  return false;
			  }
		  else 
			  return true;
	  }
	  
	  function checkQuizName()
	  {
		  var condt=$("#qname").val();
		  if(condt==null || condt =='')
		  {
			  $("#available").hide();
			  $("#notAvailable").hide();
		  }
		  else
			  {
			  $.ajax({
		          type: "GET",
		          url: "/kumar/services/CheckQuizName.php?qname="+condt,
		          data: "",
		          dataType: "text",
		          success: function( data, textStatus, jqXHR) {
		        	if(data=="false")
		        		{
		        		$("#available").hide();
		        		nameFlag=false;
		        		$("#notAvailable").show();
		        		}
		        	else if(data=="true")
		        		{
		        		$("#available").show();
		        		nameFlag=true;
		        		$("#notAvailable").hide();
		        		}
		          },
			 	 error: function( data, textStatus, jqXHR) {
		      	alert("error"+data);
		        }
			  });
			  }
	  }

	  function showOptions(x)
	  {
		  $.ajax({
	          url: "/kumar/services/GetOptions.php?qid="+x,
	          data:"",
	          type:"GET",
	          dataType: "text",
	          success: function( data, textStatus, jqXHR) {
				var optid="#opts"+x;
	        	  $(optid).empty();
	        	  $(optid).show();
	        	  $(optid).append(data);
	          },
		 	 error: function( data, textStatus, jqXHR) {
	        	alert("error:"+data);
	        }
		 });
	  }
	  function hideOptions(x)
	  {
			var optid="#opts"+x;
			 $(optid).hide();
		  }
  </script>
</head>
<body>
<div class="panel panel-success">
  <div class="panel-heading">Enter Quiz Details</div>
  <div class="panel-body">
<form id="quizForm" action="/kumar/services/SaveQuiz.php" method="post">
Quiz Name:<input type="text" id="qname" name="qname" onchange="checkQuizName()" />
<span id="available" style="color: green;display: none;" class="glyphicon glyphicon-thumbs-up"></span>
<span id="notAvailable" style="color: red;display: none;" class="glyphicon glyphicon-thumbs-down"></span>
Duration:<input type="text" id="qduration" name="qduration" size="5" />
Points:<input type="text" id="qpts" name="qpts" size="5" />

<input type="button" id="genQuiz" value="Generate Quiz" class="btn btn-primary"/>
<input type="text" id="filterCondt" name="filterCondt" size="10"/>
Filter Type:<select id="filterType">
<option value="and">And</option>
<option value="or">Or</option>
</select>
<input type="hidden" id="selectedQues" name="selectedQues" size="10"/>
<input type="button" id="filterQues" name="filterQues" value="Filter" class="btn btn-primary" />
<table id="quizTable" class="table">
</table>
<input type="submit" id="saveQuiz" value="Save" class="btn-success" onclick="return validate();" />
</form>
</div>
</div>
</body>
</html>