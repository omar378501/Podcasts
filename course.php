<?php
session_start();

$id = $_GET["id"];

if (isset($id)) {


	if ($_SESSION["access"] == "granted") {
			
		if (isset($_SESSION["enabled"]) AND $_SESSION["enabled"] == 1) {
	
			print ("Curso " . $id . '</br>');
		
		
		} else {
	
			print ("Usuario deshabilitado");
	
		}
	} else {
		
		header("Location: ./login.html");
	}
} else {

	print ("Todos");

}
?>
