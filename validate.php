<?php
/* get the incoming ID and password hash */
$user = $_POST["username"];
$pass = sha1($_POST["password"]);

/* establish a connection with the database */
$server = mysql_connect("localhost", "mysql_user",
          "mysql_password");
if (!$server) die(mysql_error());
mysql_select_db("myDatabase");
  
/* SQL statement to query the database */
$query = "SELECT * FROM Users WHERE username = '$user'
         AND password = '$pass'";

/* query the database */
$result = mysql_query($query);

/* Allow access if a matching record was found, else deny access. */
if (mysql_fetch_row($result))
  echo "Access Granted: Welcome, $user!";
else
  echo "Access Denied: Invalid Credentials.";

mysql_close($server);  
?>
