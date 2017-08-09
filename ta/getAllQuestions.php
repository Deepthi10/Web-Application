<?php
include ($_SERVER['DOCUMENT_ROOT']."/quizapp_web_dev/services/connect.php");
$conn=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME) or die ('Error connecting to mysql');

 mysqli_select_db($dbname);
 $getQuizquestions= $_REQUEST["type"];
 
 $sql="SELECT q.question, q.question_id, qp.option_id,qp.option FROM question q JOIN question_option qp ON q.question_id = qp.question_id" ;
 $res=mysqli_query($sql);
 //$data=null;
 echo $res;
 
 while($row=mysqli_fetch_assoc($res)){
	 if($row['question_id']) return false;
	 $data[$row['question_id']]['0']=$row['question'];
	 $data[$row['question_id']][$row['option_id']]=$row['option'];
 }

return $data;
mysqli_close ($conn);
?>
