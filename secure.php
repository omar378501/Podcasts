<?php
if (mysql_fetch_row($result)) {
  /* access granted */
  session_start();
  header("Cache-control: private");
  $_SESSION["access"] = "granted";
  header("Location: ./secure.php");
} else
  /* access denied &#8211; redirect back to login */
  header("Location: ./login.html");
?>
