<?php

$servername = "localhost";
$user = "root";
$password = "";
$dbname = "infoskjerm";

$conn = new mysqli($servername, $user, $password, $dbname);

if($conn->connect_error){
	die("Connection failed: " . $conn->connect_error);
}

if(isset($_GET["delete"])){
	$conn->query("DELETE FROM bottom WHERE id = " . $_GET["delete"]);
}

if(isset($_POST["submit"]) && isset($_POST["text"])){
	echo("INSERT INTO bottom(`tekst`) VALUES (\"" . $_POST["text"] . "\")");
	$conn->query("INSERT INTO bottom(`tekst`) VALUES (\"" . $_POST["text"] . "\")");
}

?>

<html>
<head>
	<title>Hi!</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link rel="stylesheet" type="text/css" href="editstyle.css">
	
	<script src="editscript.js"></script>
	
</head>

<body>
	<div class="header">
		<div class="logo">HELLO!</div>
		<ul>
			<li><a href="edit.php">Option 1</a></li>
			<li><a href="edit2.php">Option 2</a></li>
			<li><a href="#">Option 3</a></li>
		</ul>
	</div>
	
<div class="content">
	<?php
	$result = $conn->query("SELECT * FROM bottom");
	
	while($row = $result->fetch_assoc()){
		echo "<div class=\"post\">";
		echo "<div class=\"text\">";
		$message = iconv('iso-8859-1', 'ASCII//TRANSLIT', substr($row["tekst"], 0, 40));
		echo htmlentities($message);
		echo "</div>";
		echo "<div class=\"options\"> <a href=\"edit3.php?delete=" . $row["id"] . "\">Slett</a></div>";
		echo "</div>";
	}
	?>
	<div class="button" id="hidden" onClick="showOrHide('input_form')"> Button</div>
		<form action="#" method="post" enctype="multipart/form-data" id="input_form" class="hidden">
			<div class="textformat">Display text: 
				<div class="option" onClick="insertAtCursor('input_area', 'h1')">h1</div>
				<div class="option" onClick="insertAtCursor('input_area', 'h2')">h2</div>
				<div class="option" onClick="insertAtCursor('input_area', 'bold')">B</div>
				<div class="option" onClick="insertAtCursor('input_area', 'center')">center</div>
				<br>
				<textarea cols="40" rows="5" name="text" id="input_area"></textarea><br>
			</div>
			<input type="submit" value="submit" name="submit">
		</form>
</div>
</body>

</html>