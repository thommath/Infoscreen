<?php

$servername = "localhost";
$user = "root";
$password = "";
$dbname = "infoskjerm";

$conn = new mysqli($servername, $user, $password, $dbname);

if($conn->connect_error){
	die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM config ORDER BY id DESC LIMIT 1")->fetch_assoc();

$right = $conn->query("SELECT * FROM hoyre")->fetch_assoc() != null;
?>

* {
  margin: 0;
  padding: 0;
  color: #FFFFFF;
  font-family: Arial;
  }

.box {
  padding: 10px;
  background-color: rgba(50, 50, 50, 0.6);
  -webkit-border-radius: 5px;
  -moz-border-radius: 5px;
  -ms-border-radius: 5px;
  border-radius: 5px;
  white-space: pre-wrap; }

body {
  width: 100%;
  height: 100%;
  background-image: url("images.jpg"); }
  body .content {
    display: inline-block;
    width: 100%;
    height: 80%;
    overflow: hidden; }
    body .content .left_bar {
      height: 100%;
      width: <?php if($right){echo "70%";}else{echo "100%";}?>;
      display: inline-block;
      float: left; }
      body .content .left_bar .helper {
        margin: 0 auto;
        display: table;
        height: 100%;
        clear: left;
        float: center; }
        body .content .left_bar .helper .holder {
          height: 100%;
          display: table-cell;
          vertical-align: middle; 
          -webkit-transition: opacity 0.5s ease;
             -moz-transition: opacity 0.5s ease;
               -o-transition: opacity 0.5s ease;
                  transition: opacity 0.5s ease; }
          body .content .left_bar .helper .holder .box {
			font-size: 2em;
			owerflow: hidden;
          }
			body .content .left_bar .helper .holder .box img{
				max-width: <?php if($right){echo "70%";}else{echo "100%";}?>;
				
			}
			body .content .left_bar .helper .holder .box h1{
				<?php if($result["skygge"] == 1){echo "text-shadow: 2px 2px #333333";}?>;
			}
		  body .content .left_bar .helper .holder .imagebox{
			owerflow: hidden;
			background-repeat: no-repeat;
			background-size: cover;
		  }
			
    body .content .right_bar {
      height: 100%;
      display: inline-block;
      width: 29%; 
	  <?php if($right){echo "";}else{echo "display:none;";}?>
	  }
      body .content .right_bar .box {
        margin: 50px auto; }
  body .footer {
    width: 100%;
    clear: both;
    height: 20%;
    background-color: rgba(50, 50, 50, 0.6); }
    body .footer .clock {
	  <?php if($result["skygge"] == 1){echo "text-shadow: 2px 2px #333333";}?>;
      display: inline-block;
      width: 20%;
      float: left;
      text-align: center;
      margin: 2% 0 0 0;
      font-size: 3em; }
    body .footer .right_footer {
      display: inline-block;
      width: 80%;
      float: right;
      margin: 2% 0;
      font-size: 1.5em;
      opacity: 1; }
