<?php
?>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript">
var myVar = setInterval(myTimer, 5000);
var i=0;
function myTimer() {
	 $.ajax({
		    type: "GET",
		    url: "http://qav2.cs.odu.edu/quizapp_web_dev/simulateCars.php?posnum="+i,
		    data: "",
		    dataType: "json",
		    success: function( data, textStatus, jqXHR) {
				alert("success");
			    }
		});
	i=i +1;
	if(i==12)
	{
		clearInterval(myVar);
		}
}
</script>
</head>
<body>
</body>
</html>
