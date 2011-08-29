<br>
<b>Menu:</b><br>
<?php
if ($_SESSION["access"] == "granted") {
			
	if (isset($_SESSION["enabled"]) AND $_SESSION["enabled"] == 1) {
		
		print ('<a href="./upload.php?do=form">Subir</a>'. "<br>\n");
		print ('<a href="./user.php">Inicio</a>'. "<br>\n");
		print ('<a href="./index.php?do=logout">Salir</a>'. "<br>\n");
		
	}
}
?>
</body>
</html>
