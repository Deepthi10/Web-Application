<?php
define ('DB_USER', 'user');
define ('DB_PASSWORD', 'handson1234');
define ('DB_HOST', 'handson-mysql');
define ('DB_NAME', 'quiz');

function distance($lat1, $lon1, $lat2, $lon2, $unit) {

	$theta = $lon1 - $lon2;
	$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
	$dist = acos($dist);
	$dist = rad2deg($dist);
	$miles = $dist * 60 * 1.1515;
	$unit = strtoupper($unit);

	if ($unit == "K") {
		return ($miles * 1.609344);
	} else if ($unit == "N") {
		return ($miles * 0.8684);
	} else {
		return $miles;
	}
}

function getAngle($lat1, $lon1, $lat2, $lon2) {
	//difference in longitudinal coordinates
	$dLon = deg2rad($lon2) - deg2rad($lon1);

	//difference in the phi of latitudinal coordinates
	$dPhi = log(tan(deg2rad($lat2) / 2 + pi() / 4) / tan(deg2rad($lat1) / 2 + pi() / 4));

	//we need to recalculate $dLon if it is greater than pi
	if(abs($dLon) > pi()) {
		if($dLon > 0) {
			$dLon = (2 * pi() - $dLon) * -1;
		}
		else {
			$dLon = 2 * pi() + $dLon;
		}
	}
	//return the angle, normalized
	return (rad2deg(atan2($dLon, $dPhi)) + 360) % 360;
}

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_NAME)
OR die ('Could not connect to MySQL: '.mysql_error());

if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
#echo "Connected successfully";
$deviceid=$_REQUEST["did"];
$lat=$_POST["lat"];
$lon=$_REQUEST["lon"];
$sql="SELECT * from Location_Test where deviceid!=".$deviceid;
$rs=$conn->query($sql);
$count=1;
$pts=array();
if ($rs->num_rows > 0) {
	while($row = $rs->fetch_assoc()) {
			$dist=distance($lat, $lon, $row['lat'], $row['lon'], "K");
			$angle=getAngle($lat, $lon, $row['lat'], $row['lon']);
			if($dist<=1)
			{
					$row['dist']=$dist;
					$row['angle']=$angle;
					$pts['devices'][]=$row;
			}
	}
}
$conn->close();
echo json_encode($pts);
?>