<!DOCTYPE html >
<html>
<head>
<!-- <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"> -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Delete Quiz</title>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script type="text/javascript">
  var quizQtnID='';
  var quizID='';
  var finalsplitQuiz = '';
  var finalsplit= '';
	$(document).ready(function(){
	   $("#flag").hide();
	   $("input#quizname").keyup(function(){
		    currInput= $(this);
	        //var curRowParent=$(this).parents("tr");
	        $(".resSuggDiv").remove();
	        var strVal= $(this).val().trim();   
			
			if(strVal.length>=2){
				debugger;
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
									   $("form").find(".input-group input").eq(index).val(finalsplitQuiz[0]);
									  $("form").find(".input-group input").eq(index).attr("quizid",finalsplitQuiz[1]);
									 console.log(liCompQ);
								  });
							
						       //(bcz json_encode is not working im storing qtns in $arr and seperating using | splitting qtn and id)

						                 listGroupDivQ.find("ul").append(liCompQ);
						                 $("body").append(listGroupDivQ);
						                 listGroupDivQ.css({position:'absolute',
							             top:currInput.offset().top+20,
									     left:currInput.offset().left
									      });
										  
										  
										  $(".quizNameSuggList").click(function(){
											   
											    quizID = this.id;
											   currInput.val($(this).html());
											     $('#quizname').val();
												 //console.log($('#quizname').val());
												 $(".resSuggDiv").remove();
										  });
											
							},	
                        error: function( data, textStatus, jqXHR) {
			  		      	  alert("error: some problem!");
			  		      	  //errorPopUp("some problem!");
			  		        }							
			    
				
				});
			
			}
		   
	    });	
       
	         $("input#questionname").keyup(function(){
		    currInputQtn= $(this);
	        //var curRowParent=$(this).parents("tr");
	        $(".resSuggDiv").remove();
	        var strVal= $(this).val().trim();   
			
			if(strVal.length>=3){
				debugger;
				$.ajax({
			            type:"GET",
					    url:"/quizapp_web_dev/autoCompleteQuestion.php?strVal="+strVal,
			            dataType:"text",
			                success:function(data,textStatus,jqXHR){
								 var listGroupDiv= $("<div class='resSuggDiv'><ul class='list-group'></ul></div>");
						         var liComp ="";
						         var result=data.split("|");
						          console.log(result);
								
								  $.each(result,function(index,value){
									  finalsplit=value.split("-");
									  liComp += '<li name= "quizQtnNameSuggList" class="list-group-item quizQtnNameSuggList" id="'+finalsplit[1]+'">'+finalsplit[0] +' </li>';
									   $("form").find(".input-group input").eq(index).val(finalsplit[0]);
									  $("form").find(".input-group input").eq(index).attr("quizQtnid",finalsplit[1]);
									 console.log(liComp);
								  });
							
						       //(bcz json_encode is not working im storing qtns in $arr and seperating using | splitting qtn and id)

						                 listGroupDiv.find("ul").append(liComp);
						                 $("body").append(listGroupDiv);
						                 listGroupDiv.css({position:'absolute',
							             top:currInputQtn.offset().top+20,
									     left:currInputQtn.offset().left
									      });
										  
										  
										  $(".quizQtnNameSuggList").click(function(){
											   
											    quizQtnID = this.id;
											   currInputQtn.val($(this).html());
											     $('#questionname').val();
												 //console.log($('#questionname').val());
												 $(".resSuggDiv").remove();
										  });
										  
										     $("#DeleteQuizid").click(function(){
													  debugger;
											        /*$("#questionname").find("input").each(function(){
														
														if($.trim($(this).val()=="")){
															errorPopUp("Please enter the question");
															return false;
														}
														});
														var formdata = $("#deleteQuizform").serializeArray();
														var data ={};
														$(formdata).each(function(index, obj){
	    		                                         data[obj.name] = obj.value;
	    		                                          });
														  data["quizQtnid"] = quizQtnID;
														   console.log(data);
													
													$.post('/'+'quizapp_web_dev/'+'DeleteQtnfrmQuiz.php',data,function (data){
	    			                                     if($.trim(data) != "sucess"){
	    				                                 alert(" Deleted Successfully");	    				
														 }				    		
	    		                                        });
									                    $("form").trigger("reset");*/
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
 <body>
 <form role="form" id="deleteQuizform">
 <div class="container">
 
 <div class="panel panel-success">
 <div class="panel-heading">Enter the Quiz to be deleted</div>
  <div class="panel-body">

  
    <div class="form-group">
      <label class="control-label col-sm-2" for="quizname">Quiz:</label>
      <div class="col-sm-10">
        <input name="quizname" type ="text" class="form-control" id="quizname" placeholder="Enter the quiz name to be deleted" required>
      </div>
	  </div>
	  </div></div>
	  
	   <div class="form-group">
	      <div class="col-sm-offset-2 col-sm-10">
		 <input class="btn btn-success" name="Delete" id="DeleteQuizid" value="Delete" style="height:30px; width:80px"/> <br/>
			</div>
			</div>
			<div style="padding-top:100px;">
			 <div class="panel panel-success">
             <div class="panel-heading">Enter the Quiz Question to be deleted</div>
             <div class="panel-body">

  
         <div class="form-group">
          <label class="control-label col-sm-2" for="questionname">Question:</label>
         <div class="col-sm-10">
         <input name="questionname" type ="text" class="form-control" id="questionname" placeholder="Enter the Quiz Questionto be deleted" required>
         </div>
	     </div>
	      </div></div>
	  
	   <div class="form-group">
	      <div class="col-sm-offset-2 col-sm-10">
		 <input class="btn btn-success" name="Delete" id="DeleteQtnid" value="Delete" style="height:30px; width:80px"/>
			</div>
			</div>
   </div>
  </div>
  </form>
 </body>
  </html>

  