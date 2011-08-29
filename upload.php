<?php
session_start();

include ("./header.php");
include ("./config.php");
$do = $_GET["do"];

if ($_SESSION["access"] == "granted") {
			
		if (isset($_SESSION["enabled"]) AND $_SESSION["enabled"] == 1) {
			
			switch ($do) {
				case "form":
					$form = '<form enctype="multipart/form-data" action="upload.php?do=upload" method="POST">'."\n" .
							'Selecciona una archivo: <input name="uploaded" type="file" /><br>'. "\n" .
							'<input type="submit" value="Subir" /></form>' . "\n"; 
						
					echo $form;
					break;
				case "upload":

					$final_path = $target_path . $_SESSION["id"] . '-' . sha1(basename( $_FILES['uploaded']['name']));
					
					$counter = 0;
					if (file_exists($final_path)) {
						
						while (file_exists($final_path)) {
							$final_path = $target_path . $_SESSION["id"] . '-' . sha1(basename( $_FILES['uploaded']['name'])) . '-' . $counter;
							$counter += 1;
						}
						
					}
					 
					if(move_uploaded_file($_FILES['uploaded']['tmp_name'], $final_path)) {

						/* Establecer la conexion a la base de datos */
						$server = mysql_connect($db_server, $db_user, $db_pass); 
						if (!$server) die(mysql_error());
						mysql_select_db($db_name);
						  
						/* Sentencia de SQL para buscar en la base de datos */
						$query_insert_file = sprintf("INSERT INTO file (filename,path) VALUE ('%s','%s')",
							mysql_real_escape_string($_FILES['uploaded']['name']),
							mysql_real_escape_string($final_path));
						
						$query_get_file_id = sprintf("SELECT id FROM file WHERE filename='%s' AND path='%s'",
							mysql_real_escape_string($_FILES['uploaded']['name']),
							mysql_real_escape_string($final_path));
							
						/* Hacer la consultas de insercion de datos*/
						$result_insert_file = mysql_query($query_insert_file);
						/* control de ejecucion */
						if (!$result_insert_file) {
						    $message  = 'Sentencia invalida: ' . mysql_error() . "\n";
						    $message .= 'Whole query: ' . $query_insert_file;
						    die($message);
						}
						
						/* Hacer las consulta de recibir el id del archivo recientemente creado */
						$result_get_id = mysql_query($query_get_file_id);
						/* control de ejecucion */
						if (!$result_get_id) {
						    $message  = 'Sentencia invalida: ' . mysql_error() . "\n";
						    $message .= 'Whole query: ' . $query_get_file_id;
						    die($message);
						}

						if (mysql_fetch_row($result_get_id)) {
							/* Acceso Permitido */
							$result = mysql_query($query_get_file_id);
						
							$row = mysql_fetch_row($result);
							
							$file_id = $row[0];
							
						}
						
						$query_owner = sprintf("INSERT INTO user_file (user_id,file_id) VALUE ('%s','%s')",
							mysql_real_escape_string($_SESSION["id"]),
							mysql_real_escape_string($file_id));
						
						/* Hacer las insercion de relacion archivo usuario */
						$result_owner = mysql_query($query_owner);
						/* control de ejecucion */
						if (!$result_get_id) {
						    $message  = 'Sentencia invalida: ' . mysql_error() . "\n";
						    $message .= 'Whole query: ' . $query_owner;
						    die($message);
						}
						
						mysql_close($server);
						
						echo "El archivo ". $_FILES['uploaded']['name'] . " ha sido agregado exitosamente <br>\n";
						echo "<a href=\"./file.php?do=edit&id=" . $file_id .">Editar propiedades</a>";
						

					} else{
						
						echo "Un error ha ocurrido, por favor intente de nuevo";
					}		

					break;
			}
			
		}


} else {
		
		header("Location: ./login.html");
}

include ("./footer.php");

?>
