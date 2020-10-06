<?php
	// Start the session
	session_start();

	// Insert the page header
	//$page_title = 'Welcome!';
	require_once('header.php');

	require_once('connectvars.php');
	// Show the navigation menu
  	require_once('navmenu.php');
	
  	if (isset($_SESSION['user_id'])) {
        $db = new PDO("mysql:host=localhost;dbname=commiters", DB_USER, DB_PASSWORD);
        $query = file_get_contents("Ads.sql");
        $stmt = $db->prepare($query);
        if ($stmt->execute())
            header('Location:logout.php');        
        else 
            echo "DB reset fail";
    }

?>