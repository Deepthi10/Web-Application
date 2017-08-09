<?php
$name= $_POST["uname"];
$image= $_POST["image"];
$decodeImage = base64_decode("$image");
file_put_contents("/var/www/html/images/profile/" .$name. ".jpg", $decodeImage);

?>