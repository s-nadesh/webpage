<?php
session_start(); //to ensure you are using same session
include("config.php");
session_destroy(); //destroy the session
header("Location: " . SITE_URL); //to redirect back to "index.php" after logging out
exit();
?>