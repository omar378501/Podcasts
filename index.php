<?php
include ("./header.php");

session_start();

$do = $_GET["do"];

if ($do == "logout") {
	
	session_destroy();
	header("Location: ./login.html");
	
	
} else {

	if ($_SESSION["access"] == "granted") {
		
		if (isset($_SESSION["enabled"]) AND $_SESSION["enabled"] == 1) {
	
			print ("Bienvenid@ " . $_SESSION["username"] . '</br>');
		
			print ('<a href="./index.php?do=logout">Salir</a>'. "\n");
		
	
		} else {
	
			print ("Usuario deshabilitado");
	
		}
	} else {
	
		header("Location: ./login.html");
	}
	
}

include ("./footer.php");
?>
