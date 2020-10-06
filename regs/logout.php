<?php
session_start();  
$home_url = 'http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/../login.php';
if(isset($_SESSION["role"])) {
	$_SESSION = array();
       	session_destroy();
}
header('Location: ' . $home_url);
?>
