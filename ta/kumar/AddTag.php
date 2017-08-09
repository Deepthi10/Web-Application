<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Add Tags to Question's</title>
 <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
  <script src="http://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript">
  var questionsList;
  var pgnum=1;
  var count=0;
  var selQid="";
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
		  
		  $.ajax({
	          type: "GET",
	          url: "/kumar/services/QuizQuestionGenerator.php?pts=1&condt="+condt,
	          data: "",
	          dataType: "json",
	          success: function( data, textStatus, jqXHR) {
	        	  count=Math.ceil(data.questions.length/5);
	        	 // alert("count_pages:"+count+",ques count:"+data.questions.length);
	        	  questionsList=data.questions;
	        	  var trHTML = '<thead><th>Q.No</th><th>Question</th><th>Level</th></thead>';
	              $.each(data.questions, function (i, item) {
	            	  if(i>=5)
	            		  {
	            		  $("#pgno").text("Page:"+pgnum);
	            		  return;
	            		  }
	            	  trHTML += "<tr id='"+item.question_id+"'><td>"+(parseInt(i)+1)+"</td><td>"+item.question+"<a class='btn btn-link btn-sm' href='javascript:getTags("+item.question_id+")'>"+
	            	  "<span class='glyphicon glyphicon-plus'></span></a></td><td>"+item.diff_level+"</td></tr>";
	              });
	              $('#displayQuestion').append(trHTML);  
	          }
		  });
	  	});
	  
	  
	  $("#addTags").click(function(e){
		  if($("#newTags").val()=="" || $("#newTags").val()==null)
			  {
			  alert("Please enter a tag to add");
			  }
		  else
			  {
			  var tag=$("#newTags").val();
			  $.ajax({
			         type: "GET",
			         url: "/QuizApp/rest/quiz/ques/tags/add/"+selQid+"/"+tag,
			         data: "",
			         dataType: "json",
			         success: function( data, textStatus, jqXHR) {
			        	 alert("added tag to "+selQid);
			        	 getTags(selQid);
			         },
			         error: function( data, textStatus, jqXHR) {
			        	 alert("error");
			         }
				  });
			  }
		  
	  });
  });
  
  function getTags(x)
  {
	 var qid=x;
	 selQid=x;
	 var tags=[];
	 $.ajax({
         type: "GET",
         url: "/kumar/services/GetTags.php?qid="+qid,
         data: "",
         dataType: "json",
         success: function( data, textStatus, jqXHR) {
        	 $("#tagMngmt").empty();
        	 tags=data.tags;
        	 var currTags="";
             $.each(data.tags, function (i, tag) {
            	 currTags=currTags+""+tag.name+"<a href='javascript:removeTag(\""+tag.name+"\","+qid+")'><span class='glyphicon glyphicon-remove'></span></a><br>";
             });
             $("#tagMngmt").html(currTags);
         },
         error: function( data, textStatus, jqXHR) {
        	 alert("error");
         }
	  });
  }
  
  function removeTag(tag,qid)
  {
	  $.ajax({
	         type: "GET",
	         url: "/QuizApp/rest/quiz/ques/tags/remove/"+qid+"/"+tag,
	         data: "",
	         dataType: "json",
	         success: function( data, textStatus, jqXHR) {
	        	 alert("tag successfully deleted!!");
	         },
	         error: function( data, textStatus, jqXHR) {
	        	 alert("error");
	         }
		  });
  }
  
  function displayPagination(pgno)
  {
	  var start = (pgno-1)*5;
	  var end =   (pgno*5)-1;
	  $('#displayQuestion').empty();
	  var trHTML = '<thead><th>Q.No</th><th>Question</th><th>Level</th></thead>';
	  for(var i=start;i<=end;i++)
		  {
		  if(i>=questionsList.length)
			  {
			  	
			  }
		  else
			  {
				  trHTML += "<tr id='"+ questionsList[i].question_id+"'><td>"+(i+1)+"</td><td>"+questionsList[i].question+"<a class='btn btn-link btn-sm' href='javascript:getTags("+questionsList[i].question_id+")'>"+
		    	  "<span class='glyphicon glyphicon-plus'></span></a></td><td>"+questionsList[i].diff_level+"</td></tr>";
				  }
		  }
	  $('#displayQuestion').append(trHTML);  
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
  
  </script>
</head>
<body>
<div class="panel panel-success">
  <div class="panel-heading">Add Tags to Questions</div>
  <div class="panel-body">
  <form>
<input type="text" id="filterCondt" name="filterCondt" size="30"/>
<input type="button" id="filterQues" name="filterQues" value="Filter" class="btn btn-primary" />
<div style="float: right;">
 <a href="javascript:pagination(1)">
<span class="glyphicon glyphicon-step-backward"></span>
 </a>
<label id="pgno"></label>
 <a href="javascript:pagination(2)">
<span class="glyphicon glyphicon-step-forward"></span>
 </a>
</div>

</form>
<table id="displayQuestion" class="table">
</table>
<div class="panel panel-success">
  <div class="panel-heading">Tags of Selected Question:</div>
  <div class="panel-body">
		<div id="tagMngmt">
		</div>
		<input type="text" id="newTags" name="newTags" />
		<input type="button" id="addTags" name="addTags" value="Add" class="btn btn-primary" />
		</div>
	</div>
</div>
</div>
</body>
</html>