<?php 
session_unset();
session_destroy();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Login</title>
 <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<body>
<div class="panel panel-default" style="width: 500px;height: 300px;">
<div class="panel-heading">Login</div>
<div class="panel-body">
<form role="form" style="width: 400px;height: 200px;vertical-align: middle;" action="LandingPage.php" method="post">
  <div class="form-group">
    <label for="email">Midas-id:</label>
    <input type="text" class="form-control" id="midasid" name="midasid">
  </div>
  <div class="form-group">
    <label for="pwd">Password:</label>
    <input type="password" class="form-control" id="pwd" name="pwd">
  </div>
  <div class="checkbox">
    <label><input type="checkbox">Remember me</label>
  </div>
  <button type="submit" class="btn btn-default">Submit</button>
  <a href="#" class="btn btn-info" role="button">Register</a>
</form>
</div>
</div>
</body>
</html>