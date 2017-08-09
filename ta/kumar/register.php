<?php
// Include confi.php
//$id=0;
 
if($_SERVER['REQUEST_METHOD'] == "POST"){
 // Get data

 // $email =mysql_real_escape_string($_POST['email']);//data from the text field
 // $password = mysql_real_escape_string($_POST['pwd']);//data from the text field
 // $createdDate =mysql_real_escape_string($_POST['createdon']);//data from the text field
 // $firstname = mysql_real_escape_string($_POST['firstname']);//data from the text field
// $lastname= mysql_real_escape_string($_POST['lastname']);//data from the text field
// $age=mysql_real_escape_string($_POST['age']);//data from the text field//
// $gender =mysql_real_escape_string($_POST['gender']);//data from the text field
// $race = mysql_real_escape_string($_POST['race']);//data from the text field
 // $married = mysql_real_escape_string($_POST['maritalstatus']);//data from the text field
  

 $email=$_REQUEST['email'];
 $password=$_REQUEST['pwd'];

 $firstname=$_REQUEST['firstname'];
 $lastname=$_REQUEST['lastname'];
 $age=$_REQUEST['age'];
 $gender=$_REQUEST['gender'];
 $race=$_REQUEST['race'];
 $married=$_REQUEST['maritalstatus'];
  $createdDate=$_REQUEST['createdon'];
  
  //$id=$id+1;
  //echo $id;
 
 echo $email;
 // Insert data into data base
 $sql = "INSERT INTO mra_register(firstname,lastname,email,pwd,,createdon,age,gender,race,maritalstatus) VALUES ('$firstname','$lastname',$email', '$password','$createdDate','$age','$gender','$race','$married')";
 $stid  =oci_parse($conn,$sql);
oci_execute($stid);
 if($stid){
 $json = array("status" => 1, "msg" => "Done User added!");
 }else{
 $json = array("status" => 0, "msg" => "Error adding user!");
 }
}else{
 $json = array("status" => 0, "msg" => "Request method not accepted");
}
 
@mysql_close($conn);
 
/* Output header */
 header('Content-type: application/json');
 echo json_encode($json);
 ?>