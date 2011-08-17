<?php
session_start();
header("Cache-control: private");
if ($_SESSION["access"] == "granted")
  $user = $_GET["user"];
  print "Hello $user";
else
  header("Location: ./login.html");
?>
