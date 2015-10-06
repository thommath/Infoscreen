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
	$conn->query("DELETE FROM nyhet WHERE id = " . $_GET["delete"]);
}

if(isset($_POST["submit"]) && isset($_POST["text"])){
	if(isset($_FILES["fileToUpload"])){
		$target_dir = "uploads/";
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			if($check !== false) {
				echo "File is an image - " . $check["mime"] . ".";
				$uploadOk = 1;
			} else {
				echo "File is not an image.";
				$uploadOk = 0;
			}
		}
		// Check if file already exists
		if (file_exists($target_file)) {
			echo "Sorry, file already exists.";
			$uploadOk = 0;
		}
		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 1000000) {
			echo "Sorry, your file is too large.";
			$uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
			echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			$uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				$conn->query("INSERT INTO nyhet(`tekst`, `image`, `imageConfig`) VALUES (\"" . $_POST["text"] . "\", \"" . $target_file . "\", \"" . $_POST["imageConfig"] . "\")");
				echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
			} else {
				echo "Sorry, there was an error uploading your file.";
			}
		}
	}else{
		echo "LOL";
		$conn->query("INSERT INTO nyhet(`tekst`, `image`, `imageConfig`) VALUES (\"" . $_POST["text"] . "\", null, \"" . $_POST["imageConfig"] . "\")");
	}
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
			<li><a href="#">Option 1</a></li>
			<li><a href="edit2.php">Option 2</a></li>
			<li><a href="edit3.php">Option 3</a></li>
			<li><a href="edit4.php">Option 4</a></li>
		</ul>
	</div>
	
<div class="content">
	<?php
	$result = $conn->query("SELECT * FROM nyhet");
	
	while($row = $result->fetch_assoc()){
		echo "<div class=\"post\">";
		echo "<div class=\"text\">";
		$message = iconv('iso-8859-1', 'ASCII//TRANSLIT', substr($row["tekst"], 0, 40));
		echo htmlentities($message);
		echo "</div>";
		echo "<div class=\"options\"> <a href=\"edit.php?delete=" . $row["id"] . "\">Slett</a></div>";
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
			Select image to upload:
			<input type="file" name="fileToUpload" id="fileToUpload" value="Select file"><br>
			<input type="radio" name="imageConfig" value="0">Bruk i tekst<br>
			<input type="radio" name="imageConfig" value="1" checked="checked">Sett som bakgrunn<br>
			<input type="radio" name="imageConfig" value="2">Bare bruk bilde (teksten blir beskrivelse for deg)<br>
			<input type="submit" value="sumbit" name="submit">
		</form>
</div>
</body>

</html>