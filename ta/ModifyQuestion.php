<!DOCTYPE html >
<html>
<head>
<!-- <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"> -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Update Question</title>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<style>
.input-group .form-control {
z-index : 0 !important
}

.list-group {
    width: 95%;
    height: 250px;
    overflow: auto;
}
</style>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script type="text/javascript">
  var optionId= '';
  var finalsplit = '';
  var optionSplit= '';
  var qtnID='';
  var optid='';
	$(document).ready(function(){
	   $("#flag").hide();
	     debugger;
		 $("input#qname").keyup(function(){
	           currInput= $(this);
	           //var curRowParent=$(this).parents("tr");
	           $(".resSuggDiv").remove();
	           var strVal= $(this).val().trim();
	       
	         if(strVal.length>=3){
		        //alert("pressed");
		         $.ajax({
			            type:"GET",
					    url:"/quizapp_web_dev/autoCompleteQuestion.php?strVal="+strVal,
			            dataType:"text",
			                success:function(data,textStatus,jqXHR){
								 var listGroupDiv= $("<div class='resSuggDiv'><ul class='list-group'></ul></div>");
						         var liComp ="";
						         var result=data.split("|");
						          //console.log(result);
								
								  $.each(result,function(index,value){
									  finalsplit=value.split("-");
									  liComp += '<li name= "qtnNameSuggList" class="list-group-item qtnNameSuggList" id="'+finalsplit[1]+'">'+finalsplit[0] +' </li>';
									  
								  });
							
						       //(bcz json_encode is not working im storing qtns in $arr and seperating using | splitting qtn and id)
                                      
									   
									   if(data!==''){
						                 listGroupDiv.find("ul").append(liComp);
						                 $("body").append(listGroupDiv);
						                 listGroupDiv.css({position:'fixed',
							             top:currInput.offset().top+20,
									     left:currInput.offset().left,
									      });
									   }
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
											     
												  $("#Updateid").off().on('click',function(){
													
											        $("#qname").find("input").each(function(){
														
														if($.trim($(this).val()=="")){
															errorPopUp("Please enter the question");
															return false;
														}
														});
												
														var formdata = $("#updateform").serializeArray();
														var data ={};
														$(formdata).each(function(index, obj){
	    		                                         data[obj.name] = obj.value;
	    		                                          });
														  data["qtnid"] = qtnID;
														  
														  $(".optionIp").each(function(index, obj){
															  data["optid"+(index+1)] = $(obj).eq(0).attr("optid");
														  });
														  
														   console.log(data);
													
													 $.post('/'+'quizapp_web_dev/'+'UpdateAll.php',data,function (data){
	    			                                     if($.trim(data) != "success"){
	    				                                 alert("Updated Successfully");	    				
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
 <body>
 <form role="form" id="updateform">
 <div class="container">
 
 <div class="panel panel-success">
  <div class="panel-heading">Modify a Question in the Database</div>
  <div class="panel-body">

  
      <div class="form-group">
        <label class="control-label col-sm-2" for="qname">Question:</label>
        <div class="col-sm-10">
        <input name="qname" type ="text" class="form-control" id="qname" placeholder="Update Question Here" autocomplete="off" required>
      </div>
	  </div>
	  </div></div>
	  
	  <div class="panel panel-success">
      <div class="panel-heading">Answer Options </div>
      <div class="panel-body"> 
  
   <!--   <div class="form-inline" role="form">     --> 
   
      <div class="input-group">
        <span class="input-group-btn">
        <button class="btn btn-success" type="button" name="opt1" id="opt1">Option1</button>
	   </span>
	  <input type="text" name="one" class="form-control optionIp" placeholder="option1" id="opt1">
	 </div>
    
	  <div class="input-group">
	   <span class="input-group-btn">
	    <button class="btn btn-success" type="button" name="opt2" id="opt2">Option2</button>
	   </span>
	   <input type="text" name="two" class="form-control optionIp" placeholder="option2" id="opt2">
	  </div>
	  
	    <div class="input-group">
	     <span class="input-group-btn">
	       <button class="btn btn-success" type="form-control" name="opt3" id="opt3">Option3</button>
		 </span>
		  <input type="text" name="three" class="form-control optionIp" placeholder="option3" id="opt3">
		</div>
		
		<div class="input-group">
		  <span class="input-group-btn">
	      <button class="btn btn-success" type="form-control" name="opt4" id="opt4">Option4</button>
		 </span>
		 <input type="text" name="four" class="form-control optionIp" placeholder="option4" id="opt4">
		</div>
  
	   <div style="padding-top:20px;">
	      <div class="form-group">
	       <div class="col-sm-offset-2 col-sm-10">
		    <button class="btn btn-success" type="Submit" id="Updateid" value="Submit" style="height:30px; width:80px">Submit</button>
			</div>
	      </div></div>
   
  </div></div>
  </div>
  </form>
 </body>
  </html>

  