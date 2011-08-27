<?php 
include ("./header.php");
?>

<?php
session_start();

header("Cache-control: private");
if ($_SESSION["access"] == "granted") {
	if (isset($_SESSION["enabled"]) AND $_SESSION["enabled"] == 1) {
		/* Establecer la conexion a la base de datos */
		$server = mysql_connect("localhost", "filepush", "filepush"); 
		if (!$server) die(mysql_error());
		mysql_select_db("filepush");
  
		/* Sentencia: buscar en la base de datos los cursos en los cuales participa,
		 * y si es profesor, el usuario en cuestion */
		$query_course = sprintf("SELECT user_course.course_id,user_course.is_prof,course.name, course.description
			FROM user_course,course 
			WHERE user_course.user_id='%s' AND course.id = user_course.course_id 
			ORDER BY course_id",
			mysql_real_escape_string($_SESSION["id"]));
		/* Hacer la consulta */
		$result_course = mysql_query($query_course);

		/* Cntrol de ejecucion */
		if (!$result_course) {
			$message  = 'Sentencia invalida: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query_course;
			die($message);
		}
		
		/* Consulta para los archivos de usuario
		* $query_files = sprintf("SELECT user_course.course_id,user_course.is_prof,course.name, course.description
		*	FROM user_course,course 
		*	WHERE user_course.user_id='%s' AND course.id = user_course.course_id 
		*	ORDER BY course_id",
		*	mysql_real_escape_string($_SESSION["id"]));
		*
		* $result_files = mysql_query($query_course); */
		
		/* Impresion de los resultados */
		
		print ("Bienvenid@:<br>\n");
		
		/* Listar los cursos y hacer enlaces a los mismos */
		print ("<b>Cursos:</b><br>\n");
		
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
			 
			print ('<a href="./course.php?id='. $row["course_id"] .'">' . $row["name"] . ': ' . $row["description"] . '</a> '. $is_prof .'<br>' . "\n");
			
		}
		/* Guardar el array de cursos en la sesion */
		$_SESSION["courses"] = &$course_list;
		
		
		print ('<a href="./course.php">Todos</a>' . "\n");
		
		
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
