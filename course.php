<?php

include ("./header.php");

session_start();

$id = $_GET["id"];

if ($_SESSION["access"] == "granted") {
			
		if (isset($_SESSION["enabled"]) AND $_SESSION["enabled"] == 1) {
			
			if (isset($id)) {
	
				print ("Curso " . $id . '</br>');
		
			} else {

				print ("Todos");

			}

		
		} else {
	
			print ("Usuario deshabilitado");
	
		}

} else {
		
		header("Location: ./login.html");
}

include ("./footer.php");

?>
