<?php

include ("./header.php");
include ("./inc/config.php");

session_start();

$id = $_GET["id"];

if ($_SESSION["access"] == "granted") {
			
		if (isset($_SESSION["enabled"]) AND $_SESSION["enabled"] == 1) {
			
		/* Establecer la conexion a la base de datos */
		$server = mysql_connect($db_server, $db_user, $db_pass); 
		if (!$server) die(mysql_error());
		mysql_select_db($db_name);
  
		/* Sentencia: buscar en la base de datos los cursos en los cuales participa,
		 * y si es profesor, el usuario en cuestion */
		$query_file_list = sprintf("SELECT file.id,file.filename,file.description
			FROM file,file_course
			WHERE file_course.course_id='%s' AND file.id = file_course.file_id 
			ORDER BY course_id",
			mysql_real_escape_string($id));
		/* Hacer la consulta */
		$result_file_list = mysql_query($query_file_list);
		
		/* Control de ejecucion */
		if (!$result_file_list) {
			$message  = 'Sentencia invalida: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query_file_list;
			die($message);
		}
		
		echo "<b>Archivos del curso:</b><br>\n";
		
		while ($row = mysql_fetch_assoc($result_file_list)) {
			
			echo $row["id"] . ": " .  $row["filename"] . "<br>\n";
		}
		
		} else {
	
			print ("Usuario deshabilitado");
	
		}

} else {
		
		header("Location: ./login.html");
}

include ("./footer.php");

?>
