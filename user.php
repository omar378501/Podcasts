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
		/* Hacer la consulta de cursos*/
		$result_course = mysql_query($query_course);
		
                /* Sentencia: mostrar los archivos de los cursos en los cuales el usuario
                * es participe, pero los archivos que el no es propietario */
                $query_all_files = sprintf("SELECT file.id,file.filename,file.description
                        FROM file,file_course,user_file,user_course
                        WHERE user_course.user_id = '%s' 
                        AND file_course.course_id = user_course.course_id
                        AND file.id = file_course.file_id
                        AND user_file.user_id = user_course.user_id
                        AND NOT file.id = user_file.user_id
                        ORDER BY file.id DESC LIMIT 10",
                        mysql_real_escape_string($_SESSION["id"]) );
                $result_all_files = mysql_query($query_all_files);
                
                /* Sentencia: buscar todos los archivos en los cuales soy dueno*/
		$query_my_files = sprintf("SELECT file.id,file.filename 
			FROM file,user_file 
			WHERE user_file.user_id='%s' AND file.id = user_file.file_id
			ORDER BY file.id DESC LIMIT 10",
			mysql_real_escape_string($_SESSION["id"]));		
		/* Hacer la consulta de archivos*/
		$result_my_files = mysql_query($query_my_files);
		
                print ("Bienvenid@:<br>\n");
		
		/* Listar los cursos y hacer enlaces a los mismos */
		print ("<br><b>Mis Cursos:</b><br>\n");
		
                $result_course = mysql_query($query_course);
		/* Control de ejecucion */
		if (!$result_course) {
			$message  = 'Sentencia invalida: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query_course;
			die($message);
                        
		} else {
                        
                        while ($row = mysql_fetch_assoc($result_course)) {
			/* Marcar los cursos que en los cuales soy profesor*/
			if ($row["is_prof"] == 1) {
				$is_prof = "(*)";
			} else {
				$is_prof = "";
			}
			echo "<a href=\"./course.php?course_id=". $row["course_id"] ."\">". $row["name"] . ": " . $row["description"] . "</a> ". $is_prof ."<br>\n";
			
                        }
		
                }
		echo "<a href=\"./course.php\">Todos</a><br>\n";
		
		/* Control de ejecucion */
		if (!$result_all_files) {
			$message  = 'Sentencia invalida: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query_course;
			die($message);
		} else {
                    
                        echo "<br><b>Ultimos archivos:</b><br>\n";

                        while ($row = mysql_fetch_assoc($result_all_files)) {
				echo "<a href=\"./file.php?id=". $row["id"] ."\">". $row["filename"] . "</a><br>\n";
				
				
			}
			echo "<a href=\"./file.php\">Todos</a><br>\n";
		
		}
		/* Control de ejecucion */
		if (!$result_my_files) {
			$message  = 'Sentencia invalida: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query_course;
			die($message);
		} else {
                    
                        echo "<br><b>Mis archivos:</b><br>\n";

                        while ($row = mysql_fetch_assoc($result_my_files)) {
				echo "<a href=\"./file.php?id=". $row["id"] ."\">". $row["filename"] . "</a><br>\n";
				
				
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
