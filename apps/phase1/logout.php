<?php
  // TODO: start session
  session_start();

  // TODO: If the user is logged in, delete the session vars to log them out
  if ((isset($_SESSION['uid']) && isset($_SESSION['typeUser'])) || (isset($_SESSION['email']))) {
    $_SESSION = array();
    session_destroy();
  }
    // TODO: Redirect to the login page
    header('Location: http://gwupyterhub.seas.gwu.edu/~sp20DBp2-dynamo/dynamo/login.php');
  
?>