<?php
session_start();
header("Cache-control: private");
if ($_SESSION["access"] == "granted")

  $user = $_GET["user"];
  
  if ( ! isset($_SESSION['user']) )
	$_SESSION['user'] = $user;
	
  print "Hello $_SESSION['user']";

else

  header("Location: ./login.html");
?>
