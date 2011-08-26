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

		/* control de ejecucion */
		if (!$result_course) {
			$message  = 'Sentencia invalida: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query_course;
			die($message);
		}
		
		print ("Bienvenid@:</br>\n");
		print ("<b>Cursos:</b></br>\n");
		
		while ($row = mysql_fetch_row($result_course)) {
			if ($row["1"] == 1) {
				$is_prof = "(prof)";
			} else {
				$is_prof = "";
			}
			
			print ('<a href="./course.php?id='. $row["0"] .'">' . $row["2"] . ': ' . $row["3"] . '</a> '. $is_prof .'</br>' . "\n");
			print ('<a href="./course.php">Todos</a>');
		}
		
		
	} else {
		
		Print "<h1>Usuario deshabilitado</h1>";
		session_destroy ();
	}

} else {
	
	header("Location: ./login.html");
	session_destroy ();
	
}

?>

<?php
include ("./footer.php");
?>
