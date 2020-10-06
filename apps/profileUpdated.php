<?php 
    // Start the session
    session_start();

    // Set UID of logged from user session var 
    $uid = $_SESSION['uid'];

    // Include navmenu 
    require_once('navMenus/navAppPortal.php'); 

    // Include db connection vars 
    require_once('connectvars.php'); 

    // Connect to database 
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    echo "<h3> Your Profile was Updated! </h3>"; 
   
?>