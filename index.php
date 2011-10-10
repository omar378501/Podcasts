<?php

include ("./header.php");

session_start();

$do = $_GET["do"];

if ($do == "logout") {
	
	session_destroy();
	header("Location: ./login.html");
	
	
} else {

	header("Location: ./user.php");
	
}

include ("./footer.php");
?>
