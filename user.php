<?php 
include ("./header.php");
?>

<?php
include ("./inc/config.php");
session_start();

header("Cache-control: private");
if ($_SESSION["access"] == "granted") {
	if (isset($_SESSION["enabled"]) AND $_SESSION["enabled"] == 1) {
		/* Establecer la conexion a la base de datos */
		$server = mysql_connect($db_server, $db_user, $db_pass); 
		if (!$server) die(mysql_error());
		mysql_select_db($db_name);
  
		/* Sentencia: buscar en la base de datos los cursos en los cuales participa,
		 * y si es profesor, el usuario en cuestion */
		$query_course = sprintf("SELECT user_course.course_id,user_course.is_prof,course.name, course.description
			FROM user_course,course 
			WHERE user_course.user_id='%s' AND course.id = user_course.course_id 
			ORDER BY course_id",
			mysql_real_escape_string($_SESSION["id"]));
		/* Hacer la consulta */
		$result_course = mysql_query($query_course);
		
		$query_files = sprintf("SELECT file.id,file.filename 
			FROM file,user_file 
			WHERE user_file.user_id='%s' AND file.id = user_file.file_id
			ORDER BY file.id DESC LIMIT 10",
			mysql_real_escape_string($_SESSION["id"]));		

		print ("Bienvenid@:<br>\n");
		
		/* Listar los cursos y hacer enlaces a los mismos */
		print ("<br><b>Mis Cursos:</b><br>\n");
		
		while ($row = mysql_fetch_assoc($result_course)) {
			/* Marcar los cursos que en los cuales soy profesor*/
			if ($row["is_prof"] == 1) {
				$is_prof = "(*)";
			} else {
				$is_prof = "";
			}
			
			/* Guardar los cursos en un array */		
			$course_id = $row["course_id"];
			if (isset($course_list)) {
			
				array_push($course_list, $course_id);
			
			} else {
			
				$course_list = array( '0' => $row["course_id"]);
			
			}
			 
			echo "<a href=\"./course.php?id=". $row["course_id"] ."\">". $row["name"] . ": " . $row["description"] . "</a> ". $is_prof ."<br>\n";
			
		}
		
		
		echo "<a href=\"./course.php\">Todos</a><br>\n";
		
		/* Listar los ultimos archivos subidos por el usuario */
		$result_files = mysql_query($query_files);
		/* Control de ejecucion */
		if (!$result_files) {
			$message  = 'Sentencia invalida: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query_course;
			die($message);
		}
		
		if (mysql_fetch_row($result_files)) {
			echo "<br><b>Mis ultimos archivos:</b><br>\n";
			
			$result_files = mysql_query($query_files);
			
			while ($row = mysql_fetch_assoc($result_files)) {
				echo "<a href=\"./file.php?id=". $row["id"] ."\">". $row["filename"] . "</a><br>\n";
				
				/* Guardar los cursos en un array */		
				$file_id = $row["id"];
				if (isset($file_list)) {
				
					array_push($file_list, $file_id);
				
				} else {
				
					$file_list = array( '0' => $row["id"]);
				
				}
				
			}
			
			echo "<a href=\"./file.php\">Todos</a><br>\n";
		
		}
		
	} else {
		
		Print "<h1>Usuario deshabilitado</h1>";
		session_destroy ();
	}

} else {
	
	header("Location: ./login.html");
	session_destroy ();
	
}

mysql_close($server);

?>

<?php
include ("./footer.php");
?>
