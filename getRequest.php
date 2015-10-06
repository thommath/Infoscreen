<?php
function encode($arr){
/*	if(isset($arr['tekst'])){
		echo $arr['tekst'];
		$arr['tekst'] = utf8_encode($arr['tekst']);
	}*/
	if(isset($arr)){
		$array = Array();
		if(is_array($arr)){
			foreach($arr as $a){
				$array[] = utf8_encode($a);
			}
		}else{
			$array = utf8_encode($arr);
		}
//		echo $arr;
		
	}
	return $array;
}
function printjs($array){
	if(is_array($array)){
		$arr = Array();
		foreach($array as $a){
			$arr[] = encode($a);
		}
		
	}else{
		$arr[] = encode($array);
	}
//	echo (print_r($array));
//	echo (print_r($arr));
	echo json_encode($arr);
}
$servername = "localhost";
$user = "root";
$password = "";
$dbname = "infoskjerm";

$conn = new mysqli($servername, $user, $password, $dbname);

if($conn->connect_error){
	die("Connection failed: " . $conn->connect_error);
}
if(isset($_GET["nr"]) && $_GET["nr"] == 0){
	$sql = "SELECT * FROM nyhet";
}if(isset($_GET["nr"]) && $_GET["nr"] == 1){
	$sql = "SELECT * FROM hoyre";
}if(isset($_GET["nr"]) && $_GET["nr"] == 2){
	$sql = "SELECT * FROM bottom";
}if(isset($_GET["nr"]) && $_GET["nr"] == 3){
	$sql = "SELECT id FROM config ORDER BY id DESC LIMIT 1";
}
$result = $conn->query($sql);

$arr = Array();
if($result != null){
while($row = $result->fetch_assoc()){
	if(isset($_GET["nr"]) && $_GET["nr"] == 3){
		array_push($arr, $row["id"]);
	}else if(isset($row["image"]) && isset($row["imageConfig"])){
		array_push($arr, [$row["tekst"], $row["image"], $row["imageConfig"], $row["time"]]);
	}else if(isset($row["time"])){
		array_push($arr, [$row["tekst"], "", "", $row["time"]]);
	}else{
		array_push($arr, $row["tekst"]);
	}
}
}else{
	echo $sql;
}

echo printjs($arr);

?>