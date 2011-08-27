<?php
include ("./header.php");


$do = $_GET["do"];


$form = '<form enctype="multipart/form-data" action="upload.php" method="POST">'."\n" .
'Selecciona una archivo: <input name="uploaded" type="file" /><br />'. "\n" .
'<input type="submit" value="Subir" /></form>' . "\n"; 

print ($form);

include("./footer.php");

?>
