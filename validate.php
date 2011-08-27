<?php
/* Obtener los valor de usuario y hash de contrasena */
$user = $_POST["username"];
$pass = sha1($_POST["password"]);

include ("./config.php");
/* Establecer la conexion a la base de datos */
$server = mysql_connect($db_server, $db_user, $db_pass); 
if (!$server) die(mysql_error());
mysql_select_db($db_name);
  
/* Sentencia de SQL para buscar en la base de datos */
$query = sprintf("SELECT id,username,email,enabled FROM user WHERE (username='%s' OR email='%s') AND password='%s'",
	mysql_real_escape_string($user), mysql_real_escape_string($user),
	mysql_real_escape_string($pass));

/* Hacer la consulta */
$result = mysql_query($query);

/* control de ejecucion */
if (!$result) {
    $message  = 'Sentencia invalida: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
}


/* Permitir el acceso solo si se encontro un match */
if (mysql_fetch_row($result)) {
	/* Acceso Permitido */
	$result = mysql_query($query);

	$row = mysql_fetch_array($result);
	$user_id = $row["id"];
	$user_email = $row["email"];
	$user_username = $row["username"];
	$enabled = $row["enabled"];
	
	
	// Inicia sesion
	session_start();
	header("Cache-control: private");
	
	// guarda algunos valores en la sesion
	$_SESSION["access"] = "granted";
	$_SESSION["username"] = $user_username;
	$_SESSION["email"] = $user_email;
	$_SESSION["id"] = $user_id;
	$_SESSION["enabled"] = $enabled;
  
	header("Location: ./user.php");
	
} else {
	
  /* Acceso negado */
  header("Location: ./login.html");
  
}

mysql_close($server);  
?>
