<?php
/* Cargar archivo de configuracion */
include ("./inc/config.php");

$user_id = $_GET["user_id"];

/* Establecer la conexion a la base de datos */
$server = mysql_connect($db_server, $db_user, $db_pass); 
if (!$server) die(mysql_error());
mysql_select_db($db_name);

/* Sentencia: mostrar los archivos de los cursos en los cuales el usuario
* es participe, pero los archivos que el no es propietario */
$query_file_list = sprintf("SELECT DISTINCT file.id,file.filename,file.description
                        FROM file,file_course,user_file,user_course,course
                        WHERE user_course.user_id = '%s' 
                        AND file_course.course_id = user_course.course_id
                        AND file.id = file_course.file_id
                        AND NOT user_file.user_id = user_course.user_id 
                        AND file.id = user_file.file_id
                        ORDER BY file.id DESC LIMIT 10",
                        mysql_real_escape_string($user_id) );

$query_course_list = sprintf("SELECT DISTINCT file.id,file.filename,file.description
                        FROM file,file_course,user_file,user_course,course
                        WHERE user_course.user_id = '%s' 
                        AND file_course.course_id = user_course.course_id
                        AND file.id = file_course.file_id
                        AND NOT user_file.user_id = user_course.user_id 
                        AND file.id = user_file.file_id
                        ORDER BY file.id DESC LIMIT 10",
                        mysql_real_escape_string($user_id) ); 

$result_file_list = mysql_query($query_file_list);

$result_course_list = mysql_query($query_course_list);

/* Control de ejecucion */
if (!$result_file_list OR !$result_course_list) {
        $message  = 'Sentencia invalida: ' . mysql_error() . "\n";
        $message .= 'Whole query: ' . $query_file_list;
        die($message);
 } else {		
        

        echo '<?xml version="1.0" encoding="utf-8"?>' . "\n";
        echo '<feed xml:lang="es-PY" xmlns="http://www.w3.org/2005/Atom">' . "\n";
        echo "\t<channel>\n";
        echo "\t<title> Portal Multimedia </title>\n";
        echo "\t<link href=\"http://www.uaa.edu.py\" />\n";
        echo "\t<author>\n\t <name>Departamento de Innovacion y Tecnologia Educativa</name>\n\t</author>\n";
                               
        while ($row = mysql_fetch_assoc($result_file_list)) {
                echo "\t\t<item>\n";
                echo "\t\t\t<title>" . $row["filename"] . "</title>\n";
                echo "\t\t\t<summary>" . $row["course_id"]. $row["name"] . $row["description"] . "</summary>\n";
                echo "\t\t\t<link href=\"./download.php?id=" . $row["id"] . "\" />\n";
                echo "\t\t</item>\n";              
        }
        echo "\t</channel>\n";
        echo "</feed>\n";
         
         
}

?>
