<!DOCTYPE html >
<html>
<head>
<!-- <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"> -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Update Question</title>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script type="text/javascript">

	$(document).ready(function(){
	  $("input#qname").keyup(function(){
	           currInput= $(this);
	          
	           $(".resSuggDiv").remove();
	           var strVal= $(this).val().trim();
	       
	         if(strVal.length>=2){
		       
		         $.ajax({
			            type:"GET",
					    url:"/quizapp_web_dev/autoCompleteTag.php?strVal="+strVal,
			            dataType:"text",
			                success:function(data,textStatus,jqXHR){
								 var listGroupDiv= $("<div class='resSuggDiv'><ul class='list-group'></ul></div>");
						         var liComp ="";
						         var result=data.split("|");
						          //console.log(result);
								
								  $.each(result,function(index,value){
									  finalsplit=value.split("-");
									  liComp += '<li name= "qtnNameSuggList" class="list-group-item qtnNameSuggList" id="'+finalsplit[1]+'">'+finalsplit[0] +' </li>';
									   $("form").find(".input-group input").eq(index).val(finalsplit[0]);
									  $("form").find(".input-group input").eq(index).attr("qtnid",finalsplit[1]);
									 // console.log(liComp);
								  });
							
						       //(bcz json_encode is not working im storing qtns in $arr and seperating using | splitting qtn and id)

						                 listGroupDiv.find("ul").append(liComp);
						                 $("body").append(listGroupDiv);
						                 listGroupDiv.css({position:'absolute',
							             top:currInput.offset().top+20,
									     left:currInput.offset().left
									      });
										  
										   $(".qtnNameSuggList").click(function(){
											   
											    qtnID = this.id;
											   
											   currInput.val($(this).html());
											     $('#qname').val();
												 console.log($('#qname').val());
												 $(".resSuggDiv").remove();
												 
												  $.ajax({
												    type:"GET",
					                                url:"/quizapp_web_dev/getAllOptions.php?qtnID="+qtnID,
			                                        dataType:"text",
			                                        success:function(data,textStatus,jqXHR){
								                          console.log(qtnID);
						                                   var result=data.split("|");
														   console.log(result);
														  
														    $.each(result,function(index,value){
									                          optionSplit=value.split("-");
															  
															  $("form").find(".input-group input").eq(index).val(optionSplit[0]);
															 $("form").find(".input-group input").eq(index).attr("optid",optionSplit[1]);
															  $(this).attr("optid");
															  
															  console.log(optionSplit[0]);
															  console.log(optionSplit[1]);
															 console.log(optid);
															  
															  
								                            });
									
												    },
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
 <body>
 <form role="form" id="updateform">
 <div class="container">
 
 <div class="panel panel-success">
  <div class="panel-heading">Display Question based on the Tag enterd</div>
  <div class="panel-body">

  
      <div class="form-group">
        <label class="control-label col-sm-2" for="qname">Question:</label>
        <div class="col-sm-10">
        <input name="qname" type ="text" class="form-control" id="qname" placeholder="Enter the tags Here" required>
      </div>
	  </div>
	  </div></div>
	  
	  <div class="panel panel-success">
      <div class="panel-heading">List of Questions</div>
      <div class="panel-body"> 
  
   <!--   <div class="form-inline" role="form">     --> 
   
      
   
  </div></div>
  </div>
  </form>
 </body>
  </html>

  