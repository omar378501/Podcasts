<?php
/* Obtener los valor de usuario y hash de contrasena */
$user = $_POST["username"];
$pass = sha1($_POST["password"]);

/* Establecer la conexion a la base de datos */
$server = mysql_connect("localhost", "filepush", "filepush");

if (!$server) die(mysql_error());

mysql_select_db("filepush");
  
/* Sentencia de SQL para buscar en la base de datos */
$query = sprintf("SELECT id,username FROM user WHERE username='%s' AND password='%s'",
	mysql_real_escape_string($user),
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
	$user_id = mysql_result($result, 0);
	$user_enabled = mysql_result($result, 4);
	
	
	// Inicia sesion
	session_start();
	header("Cache-control: private");
	
	// guarda algunos valores en la sesion
	$_SESSION["access"] = "granted";
	$_SESSION["username"] = $user;
	$_SESSION["id"] = $user_id;
	$_SESSION["user_enabled"] = $user_enabled;
  
	header("Location: ./user.php");
	
} else {
  /* access denied &#8211; redirect back to login */
  header("Location: ./login.html");
}

mysql_close($server);  
?>
