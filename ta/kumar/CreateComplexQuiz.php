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
  var questionList=[];
  var selQuesList="";
  var nameFlag=false;
  $(document).ready(function() {
	  
	  $("#filterQues").click(function(e){
		  $('#displayQuestion').empty();
		  var condt=$("#filterCondt").val();
		  var condts=condt.split(",");
		  condt="";
		  for (var i = 0; i < condts.length; i++) {
	          condt=condt+"'"+condts[i]+"',";
	        }
		 
		  condt=condt.substring(0,condt.length-1);
		  
		  console.log("-"+condt+"-");
		  $.ajax({
	          type: "GET",
	          url: "/kumar/services/QuizQuestionGenerator.php?pts=1&condt="+condt,
	          data: "",
	          dataType: "json",
	          success: function( data, textStatus, jqXHR) {
	        	  var trHTML = '<thead><th>Q.No</th><th>Question</th><th>Level</th></thead>';
	        	  var count=1;
	              $.each(data.questions, function (i, item) {
	            	  trHTML += "<tr id='"+item.question_id+"'><td>"+count+"</td><td>"+item.question+"<a class='btn btn-link btn-sm questAddTag_CCQ' href='javascript:addQuestion("+item.question_id+")'>"+
	            	  "<span class='glyphicon glyphicon-plus'></span></a><a class='btn btn-link btn-sm hidden questRemoveTag_CCQ' href='javascript:removeQuestion("+item.question_id+")'>"+
	            	  "<span class='glyphicon glyphicon-minus'></span></a></td><td>"+item.diff_level+"</td></tr>";
	            	  count=count+1;
	              });
	              $('#displayQuestion').append(trHTML);  
	          },
	          error:function( data, textStatus, jqXHR) {
					alert("error:"+data);
		          }
		  });
	  	});
  });
  
  function addQuestion(x)
  {
	  var count=parseInt(document.getElementById("qpts").value);

	  if(questionList.length<count)
		  {
		  if($.inArray(x,questionList)>-1)
		  {
			alert("Question already selected in the list");
		  }
		  else
			  {
				//alert(questionList.length+":qid"+x);
			  var index=questionList.length;
			  questionList[index]=x;
			  $("#addQues").empty();
			  //debugger;
			  $("#addQues").append("Added:"+questionList.length+"");
			  console.log( " QuesionID:"+x);
			  $("#"+x).find(".questAddTag_CCQ").addClass("hidden");
			  $("#"+x).find(".questRemoveTag_CCQ").removeClass("hidden");
			  selQuesList=selQuesList+""+x+",";
			  $("#selectedQues").val(selQuesList);
			  }
		  }
	  else
		  {
		 	alert("You can only add "+document.getElementById("qpts").value+" questions");
		  }
	 
  }
  
  function removeQuestion(x)
  {
  	
  	var index=questionList.indexOf(x);
  	console.log("in remove"+index);
	//debugger;
	questionList.splice(index,1);
	$("#"+x).find(".questRemoveTag_CCQ").addClass("hidden");
	$("#"+x).find(".questAddTag_CCQ").removeClass("hidden");
	$("#addQues").empty();
	$("#addQues").append("Added:"+questionList.length+"");
  }


  function validate()
  {
	  var count=parseInt(document.getElementById("qpts").value);
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
	  else if(questionList.length<count)
		  {
		  alert("Please select required no of questions!!");
		  return false;
		  }
	  else 
		  {
		  return true;
		  }
		
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
  </script>
</head>
<body>
<div class="panel panel-success">
  <div class="panel-heading">Enter Quiz Details</div>
  <div class="panel-body">
<form id="quizForm" action="/kumar/services/SaveQuiz.php" method="post">
Quiz Name:<input type="text" id="qname" name="qname" onchange="checkQuizName()"/>
<span id="available" style="color: green;display: none;" class="glyphicon glyphicon-thumbs-up"></span>
<span id="notAvailable" style="color: red;display: none;" class="glyphicon glyphicon-thumbs-down"></span>
Duration:<input type="text" id="qduration" name="qduration" size="5" />
Points:<input type="text" id="qpts" name="qpts" size="5" value="0" />
<input type="text" id="filterCondt" name="filterCondt" size="30"/>
<!-- Filter Type:<select id="filterType"> -->
<!-- <option value="and">And</option> -->
<!-- <option value="or">Or</option> -->
<!-- </select> -->
<input type="hidden" id="selectedQues" name="selectedQues" size="10"/><br><br>
Start Date and Time :<input type="date" id="startDate" name="startDate"><input type="time" id="startTime" name="startTime"><br>
End Date and Time :<input type="date" id="endDate" name="endDate"><input type="time" id="endTime" name="endTime">
<input type="button" id="filterQues" name="filterQues" value="Filter" class="btn btn-primary" />
<input type="submit" id="saveQuiz" value="Save" class="btn-success" onclick="return validate();" /><br>
<div id="addQues" style="font-weight: bold;color: red;">
</div>
<table id="displayQuestion" class="table">
</table>
</form>
</div>
</div>
</body>
</html>