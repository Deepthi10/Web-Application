<?php

define ('DB_USER', 'user');
define ('DB_PASSWORD', 'handson1234');
define ('DB_HOST', 'handson-mysql');
define ('DB_NAME', 'quiz');


$x=$_REQUEST["posnum"];

$lat1=array(53.331802, 53.331879, 53.332013, 53.332205, 53.332224, 53.332205, 53.332180, 53.332199, 53.332302, 53.332334, 53.332334, 53.332340);
$lon1=array(-6.277840, -6.277454, -6.276756, -6.275780, -6.274525, -6.273709, -6.272604, -6.272336, -6.271778, -6.271456, -6.271188, -6.270780);

$lat2=array(53.330552, 53.330840, 53.331128, 53.331402, 53.331677, 53.331952, 53.332234, 53.332253, 53.332234, 53.332208, 53.332157, 53.331792);
$lon2=array(-6.275297, -6.275265, -6.275254, -6.275221, -6.275219, -6.275208, -6.275229, -6.275390, -6.275637, -6.275916, -6.276109, -6.277847);

$lat3=array(53.332189, 53.332195, 53.332201, 53.332182, 53.332214, 53.332233, 53.332259, 53.332227, 53.332189, 53.332106, 53.331997, 53.331824);
$lon3=array(-6.273062, -6.273352, -6.273663, -6.273910, -6.274296, -6.274714, -6.275218, -6.275626, -6.275980, -6.276216, -6.276817, -6.277600);

$lat4=array(53.333791, 53.333682, 53.333515, 53.333374, 53.333214, 53.333073, 53.332804, 53.332612, 53.332369, 53.332241, 53.332235, 53.332235);
$lon4=array(-6.274982, -6.275046, -6.275100, -6.275164, -6.275207, -6.275239, -6.275271, -6.275260, -6.275217, -6.275045, -6.274466, -6.274466);

$lat5=array(53.332186, 53.332212, 53.332218, 53.332237, 53.332237, 53.332077, 53.331898, 53.331757, 53.331629, 53.331437, 53.331264, 53.331065);
$lon5=array(-6.273401, -6.273970, -6.274431, -6.274914, -6.275193, -6.275172, -6.275161, -6.275161, -6.275193, -6.275214, -6.275203, -6.275246);

$lat6=array(53.331840, 53.331757, 53.331693, 53.331584, 53.331526, 53.331462, 53.331385, 53.331289, 53.331225, 53.331129, 53.331078, 53.331193);
$lon6=array(-6.285031, -6.284602, -6.284312, -6.283947, -6.283690, -6.283400, -6.282982, -6.282521, -6.282092, -6.281534, -6.280922, -6.280257);

$lat7=array(53.332199, 53.332064, 53.331885, 53.331693, 53.331539, 53.331475, 53.331417, 53.331340, 53.331257, 53.331187, 53.331104, 53.331104);
$lon7=array(-6.283272, -6.283401, -6.283498, -6.283573, -6.283648, -6.283412, -6.283047, -6.282693, -6.282264, -6.281867, -6.281384, -6.280740);

$lat8=array(53.331104, 53.330899, 53.331181, 53.331431, 53.331559, 53.331623, 53.331725, 53.331795, 53.331910, 53.332000, 53.332077, 53.332160);
$lon8=array(-6.280740, -6.283937, -6.283819, -6.283722, -6.283733, -6.284023, -6.284463, -6.284817, -6.285214, -6.285643, -6.285986, -6.286383);

$lat9=array(53.331141, 53.331211, 53.331307, 53.331377, 53.331467, 53.331531, 53.331698, 53.331884, 53.332134, 53.332307, 53.332499, 53.332595);
$lon9=array(-6.281555, -6.281973, -6.282467, -6.282950, -6.283390, -6.283637, -6.283562, -6.283476, -6.283347, -6.283208, -6.282972, -6.282757);

$lat10=array(53.331743, 53.331673, 53.331583, 53.331538, 53.331480, 53.331435, 53.331268, 53.331101, 53.331184, 53.331331, 53.331530, 53.331671);
$lon10=array(-6.284645, -6.284312, -6.283947, -6.283700, -6.283410, -6.283099, -6.282241, -6.280793, -6.280278, -6.279752, -6.279065, -6.278378);

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_NAME) OR die ('Could not connect to MySQL: '.mysql_error());
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
//01
	$sql="UPDATE location_test SET lat=".$lat1[$x].",lon=".$lon1[$x]." where deviceid=1";
	echo $sql."<br />";
	if ($conn->query($sql) === TRUE) {
		echo "Record updated successfully";
	} else {
		echo "Error updating record: " . $conn->error;
	}
//02
	$sql="UPDATE location_test SET lat=".$lat2[$x].",lon=".$lon2[$x]." where deviceid=2";
	echo $sql."<br />";
	if ($conn->query($sql) === TRUE) {
		echo "Record updated successfully";
	} else {
		echo "Error updating record: " . $conn->error;
	}
//03
	$sql="UPDATE location_test SET lat=".$lat3[$x].",lon=".$lon3[$x]." where deviceid=3";
	echo $sql."<br />";
	if ($conn->query($sql) === TRUE) {
		echo "Record updated successfully";
	} else {
		echo "Error updating record: " . $conn->error;
	}
//04
	$sql="UPDATE location_test SET lat=".$lat4[$x].",lon=".$lon4[$x]." where deviceid=4";
	echo $sql."<br />";
	if ($conn->query($sql) === TRUE) {
		echo "Record updated successfully";
	} else {
		echo "Error updating record: " . $conn->error;
	}
//05
	$sql="UPDATE location_test SET lat=".$lat5[$x].",lon=".$lon5[$x]." where deviceid=5";
	echo $sql."<br />";
	if ($conn->query($sql) === TRUE) {
		echo "Record updated successfully";
	} else {
		echo "Error updating record: " . $conn->error;
	}
//06
	$sql="UPDATE location_test SET lat=".$lat6[$x].",lon=".$lon6[$x]." where deviceid=6";
	echo $sql."<br />";
	if ($conn->query($sql) === TRUE) {
		echo "Record updated successfully";
	} else {
		echo "Error updating record: " . $conn->error;
	}
//07
	$sql="UPDATE location_test SET lat=".$lat7[$x].",lon=".$lon7[$x]." where deviceid=7";
	echo $sql."<br />";
	if ($conn->query($sql) === TRUE) {
		echo "Record updated successfully";
	} else {
		echo "Error updating record: " . $conn->error;
	}
//08
	$sql="UPDATE location_test SET lat=".$lat8[$x].",lon=".$lon8[$x]." where deviceid=8";
	echo $sql."<br />";
	if ($conn->query($sql) === TRUE) {
		echo "Record updated successfully";
	} else {
		echo "Error updating record: " . $conn->error;
	}
//09
	$sql="UPDATE location_test SET lat=".$lat8[$x].",lon=".$lon8[$x]." where deviceid=9";
	echo $sql."<br />";
	if ($conn->query($sql) === TRUE) {
		echo "Record updated successfully";
	} else {
		echo "Error updating record: " . $conn->error;
	}
//09
	$sql="UPDATE location_test SET lat=".$lat9[$x].",lon=".$lon9[$x]." where deviceid=9";
	echo $sql."<br />";
	if ($conn->query($sql) === TRUE) {
		echo "Record updated successfully";
	} else {
		echo "Error updating record: " . $conn->error;
	}
//10
	$sql="UPDATE location_test SET lat=".$lat10[$x].",lon=".$lon10[$x]." where deviceid=11";
	echo $sql."<br />";
	if ($conn->query($sql) === TRUE) {
		echo "Record updated successfully";
	} else {
		echo "Error updating record: " . $conn->error;
	}
$conn->close();
echo "Hello";

?>

<html>

<body>

<h1>Simulator1</h1>

</body>

</html>