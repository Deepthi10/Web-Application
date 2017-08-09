<?php
session_start ();
$dbHost = "handson-mysql"; // MySQL Server
$dbUser = "bkongara"; // MySQL Username
$dbPass = "Mamatha5!"; // MySQL Passwordf
$dbname = "apns"; // MySQL Database Name
$DB_TBLName = "ModulesResults"; // MySQL Table Name
$ACT=$_REQUEST['UserAct'];

//echo $ACT;
$Conn  = mysql_connect($dbHost,$dbUser,$dbPass) or die('Error connecting to mysql');
if ($Conn) {
	//echo "connected";
}
mysql_select_db($dbname) or die ( 'Error connecting to db' );


$score_array = array();

$return_arr["UserDetails"] = array();


//userid and moduleid
$userid = $_POST['user_id'];
$mid = $_POST['moduleid'];
$correct=0;

// count total questions in the module

$totalquestions="select count(question_Id) as total from module_questions where m_Id =$mid";
$result = mysql_query($totalquestions);
while($row = mysql_fetch_assoc($result)){
	$total = $row['total'];	
}

foreach ($_POST as $key => $value) {
  if( $key!="user_id" || $key!="moduleid" ){		
	$sqlcheckifcorrect="select flag from module_qoption where flag=1 and q_id =$key and (opt_Id = '".$value."' or answer_option='".$value."')";
	//echo $sqlcheckifcorrect;
	$result = mysql_query($sqlcheckifcorrect);	
	if(mysql_num_rows($result)>0){
		$correct++;
	}
	// insert incorrect questions into db
	else{
		
		$firstattemptwrong="select Module_Id , PreceptorID from Incorrect_Answers_Module where PreceptorID=$userid and Module_Id=$mid";
		$result = mysql_query($firstattemptwrong);
		if(mysql_num_rows($result)==0){
			$sqlincorrectquestions="INSERT INTO `apns`.`Incorrect_Answers_Module` (`ID`, `PreceptorID`, `Module_Id`, `Question_ID`, `Date`)
			VALUES (NULL, $userid, $mid , $key , now())";
			mysql_query($sqlincorrectquestions);	
		}	
	//echo $sqlincorrectquestions;				
  }
   }
}
$percent = round(($correct/$total)*100);
//echo $percent;


// insertion of  scores //

$allscore = "select u_id from Allmodule_scores where u_id=$userid and m_id=$mid";
//echo $allscore;
$result = mysql_query($allscore);

if(mysql_num_rows($result)==0){
	$sqlincorrectquestions="INSERT INTO `apns`.`Allmodule_scores` (`s_id`, `u_id`, `score`, `m_id`, `attempt_no`, `date_created`)
	VALUES ('', $userid, $percent, $mid, 1 , now())";
	mysql_query($sqlincorrectquestions);
	//echo $sqlincorrectquestions;
}

while($row = mysql_fetch_assoc($result)){
	$uid = $row["u_id"];
	
	if(mysql_num_rows($result)>0){
		
		$attemptnum = "select attempt_no from Allmodule_scores where u_id=$userid and m_id=$mid order by attempt_no desc limit 1";
		$result = mysql_query($attemptnum);
		
		while($row = mysql_fetch_assoc($result)){
			$uid = $row["attempt_no"];
			$sqlincorrectquestions="INSERT INTO `apns`.`Allmodule_scores` (`s_id`, `u_id`, `score`, `m_id`, `attempt_no`, `date_created`)
			VALUES ('', $userid, $percent, $mid, $uid+1 , now())";
			mysql_query($sqlincorrectquestions);
		}
		//echo "attnumber". $uid;
		//echo $sqlincorrectquestions;
	}		
}

// if inserted then call the below function //
// get max score  from allmodule //

$findhighestscore ="SELECT max(score) as score FROM `Allmodule_scores` where u_id=$userid and m_id=$mid";
$result = mysql_query($findhighestscore);

// update finalscore table with highest score of the user
while($row=mysql_fetch_assoc($result)){
	$finalscore = $row["score"];	
	
	$checkinfinal = "select UserID ,Module_Id from ModuleFinalScore where UserID = $userid and Module_Id=$mid"; 
	$result = mysql_query($checkinfinal);
	//echo $checkinfinal;
	//echo mysql_num_rows($result);
	if(mysql_num_rows($result)==0){
		$updatefinalscore ="INSERT INTO `apns`.`ModuleFinalScore` (`FinalScoreId`, `Module_Id`, `UserID`, `Finalscore`, `Is_Approved`, `Date`) VALUES
		(NULL, $mid, $userid, $finalscore, '', now())";
		mysql_query($updatefinalscore);
	}
	while($row = mysql_fetch_assoc($result)){
		$updatefinalscore ="update   `apns`.`ModuleFinalScore` set Finalscore =$finalscore where UserID = $userid and Module_Id=$mid";		
		mysql_query($updatefinalscore);
	}
	
	
	//echo $updatefinalscore;
}


$score_array['score'] = $percent;

header('Content-Type: application/json');
echo json_encode($score_array);
mysql_close();


/* echo <<<EOL
<script type="text/javascript">
   alert('Your score is '+$percent +"  Passing score is 80");
   		history.back();
</script>
EOL; */

?>