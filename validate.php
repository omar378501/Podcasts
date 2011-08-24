<?php
/* get the incoming ID and password hash */
$user = $_POST["username"];
$pass = sha1($_POST["password"]);

/* establish a connection with the database */

$server = mysql_connect("localhost", "filepush", "filepush");

if (!$server) die(mysql_error());

mysql_select_db("filepush");
  
/* SQL statement to query the database */
$query = "SELECT * FROM user WHERE username = '$user' AND password = '$pass'";

/* query the database */
$result = mysql_query($query);

/* Allow access if a matching record was found, else deny access. */
if (mysql_fetch_row($result)) {
	/* access granted */
	while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
		
		printf("ID: %s ", $row[0]);  
		$user_id = $row[0];
	}	
	
	session_start();
	header("Cache-control: private");
	$_SESSION["access"] = "granted";
	$_SESSION["username"] = $user;
	$_SESSION["id"] = $user_id;
  
	#header("Location: ./user.php?user=$user");
} else
  /* access denied &#8211; redirect back to login */
  header("Location: ./login.html");

mysql_close($server);  
?>
