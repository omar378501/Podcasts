<?php
session_start();

header("Cache-control: private");
if ($_SESSION["access"] == "granted") {
	if ($_SESSION["user_enabled"] != 0) {
		//$user = $_GET["user"];

		print 'Hello '  . $user .  ' </br>';
		print $_SESSION["id"] . ' - ' . $_SESSION["username"] ;
	} else {
		
		Print "Usuario deshabilitado";
	}

} else {
	header("Location: ./login.html");
}

?>
