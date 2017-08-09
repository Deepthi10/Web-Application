<?php 
session_start();
include("connect.php");
            
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
 <style>
.input-group .form-control {
z-index : 0 !important
}

.list-group {
    width: 95%;
    height: 250px;
    overflow: scroll;
}
</style>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script type="text/javascript">
var jsonData=<?php   echo json_encode($rows)?>;
var pgnum=1;
var count=0;
var item=[""];
var quizID='';
var duration='';
var name='';
var points='';
var finalsplitQuiz='';
var optionSplit= '';
var nextSplit= '';
var result;
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
   	//trHTML += "<tr id="+item.quiz_id+"><td style='display:none;'>" + item.quiz_id + "</td><td><div contenteditable><a href='javascript:loadQuizDetails("+item.quiz_id+")'>" + item.name + "</a></div></td><td><div contenteditable>"+item.duration+"</div></td><td><div contenteditable>"+item.possible_points+"</div></td><td><div contenteditable>"+item.status+"</div></td></tr>";
	//trHTML += "<tr id="+item.quiz_id+"><td style='display:none;'>" + item.quiz_id + "</td><td contenteditable='true'><a href='javascript:loadQuizDetails("+item.quiz_id+")'>" + item.name + "</a></td><td contenteditable='true'>"+item.duration+"</td><td contenteditable='true'>"+item.possible_points+"</td><td>"+item.status+"</td></tr>";
    
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
		   item=jsonData.quizzes[i];
		  if(i>=jsonData.quizzes.length)
			  {
			  	
			  }
		  else
			  {
			  trHTML += "<tr id="+item.quiz_id+"><td style='display:none;'>" + item.quiz_id + "</td><td contenteditable='true'><a href='javascript:loadQuizDetails("+item.quiz_id+")'>" + item.name + "</a></td><td contenteditable='true'>"+item.duration+"</td><td contenteditable='true'>"+item.possible_points+"</td><td>"+item.status+"</td></tr>";
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

    $(document).ready(function(){
	   $("#flag").hide();
	   $("input#quizname").keyup(function(){
		    currInput= $(this);
	      
	        $(".resSuggDiv").remove();
	        var strVal= $(this).val().trim();   
			
			if(strVal.length>=2){
				
				$.ajax({
			            type:"GET",
					    url:"/quizapp_web_dev/AutoCompleteQuizName.php?strVal="+strVal,
			            dataType:"text",
			                success:function(data,textStatus,jqXHR){
								 var listGroupDivQ= $("<div class='resSuggDiv'><ul class='list-group'></ul></div>");
						         var liCompQ ="";
						         var result=data.split("|");
						          console.log(result);
								
								  $.each(result,function(index,value){
									  finalsplitQuiz=value.split("-");
									  liCompQ += '<li name= "quizNameSuggList" class="list-group-item quizNameSuggList" id="'+finalsplitQuiz[1]+'">'+finalsplitQuiz[0] +' </li>';
									 //liComp += '<li name= "qtnNameSuggList" class="list-group-item qtnNameSuggList" id="'+finalsplit[1]+'">'+finalsplit[0] +' </li>';
									 console.log(liCompQ);
								  });
							
						       //(bcz json_encode is not working im storing qtns in $arr and seperating using | splitting qtn and id)
                                        if(data!==''){
						                 listGroupDivQ.find("ul").append(liCompQ);
						                 $("body").append(listGroupDivQ);
						                 listGroupDivQ.css({position:'absolute',
							             top:currInput.offset().top+20,
									     left:currInput.offset().left
									      });
										}  
										  
										  $(".quizNameSuggList").click(function(){
											   
											    quizID = this.id;
											   currInput.val($(this).html());
											     $('#quizname').val();
												 //console.log($('#quizname').val());
												 $(".resSuggDiv").remove();
												 
												  $.ajax({
												    type:"GET",
					                                url:"/quizapp_web_dev/getQuizDet.php?quizID="+quizID,
			                                        dataType:"text",
			                                        success:function(data,textStatus,jqXHR){
								                          console.log(quizID);
						                                    result=data.split("|");
														   console.log(result);
														  
														 
															$("form").find(".input-group input").eq(0).val(result[0]);
															  $("form").find(".input-group input").eq(1).val(result[1]);
															    
															
															  //$(this).val("duration");
															  //$(this).val("points");
															  
															  console.log(result[0]);
															  console.log(result[1]);
															  console.log(console.log(result[0]));
														
															 
															 
												    },
											  });
											  
											   $("#Updateid").off().on('click',function(){
												   debugger;
													 
											        $("#quizname").find("input").each(function(){
														
														if($.trim($(this).val()=="")){
															errorPopUp("Please enter the quiz");
															return false;
														}
														});
												
														var formdata = $("#updateform").serializeArray();
														var data ={};
													
	    		                                      $(formdata).each(function(index, obj){
	    		                                         data[obj.name] = obj.value;
	    		                                          });
	    		                                          
														  data["quizid"] = quizID;
														  
														   console.log(data);
														   //console.log(result[0]);
													
													$.post('/'+'quizapp_web_dev/'+'ModifyListofQuizes.php',data,function (data){
	    			                                     if($.trim(data) != "sucess"){
	    				                                 alert(" Updated Successfully");	    				
														 }				    		
	    		                                        });
														$("form").trigger("reset");
									
										            });
										  });
										  
										  
										 
											
							},	
                        error: function( data, textStatus, jqXHR) {
			  		      	  alert("error: some problem!");
			  		      	  //errorPopUp("some problem!");
			  		        }							
			    
				
				});
			
			}
		   
	    });	
		
		
		
	});	

  
    
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
 </a>
  </div></div>

  <div class="panel-body">
<table id="quizTable" class="table">

</table>
</div>
</div>

<form role="form" id="updateform">
 <div class="panel panel-info">
    <div class="panel-heading">Modify Quiz Details
	  </div>
	  <div style="padding-top:20px;">
	     <table id="quizDetTable" class="table">
          <div class="form-group">
           <label class="control-label pull-left" for="quizname">Quiz Name:</label>
             <div class="col-sm-3 col-md-3 col-lg-3">
              <input name="quizname" type ="text" class="form-control" id="quizname" placeholder="Enter Quiz name Here" autocomplete="off" required>
             </div></div>
	        </div>
			</div>
			 <div style="padding-top:25px;">
	         <div class="input-group">
             <label class="control-label col-sm-2" for="duration">Duration:</label>
              <div class="col-sm-10">
			  <div style="padding-left:20px;">
               <input name="duration" type ="text" class="form-control" id="duration" placeholder="Duration" required>
			   </div>
	            </div></div></div>
				
				 <div style="padding-top:10px;">
				 <div class="input-group">
             <label class="control-label col-sm-2" for="points">Points:</label>
              <div class="col-sm-10">
			   <div style="padding-left:20px;">
               <input name="points" type ="text" class="form-control" id="points" placeholder="Points" required>
	            </div></div></div>
			</div>	
				<div style="padding-top:30px;">
				 <div class="form-group">
	              <div class="col-sm-offset-2 col-sm-10">
		          <input class="btn btn-success" name="Submit" id="Updateid" value="Submit" style="height:30px; width:80px"/>
			    </div></div>
			</div>
			
         </table>
 
  </form>
</body>
</html>