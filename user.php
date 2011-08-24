<?php
session_start();

header("Cache-control: private");
if ($_SESSION["access"] == "granted") {
	if (isset($_SESSION["enabled"]) AND $_SESSION["enabled"] == 1) {

		print 'Hello '  . $user .  ' </br>';
		print $_SESSION["id"] . ' - ' . $_SESSION["username"] . ' - ' . $_SESSION["enabled"] ;

	} else {
		
		Print "Usuario deshabilitado";
		session_destroy ();
	}

} else {
	
	header("Location: ./login.html");
	session_destroy ();
	
}

?>
